<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tingkat Hunian (Okupansi)</title>
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
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: right;
            color: #777;
        }
        
        .summary {
            margin-top: -10px;
            margin-bottom: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('logofr.png') }}" alt="FR Academy Logo">
        <h1>FR Academy Mess</h1>
        <p>Laporan Tingkat Hunian (Okupansi) - Periode: {{ $bulan }} {{ $tahun }}</p>
        <p style="font-size: 12px;">Tanggal Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <div class="summary">
        <strong>Ringkasan Periode:</strong><br>
        Total Tamu: {{ count($data) }} Orang
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="25%">Nama Tamu</th>
                <th width="20%">Instansi / Perusahaan</th>
                <th width="15%">Kamar</th>
                <th width="15%">Tgl Check-in</th>
                <th width="15%">Tgl Check-out</th>
                <th width="5%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $row->tamu->nama ?? 'Tamu' }}</strong></td>
                    <td>{{ $row->tamu->perusahaan ?? '-' }} ({{ $row->tamu->jabatan ?? '-' }})</td>
                    <td>
                        @if($row->kamar)
                            {{ $row->kamar->nomor_kamar }}<br>
                            <span style="font-size: 10px; color: #666;">{{ $row->kamar->tipe_kamar }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal_checkin)->translatedFormat('d M Y') }}</td>
                    <td>{{ $row->tanggal_checkout ? \Carbon\Carbon::parse($row->tanggal_checkout)->translatedFormat('d M Y') : '-' }}</td>
                    <td class="text-center">
                        @if($row->status == 'checked_in')
                            Check-in
                        @elseif($row->status == 'completed')
                            Selesai
                        @else
                            Disetujui
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data okupansi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Sistem Informasi FR Academy Mess
    </div>

</body>
</html>
