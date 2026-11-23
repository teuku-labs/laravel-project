<?php

namespace Tests\Feature;

use App\Models\Dekan;
use App\Models\Dosen;
use App\Models\Kaprodi;
use App\Models\Mahasiswa;
use App\Models\NilaiSidang;
use App\Models\Prodi;
use App\Models\SeminarLkp;
use App\Models\Sidang;
use App\Models\User;
use App\Models\YudisiumSk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ZipArchive;

/**
 * Alur SK Yudisium: kaprodi memilih mahasiswa lulus sidang + isi IPK -> ajukan ke dekan
 * -> dekan isi nomor & tanggal -> SK (dengan lampiran nama) kembali ke kaprodi.
 */
class YudisiumAlurTest extends TestCase
{
    use RefreshDatabase;

    private Prodi $prodiSi;
    private Prodi $prodiTm;
    private User $kaprodiUser;
    private User $kaprodiTmUser;
    private User $dekanUser;
    private Sidang $sidangA;   // SI, lulus, punya data LKP
    private Sidang $sidangB;   // SI, penguji 2 belum menilai
    private Sidang $sidangC;   // Teknik Mesin, lulus

    protected function setUp(): void
    {
        parent::setUp();

        $this->prodiSi = Prodi::create(['nama_prodi' => 'Sistem Informasi', 'kode_prodi' => '57201']);
        $this->prodiTm = Prodi::create(['nama_prodi' => 'Teknik Mesin', 'kode_prodi' => '21201']);

        $this->kaprodiUser   = $this->user('kaprodi', 'KP1');
        $this->kaprodiTmUser = $this->user('kaprodi', 'KP2');
        $this->dekanUser     = $this->user('dekan', 'DK1');

        Kaprodi::create(['user_id' => $this->kaprodiUser->id,   'prodi_id' => $this->prodiSi->id, 'nuptk' => '1', 'nama' => 'Kaprodi SI']);
        Kaprodi::create(['user_id' => $this->kaprodiTmUser->id, 'prodi_id' => $this->prodiTm->id, 'nuptk' => '2', 'nama' => 'Kaprodi TM']);
        Dekan::create(['user_id' => $this->dekanUser->id, 'prodi_id' => $this->prodiSi->id, 'nuptk' => '3', 'nama' => 'Dekan']);

        $d1 = Dosen::create(['user_id' => $this->user('dosen', 'DS1')->id, 'prodi_id' => $this->prodiSi->id, 'nuptk' => '4', 'nama' => 'Dosen Satu']);
        $d2 = Dosen::create(['user_id' => $this->user('dosen', 'DS2')->id, 'prodi_id' => $this->prodiSi->id, 'nuptk' => '5', 'nama' => 'Dosen Dua']);

        $mA = $this->mahasiswa('Alfa Haliza', '22146039', 2022, $this->prodiSi);
        $mB = $this->mahasiswa('Budi Belum', '22146040', 2022, $this->prodiSi);
        $mC = $this->mahasiswa('Cici Mesin', '22111111', 2022, $this->prodiTm);

        SeminarLkp::create([
            'mahasiswa_id' => $mA->id, 'email' => 'a@x.id', 'nik_ktp' => '1', 'tempat_lahir' => 'Aceh Besar',
            'tanggal_lahir' => '2004-05-19', 'no_hp' => '0', 'judul_lkp' => 'x', 'file_laporan' => 'x', 'bukti_transfer' => 'x',
        ]);

        $this->sidangA = $this->sidang($mA, $d1, $d2, '2026-05-11');
        $this->sidangB = $this->sidang($mB, $d1, $d2, '2026-07-22');
        $this->sidangC = $this->sidang($mC, $d1, $d2, '2026-07-23');

        $this->nilai($this->sidangA, $d1); $this->nilai($this->sidangA, $d2);
        $this->nilai($this->sidangB, $d1);                                   // penguji 2 belum menilai
        $this->nilai($this->sidangC, $d1); $this->nilai($this->sidangC, $d2);
    }

    private function user(string $role, string $kode): User
    {
        return User::create([
            'username' => $kode, 'nim_nuptk' => $kode, 'email' => "$kode@x.id",
            'password' => bcrypt('password'), 'role' => $role,
        ]);
    }

    private function mahasiswa(string $nama, string $nim, int $angkatan, Prodi $prodi): Mahasiswa
    {
        return Mahasiswa::create([
            'user_id' => $this->user('mahasiswa', $nim)->id, 'prodi_id' => $prodi->id,
            'nim' => $nim, 'nama' => $nama, 'angkatan' => $angkatan,
        ]);
    }

