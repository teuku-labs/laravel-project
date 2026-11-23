<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIK – Aplikasi Seminar Interaktif dan Kreatif</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --green: #1B7A43;
            --green-light: #23904f;
            --green-dark: #17693a;
            --ink: #10301f;
            --muted: #41584a;
            --gold: #FFC93C;
            --cream: #FFF3CF;
            --mint: #eaf6ee;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--ink);
            background: #ffffff;
        }

        /* ===== HERO ===== */
        .hero {
            position: relative;
            overflow: hidden;
            background: var(--green);
            color: #ffffff;
            padding: 90px 0 160px;
        }
        .hero::before,
        .hero::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            z-index: 0;
        }
        .hero::before {
            width: 480px; height: 480px;
            right: -150px; top: -180px;
            background: var(--green-light);
        }
        .hero::after {
            width: 360px; height: 360px;
            left: -120px; bottom: -200px;
            background: var(--green-dark);
        }
        .hero .container { position: relative; z-index: 1; }

        .hero-pill {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 999px;
            background: rgba(0, 0, 0, 0.18);
            font-size: 13px;
            font-weight: 500;
        }
        .hero h1 {
            font-size: clamp(64px, 9vw, 96px);
            font-weight: 700;
            letter-spacing: 3px;
            line-height: 1;
            margin: 20px 0 0;
        }
        .hero-subtitle {
            font-size: clamp(20px, 2.4vw, 26px);
            font-weight: 600;
            color: var(--gold);
            margin: 10px 0 18px;
        }
        .hero-tagline {
            font-size: 18px;
            max-width: 480px;
            color: #e6f4ea;
        }
        .btn-asik {
            display: inline-block;
            padding: 14px 36px;
            border-radius: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .btn-asik:hover { transform: translateY(-2px); }
        .btn-asik.primary { background: var(--gold); color: #2a2000; border: 2px solid var(--gold); }
        .btn-asik.primary:hover { color: #2a2000; box-shadow: 0 8px 20px rgba(0,0,0,.2); }
        .btn-asik.outline { background: transparent; color: #ffffff; border: 2px solid #ffffff; }
        .btn-asik.outline:hover { color: #ffffff; background: rgba(255,255,255,.12); }
        .hero-note { font-size: 13px; color: #cfe8d8; }

        .hero-panel {
            background: var(--mint);
            border-radius: 40px;
            height: 440px;
            max-width: 440px;
            margin-left: auto;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            overflow: hidden;
        }
        .hero-panel img {
            height: 410px;
            max-width: 100%;
            object-fit: contain;
        }

        /* ===== PENGUMUMAN KAPRODI ===== */
        .ann-wrap { margin-top: -86px; position: relative; z-index: 2; }
        .ann {
            background: var(--cream);
            border-radius: 36px;
            padding: 28px 32px;
            box-shadow: 0 14px 34px rgba(16, 48, 31, 0.12);
        }
        .ann-title { font-weight: 700; font-size: 20px; margin: 0; }
        .ann-sub { font-size: 14px; color: var(--muted); margin: 0; }
        .ann-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 14px 18px;
            height: 100%;
        }
        .ann-card .name { font-weight: 600; }
        .ann-card .period { font-size: 14px; color: var(--muted); }
        .chip {
            display: inline-block;
            margin-top: 8px;
            padding: 3px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }
        .chip.dibuka  { background: var(--green); color: #ffffff; }
        .chip.ditutup { background: #d9dedb; color: #33423a; }
        .chip.belum   { background: #e8ecef; color: #33423a; }

        /* ===== FOOTER ===== */
        .foot { padding: 56px 0 28px; font-size: 13px; color: var(--muted); }

        @media (max-width: 991px) {
            .hero { padding: 64px 0 150px; }
            .hero-panel { margin: 40px auto 0; height: 380px; }
            .hero-panel img { height: 350px; }
        }
    </style>
</head>
<body>

@php
    /*
     * Data pengumuman kaprodi (sementara statis).
     * status : 'dibuka' | 'ditutup' | 'belum'
     * periode: teks bebas, mis. '12 Mei – 30 Mei 2026' (null = belum diumumkan)
     * Nanti bagian ini diganti data dari database.
     */
    $pengumuman = [
        ['nama' => 'Seminar LKP',      'status' => 'belum', 'periode' => null],
        ['nama' => 'Seminar Proposal', 'status' => 'belum', 'periode' => null],
        ['nama' => 'Sidang Skripsi',   'status' => 'belum', 'periode' => null],
    ];
    $labelStatus = ['dibuka' => 'Dibuka', 'ditutup' => 'Ditutup', 'belum' => 'Belum dibuka'];
@endphp

    <!-- HERO -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="hero-pill">Universitas Abulyatama</span>
                    <h1>ASIK</h1>
                    <div class="hero-subtitle">Aplikasi Seminar Interaktif dan Kreatif</div>
                    <p class="hero-tagline">
                        Dari memilih pembimbing sampai sidang skripsi, setiap tahap tercatat dan bisa Anda pantau dalam satu aplikasi.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        <a href="{{ route('login') }}" class="btn-asik primary">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-asik outline">Daftar Mahasiswa</a>
                    </div>
                    <div class="hero-note">Dosen, Kaprodi, dan Dekan: akun dibuat oleh admin, langsung Masuk.</div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-panel">
                        <img src="{{ asset('img/graduate.png') }}" alt="Ilustrasi mahasiswa berjubah wisuda membawa gulungan ijazah dan berkas">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PENGUMUMAN KAPRODI -->
    <div class="container ann-wrap">
        <div class="ann">
            <div class="row align-items-center g-3">
                <div class="col-lg-3">
                    <p class="ann-title">Pengumuman Kaprodi</p>
                    <p class="ann-sub">Pendaftaran yang sedang dibuka</p>
                </div>
                <div class="col-lg-9">
                    <div class="row g-3">
                        @foreach ($pengumuman as $p)
                            <div class="col-md-4">
                                <div class="ann-card">
                                    <div class="name">{{ $p['nama'] }}</div>
                                    <div class="period">{{ $p['periode'] ?? 'Periode belum diumumkan' }}</div>
                                    <span class="chip {{ $p['status'] }}">{{ $labelStatus[$p['status']] ?? 'Belum dibuka' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER SINGKAT -->
    <footer class="foot text-center">
        &copy; {{ date('Y') }} ASIK &middot; Universitas Abulyatama
    </footer>

</body>
</html>