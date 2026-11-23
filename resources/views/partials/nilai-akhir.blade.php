@php
    $na = $item->nilaiAkhir();
    $muted = 'color:var(--muted);font-size:.78rem;';
@endphp
@foreach([1, 2] as $ke)
    @php $nPenguji = $item->nilaiPengujiKe($ke); @endphp
    <td>
        @if(!$item->{'penguji'.$ke.'_id'})
            -
        @elseif($nPenguji)
            {{ $nPenguji->rata_rata }} <span class="badge-huruf">{{ $nPenguji->nilai_huruf }}</span>
            <div style="{{ $muted }}">{{ $item->{'penguji'.$ke}->nama ?? '' }}</div>
        @else
            <span style="{{ $muted }}">Belum menilai</span>
            <div style="{{ $muted }}">{{ $item->{'penguji'.$ke}->nama ?? '' }}</div>
        @endif
    </td>
@endforeach
<td>
    @if($na && $na['lengkap'])
        <strong>{{ number_format($na['rata_rata'], 2) }}</strong> <span class="badge-huruf">{{ $na['nilai_huruf'] }}</span>
    @elseif($na)
        <span style="{{ $muted }}">Menunggu penguji lain ({{ $na['jumlah_masuk'] }}/{{ $na['jumlah_penguji'] }})</span>
    @else
        -
    @endif
</td>