    private function sidang(Mahasiswa $m, Dosen $d1, Dosen $d2, string $tanggal): Sidang
    {
        return Sidang::create([
            'mahasiswa_id' => $m->id, 'judul_skripsi' => 'Judul', 'tanggal_sidang' => $tanggal,
            'penguji1_id' => $d1->id, 'penguji2_id' => $d2->id,
            'admin_verified' => true, 'kaprodi_approved' => true, 'kaprodi_rejected' => false,
        ]);
    }

    private function nilai(Sidang $s, Dosen $d): void
    {
        NilaiSidang::create([
            'sidang_id' => $s->id, 'dosen_id' => $d->id,
            'isi_materi' => 80, 'penyajian' => 80, 'penguasaan_materi' => 80, 'sikap_mental' => 80,
            'rata_rata' => 80, 'nilai_huruf' => 'A-',
        ]);
    }

    private function ajukanA(array $override = [])
    {
        $id = $this->sidangA->id;

        return $this->actingAs($this->kaprodiUser)->post(route('kaprodi.yudisium.ajukan'), array_replace_recursive([
            'sidang_ids'    => [$id],
            'ipk'           => [$id => '3,89'],
            'tempat_lahir'  => [$id => 'Aceh Besar'],
            'tanggal_lahir' => [$id => '2004-05-19'],
        ], $override));
    }

    // ------------------------------------------------------------------ kaprodi: daftar kandidat

    public function test_kaprodi_hanya_melihat_mahasiswa_prodinya_yang_lulus_sidang(): void
    {
        $res = $this->actingAs($this->kaprodiUser)->get(route('kaprodi.yudisium.index'));

        $res->assertOk();
        $res->assertSee('Alfa Haliza');
        $res->assertSee('Aceh Besar');      // tempat lahir terisi dari data LKP
        $res->assertSee('2004-05-19');
        $res->assertDontSee('Budi Belum');  // nilai penguji belum lengkap
        $res->assertDontSee('Cici Mesin');  // prodi lain
    }

    // ------------------------------------------------------------------ kaprodi: pengajuan

    public function test_pengajuan_tanpa_ipk_ditolak(): void
    {
        $id = $this->sidangA->id;

        $this->ajukanA(['ipk' => [$id => '']])->assertSessionHasErrors("ipk.$id");

        $this->assertSame(0, YudisiumSk::count());
    }

    public function test_ipk_di_atas_4_atau_lebih_dari_dua_desimal_ditolak(): void
    {
        $id = $this->sidangA->id;

        $this->ajukanA(['ipk' => [$id => '4,50']])->assertSessionHasErrors("ipk.$id");
        $this->ajukanA(['ipk' => [$id => '3.891']])->assertSessionHasErrors("ipk.$id");
        $this->assertSame(0, YudisiumSk::count());
    }

    public function test_setelah_validasi_gagal_isian_dan_centang_dipertahankan_dan_pesan_tampil(): void
    {
        $id = $this->sidangA->id;

        $res = $this->from(route('kaprodi.yudisium.index'))->actingAs($this->kaprodiUser)
            ->followingRedirects()
            ->post(route('kaprodi.yudisium.ajukan'), [
                'sidang_ids'    => [$id],
                'ipk'           => [$id => ''],
                'tempat_lahir'  => [$id => 'Banda Aceh'],
                'tanggal_lahir' => [$id => '2004-05-20'],
            ]);

        $res->assertOk();
        $res->assertSee('IPK Alfa Haliza wajib diisi.');
        $res->assertSee('Banda Aceh');                                   // koreksi kaprodi tidak hilang
        $res->assertSee('value="' . $id . '" checked', false);           // baris tetap tercentang
    }

    public function test_pengajuan_berhasil_menyimpan_lampiran_dan_menandai_sidang(): void
    {
        $this->ajukanA()->assertRedirect(route('kaprodi.yudisium.index'))->assertSessionHasNoErrors();

        $sk = YudisiumSk::first();
        $this->assertSame(YudisiumSk::DIAJUKAN, $sk->status);
        $this->assertSame($this->prodiSi->id, $sk->prodi_id);
        $this->assertNull($sk->nomor_sk);

        $a = $sk->anggota()->first();
        $this->assertSame('3.89', (string) $a->ipk);                 // koma diterima, disimpan 3.89
        $this->assertSame('Aceh Besar', $a->tempat_lahir);
        $this->assertSame($sk->id, $this->sidangA->fresh()->yudisium_sk_id);

        // sudah masuk pengajuan -> hilang dari daftar kandidat
        $this->actingAs($this->kaprodiUser)->get(route('kaprodi.yudisium.index'))->assertDontSee('name="sidang_ids[]"', false);
    }

    public function test_tempat_tanggal_lahir_bisa_dikoreksi_tanpa_mengubah_data_lkp(): void
    {
        $id = $this->sidangA->id;
        $this->ajukanA(['tempat_lahir' => [$id => 'Banda Aceh'], 'tanggal_lahir' => [$id => '2004-05-20']]);

        $a = YudisiumSk::first()->anggota()->first();
        $this->assertSame('Banda Aceh', $a->tempat_lahir);
        $this->assertSame('Aceh Besar', SeminarLkp::first()->tempat_lahir);   // LKP tidak berubah
    }

