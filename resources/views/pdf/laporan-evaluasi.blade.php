<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kepuasan Pelayanan Mess</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #59A338; /* Green */
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header img {
            max-height: 50px;
            margin-bottom: 5px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #2E7D32; /* Dark Green */
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #2E7D32; /* Dark Green */
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-center {
            text-align: center;
        }
        .summary-box {
            background-color: #F4F8F4;
            border: 1px solid #59A338;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .summary-box h3 {
            margin: 0 0 5px 0;
            color: #2E7D32;
        }
        .footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: right;
            color: #777;
        }
        .saran {
            font-style: italic;
            color: #555;
            font-size: 11px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('logofr.png') }}" alt="FR Academy Logo">
        <h1>FR Academy Mess</h1>
        <p>Laporan Kepuasan Pelayanan Mess</p>
        <p style="font-size: 12px;">Tanggal Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <div class="summary-box">
        <h3>Ringkasan Penilaian Keseluruhan</h3>
        <p style="margin: 0;"><strong>Rata-rata Rating:</strong> {{ number_format($rataRataRating, 1) }} dari 5.0 (Berdasarkan {{ $totalResponden }} Responden)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="20%">Tamu & Kamar</th>
                <th width="10%" class="text-center">Rating</th>
                <th width="55%">Ulasan & Masukan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('d M Y') }}</td>
                    <td>
                        <strong>{{ $row->reservasi->tamu->nama ?? 'Tamu' }}</strong><br>
                        <span style="font-size: 10px; color: #666;">
                            {{ $row->reservasi->tamu->perusahaan ?? '-' }} ({{ $row->reservasi->tamu->jabatan ?? '-' }})<br>
                            @if($row->reservasi->kamar)
                                {{ $row->reservasi->kamar->nomor_kamar }}
                            @else
                                Tanpa Kamar
                            @endif
                        </span>
                    </td>
                    <td class="text-center"><strong>{{ $row->rating }}</strong> ⭐</td>
                    <td>
                        <div>"{{ $row->komentar ?: 'Tidak ada komentar.' }}"</div>
                        @if($row->saran_masukan)
                            <div class="saran">Saran: {{ $row->saran_masukan }}</div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada evaluasi / rating dari tamu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Sistem Informasi FR Academy Mess
    </div>

</body>
</html>
