<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Distribusi Aset</title>
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
        .badge-baik { background-color: #d1fae5; color: #065f46; }
        .badge-rusak { background-color: #fee2e2; color: #991b1b; }
        .badge-hilang { background-color: #f3f4f6; color: #374151; }
        
        .footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: right;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('logofr.png') }}" alt="FR Academy Logo">
        <h1>FR Academy Mess</h1>
        <p>Laporan Distribusi Aset</p>
        <p style="font-size: 12px;">Tanggal Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Kamar / Lokasi</th>
                <th width="25%">Nama Aset</th>
                <th width="15%">Kategori</th>
                <th width="10%" class="text-center">Jumlah</th>
                <th width="10%" class="text-center">Kondisi</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporanData as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $row['kamar_nama'] }}</strong><br>
                        <span style="font-size: 10px; color: #666;">{{ $row['kamar_lokasi'] }}</span>
                    </td>
                    <td>{{ $row['aset_nama'] }}</td>
                    <td>{{ $row['aset_kategori'] }}</td>
                    <td class="text-center">{{ $row['jumlah'] }}</td>
                    <td class="text-center">
                        @if($row['kondisi'] === 'Baik')
                            <span class="badge badge-baik">Baik</span>
                        @elseif($row['kondisi'] === 'Rusak')
                            <span class="badge badge-rusak">Rusak</span>
                        @else
                            <span class="badge badge-hilang">{{ $row['kondisi'] }}</span>
                        @endif
                    </td>
                    <td>{{ $row['keterangan'] ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data aset terdistribusi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Sistem Informasi FR Academy Mess
    </div>

</body>
</html>