    public function test_kaprodi_tidak_bisa_mengajukan_mahasiswa_prodi_lain_atau_yang_belum_lulus(): void
    {
        foreach ([$this->sidangC, $this->sidangB] as $s) {
            $this->actingAs($this->kaprodiUser)->post(route('kaprodi.yudisium.ajukan'), [
                'sidang_ids'    => [$s->id],
                'ipk'           => [$s->id => '3.5'],
                'tempat_lahir'  => [$s->id => 'X'],
                'tanggal_lahir' => [$s->id => '2000-01-01'],
            ])->assertSessionHasErrors('sidang_ids');
        }

        $this->assertSame(0, YudisiumSk::count());
        $this->assertNull($this->sidangC->fresh()->yudisium_sk_id);
    }

    public function test_tidak_bisa_mengajukan_mahasiswa_yang_sama_dua_kali(): void
    {
        $this->ajukanA();
        $this->ajukanA()->assertSessionHasErrors('sidang_ids');

        $this->assertSame(1, YudisiumSk::count());
    }

    public function test_tanpa_memilih_mahasiswa_ditolak(): void
    {
        $this->actingAs($this->kaprodiUser)->post(route('kaprodi.yudisium.ajukan'), [])->assertSessionHasErrors('sidang_ids');
    }

    // ------------------------------------------------------------------ tarik kembali

    public function test_pengajuan_bisa_ditarik_selama_dekan_belum_memproses(): void
    {
        $this->ajukanA();
        $sk = YudisiumSk::first();

        $this->actingAs($this->kaprodiUser)->delete(route('kaprodi.yudisium.batal', $sk->id))->assertSessionHas('success');

        $this->assertSame(0, YudisiumSk::count());
        $this->assertSame(0, \DB::table('yudisium_sk_mahasiswa')->count());
        $this->assertNull($this->sidangA->fresh()->yudisium_sk_id);
        $this->actingAs($this->kaprodiUser)->get(route('kaprodi.yudisium.index'))->assertSee('Alfa Haliza');
    }

    public function test_pengajuan_tidak_bisa_ditarik_setelah_terbit_atau_oleh_prodi_lain(): void
    {
        $this->ajukanA();
        $sk = YudisiumSk::first();

        $this->actingAs($this->kaprodiTmUser)->delete(route('kaprodi.yudisium.batal', $sk->id))->assertSessionHasErrors('sk');
        $this->assertSame(1, YudisiumSk::count());

        $this->terbitkan($sk);
        $this->actingAs($this->kaprodiUser)->delete(route('kaprodi.yudisium.batal', $sk->id))->assertSessionHasErrors('sk');
        $this->assertSame(1, YudisiumSk::count());
    }

    // ------------------------------------------------------------------ dekan

    private function terbitkan(YudisiumSk $sk, string $nomor = '03/FT.01J/VIII/2026', string $tanggal = '2026-08-28')
    {
        return $this->actingAs($this->dekanUser)->post(route('dekan.sk-yudisium.simpan', $sk->id), [
            'nomor_sk' => $nomor, 'tanggal_sk' => $tanggal,
        ]);
    }

    public function test_dekan_melihat_pengajuan_dan_menerbitkan_sk(): void
    {
        $this->ajukanA();
        $sk = YudisiumSk::first();

        $this->actingAs($this->dekanUser)->get(route('dekan.sk-yudisium.index'))
            ->assertOk()->assertSee('Sistem Informasi')->assertSee('Alfa Haliza')->assertSee('Menunggu nomor SK');

        $this->terbitkan($sk)->assertSessionHasNoErrors();

        $sk->refresh();
        $this->assertSame(YudisiumSk::TERBIT, $sk->status);
        $this->assertSame('03/FT.01J/VIII/2026', $sk->nomor_sk);
        $this->assertTrue($sk->sudahTerbit());
    }

    public function test_dekan_wajib_mengisi_nomor_dan_tanggal(): void
    {
        $this->ajukanA();
        $sk = YudisiumSk::first();

        $this->terbitkan($sk, '', '2026-08-28')->assertSessionHasErrors('nomor_sk');
        $this->terbitkan($sk, 'X/1', '')->assertSessionHasErrors('tanggal_sk');
        $this->assertSame(YudisiumSk::DIAJUKAN, $sk->fresh()->status);
    }

    public function test_tanggal_sk_tidak_boleh_sebelum_tanggal_sidang(): void
    {
        $this->ajukanA();   // sidang A: 11 Mei 2026
        $sk = YudisiumSk::first();

        $this->terbitkan($sk, 'X/1', '2026-05-01')->assertSessionHasErrors('tanggal_sk');
        $this->assertSame(YudisiumSk::DIAJUKAN, $sk->fresh()->status);
    }

