<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $notulen->judul_rapat ?? $notulen->judul }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color: #222; font-size: 12px; }
        h1 { font-size: 18px; margin: 0 0 4px 0; }
        h2 { font-size: 14px; margin: 8px 0 12px 0; color: #444; }
        .muted { color: #666; font-size: 11px; }
        .section { margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        td { vertical-align: top; padding: 4px 0; }
        hr { border: none; border-top: 1px solid #ddd; margin: 10px 0; }
        .agenda-title { font-weight: bold; margin: 6px 0 2px 0; }
        .content { line-height: 1.4; }
    </style>
</head>
<body>
    <header>
        <h1>{{ $notulen->judul_rapat ?? $notulen->judul }}</h1>
        <div class="muted">{{ $notulen->tipe_rapat ?? '' }} @if($notulen->tanggal_rapat) — {{ \Carbon\Carbon::parse($notulen->tanggal_rapat)->format('d F Y') }}@endif</div>
    </header>

    <hr />

    <div class="section">
        <h2>Informasi</h2>
        <table>
            <tr>
                <td style="width:30%"><strong>Kegiatan</strong></td>
                <td>{{ optional($notulen->kegiatan)->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>{{ $notulen->tanggal_rapat ? \Carbon\Carbon::parse($notulen->tanggal_rapat)->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td><strong>Waktu</strong></td>
                <td>
                    @if($notulen->waktu_mulai && $notulen->waktu_selesai)
                        {{ \Carbon\Carbon::parse($notulen->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($notulen->waktu_selesai)->format('H:i') }}
                    @elseif($notulen->waktu_mulai)
                        {{ \Carbon\Carbon::parse($notulen->waktu_mulai)->format('H:i') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Lokasi</strong></td>
                <td>{{ $notulen->lokasi ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Pimpinan</strong></td>
                <td>{{ optional($notulen->pimpinan->users)->nama ?? $notulen->pimpinan_rapat_nama ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Notulis</strong></td>
                <td>{{ optional($notulen->notulis->users)->nama ?? $notulen->notulis_nama ?? '-' }}</td>
            </tr>
        </table>
    </div>

    @php
        $presensi = \App\Models\PresensiKehadiran::where('presensiable_id', $notulen->id)
                    ->where('presensiable_type', 'App\Models\Notulen')
                    ->get();
    @endphp

    @if($presensi && $presensi->count())
        <div class="section">
            <h2>Peserta yang Hadir</h2>
            <table style="border: 1px solid #ddd;">
                <tr style="background: #f5f5f5; font-weight: bold;">
                    <td style="border: 1px solid #ddd; padding: 4px 6px; width: 5%;">No</td>
                    <td style="border: 1px solid #ddd; padding: 4px 6px;">Nama</td>
                    <td style="border: 1px solid #ddd; padding: 4px 6px; width: 30%;">Keterangan</td>
                </tr>
                @foreach($presensi as $index => $p)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 4px 6px;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid #ddd; padding: 4px 6px;">{{ $p->peserta_nama ?? '-' }}</td>
                        <td style="border: 1px solid #ddd; padding: 4px 6px;">{{ $p->keterangan_kehadiran ?? '-' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    <div class="section">
        <h2>Agenda & Keputusan</h2>
        @foreach($notulen->agenda as $index => $a)
            <div class="agenda">
                <div class="agenda-title">{{ $index + 1 }}. {{ $a->topik ?? 'Agenda' }}</div>
                <div class="content">{!! $a->hasil_pembahasan !!}</div>
                <div class="muted">Status: {{ $a->status }}</div>
                <hr />
            </div>
        @endforeach
    </div>

    <div class="section">
        <h2>Catatan Tambahan</h2>
        <div class="content">{!! $notulen->catatan_tambahan ?? '-' !!}</div>
    </div>

    @if($notulen->dokumentasi->count())
        <div class="section">
            <h2>Dokumentasi</h2>
            <ul>
                @foreach($notulen->dokumentasi as $doc)
                    <li>{{ basename($doc->path) }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</body>
</html>