    public function test_nomor_sk_tidak_boleh_kembar_tetapi_boleh_disimpan_ulang_untuk_sk_sendiri(): void
    {
        $this->ajukanA();
        $sk1 = YudisiumSk::first();
        $this->terbitkan($sk1)->assertSessionHasNoErrors();
        $this->terbitkan($sk1)->assertSessionHasNoErrors();                 // simpan ulang nomor yang sama = boleh

        $mB = Mahasiswa::where('nim', '22146040')->first();
        $this->nilai($this->sidangB, Dosen::where('nama', 'Dosen Dua')->first());   // B kini lulus
        $idB = $this->sidangB->id;
        $this->actingAs($this->kaprodiUser)->post(route('kaprodi.yudisium.ajukan'), [
            'sidang_ids' => [$idB], 'ipk' => [$idB => '3.5'], 'tempat_lahir' => [$idB => 'X'], 'tanggal_lahir' => [$idB => '2000-01-01'],
        ])->assertSessionHasNoErrors();
        $sk2 = YudisiumSk::where('id', '!=', $sk1->id)->first();

        $this->terbitkan($sk2, '03/FT.01J/VIII/2026')->assertSessionHasErrors('nomor_sk');
    }

    // ------------------------------------------------------------------ SK kembali ke kaprodi

    public function test_sk_belum_bisa_diunduh_sebelum_terbit(): void
    {
        $this->ajukanA();
        $sk = YudisiumSk::first();

        $this->actingAs($this->kaprodiUser)->get(route('kaprodi.sk-yudisium.unduh', $sk->id))->assertNotFound();
        $this->actingAs($this->kaprodiUser)->get(route('kaprodi.sk-yudisium.index'))->assertOk()->assertSee('Menunggu dekan');
    }

    public function test_kaprodi_mengunduh_sk_dengan_lampiran_nama_dan_ipk(): void
    {
        $this->ajukanA();
        $sk = YudisiumSk::first();
        $this->terbitkan($sk);

        $this->actingAs($this->kaprodiUser)->get(route('kaprodi.sk-yudisium.index'))
            ->assertOk()->assertSee('03/FT.01J/VIII/2026')->assertSee('Terbit')->assertSee('Unduh SK');

        $res = $this->actingAs($this->kaprodiUser)->get(route('kaprodi.sk-yudisium.unduh', $sk->id));
        $res->assertOk();
        $this->assertStringContainsString('SK-Yudisium-Sistem-Informasi-03-FT-01J-VIII-2026.docx', $res->headers->get('content-disposition'));

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($res->baseResponse->getFile()->getPathname()) === true);
        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        foreach (['03/FT.01J/VIII/2026', '28 Agustus 2026', 'SEMESTER GENAP', '2025-2026', 'SISTEM INFORMASI',
                  'Alfa Haliza', '22146039', 'Aceh Besar, 19 Mei 2004', '3.89', '131003', '57201', '20221', '20252', '11/05/26'] as $teks) {
            $this->assertStringContainsString($teks, $xml, "Dokumen SK tidak memuat: $teks");
        }
        $this->assertStringNotContainsString('{{', $xml);                    // tidak ada penanda tersisa
        $this->assertStringNotContainsString('Budi Belum', $xml);
    }

    public function test_kaprodi_prodi_lain_tidak_bisa_mengunduh_atau_melihat_sk(): void
    {
        $this->ajukanA();
        $sk = YudisiumSk::first();
        $this->terbitkan($sk);

        $this->actingAs($this->kaprodiTmUser)->get(route('kaprodi.sk-yudisium.unduh', $sk->id))->assertNotFound();
        $this->actingAs($this->kaprodiTmUser)->get(route('kaprodi.sk-yudisium.index'))->assertOk()->assertDontSee('03/FT.01J/VIII/2026');
    }

    public function test_dekan_bisa_mencetak_hanya_sk_yang_sudah_terbit(): void
    {
        $this->ajukanA();
        $sk = YudisiumSk::first();

        $this->actingAs($this->dekanUser)->get(route('dekan.sk-yudisium.cetak', $sk->id))->assertSessionHasErrors('sk');

        $this->terbitkan($sk);
        $this->actingAs($this->dekanUser)->get(route('dekan.sk-yudisium.cetak', $sk->id))->assertOk();
    }

    public function test_halaman_yudisium_tidak_bisa_diakses_role_lain(): void
    {
        $this->actingAs($this->dekanUser)->get(route('kaprodi.yudisium.index'))->assertRedirect();
        $this->actingAs($this->kaprodiUser)->get(route('dekan.sk-yudisium.index'))->assertRedirect();
    }
}