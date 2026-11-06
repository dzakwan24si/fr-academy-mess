<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Distribusi Aset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 15px;
            color: #333;
            font-size: 11px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #59A338;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .header img {
            max-height: 45px;
            margin-bottom: 5px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #2E7D32;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 13px;
            color: #555;
        }
        .summary-bar {
            background-color: #F4F8F4;
            border: 1px solid #c8e6c9;
            padding: 8px 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            font-size: 11px;
        }
        .kamar-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .kamar-header {
            background-color: #2E7D32;
            color: #ffffff;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 4px 4px 0 0;
        }
        .kamar-lokasi {
            font-weight: normal;
            font-size: 10px;
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 5px;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px 6px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f1f8e9;
            color: #2E7D32;
            font-weight: bold;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-baik { background-color: #d1fae5; color: #065f46; }
        .badge-rusak { background-color: #fee2e2; color: #991b1b; }
        .badge-hilang { background-color: #f3f4f6; color: #374151; }
        .footer {
            margin-top: 25px;
            font-size: 9px;
            text-align: right;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        @if(!empty($logoBase64))
            <img src="{{ $logoBase64 }}" alt="FR Academy Logo">
        @elseif(file_exists(public_path('logofr.png')))
            <img src="{{ public_path('logofr.png') }}" alt="FR Academy Logo">
        @endif
        <h1>FR Academy Mess</h1>
        <p>Laporan Distribusi & Kondisi Aset Mess</p>
        <p style="font-size: 11px; color: #666; margin-top: 3px;">
            Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}
        </p>
    </div>

    <div class="summary-bar">
        <strong>Total Ruangan:</strong> {{ count($groupedData) }} Lokasi &nbsp;|&nbsp;
        <strong>Total Item Terdata:</strong> {{ $totalItems }} Item
        @if(!empty($filterKamarNama))
            &nbsp;|&nbsp; <strong>Filter Lokasi:</strong> {{ $filterKamarNama }}
        @endif
        @if(!empty($filterKondisi))
            &nbsp;|&nbsp; <strong>Filter Kondisi:</strong> {{ $filterKondisi }}
        @endif
        @if(!empty($search))
            &nbsp;|&nbsp; <strong>Kata Kunci:</strong> "{{ $search }}"
        @endif
    </div>

    @forelse($groupedData as $kamarNama => $items)
        <div class="kamar-section">
            <div class="kamar-header">
                {{ $kamarNama }} 
                <span class="kamar-lokasi">({{ $items->first()['kamar_lokasi'] ?: 'Lokasi Tidak Ditentukan' }})</span>
                <span style="float: right; font-weight: normal; font-size: 10px;">{{ count($items) }} Aset</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="35%">Nama Aset</th>
                        <th width="20%">Kategori</th>
                        <th width="10%" class="text-center">Jumlah</th>
                        <th width="12%" class="text-center">Kondisi</th>
                        <th width="18%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $row)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $row['aset_nama'] ?? '-' }}</strong></td>
                            <td>{{ $row['aset_kategori'] ?? '-' }}</td>
                            <td class="text-center font-bold">{{ $row['jumlah'] ?? 0 }}</td>
                            <td class="text-center">
                                @if(($row['kondisi'] ?? '') === 'Baik')
                                    <span class="badge badge-baik">Baik</span>
                                @elseif(str_contains($row['kondisi'] ?? '', 'Rusak'))
                                    <span class="badge badge-rusak">{{ $row['kondisi'] }}</span>
                                @else
                                    <span class="badge badge-hilang">{{ $row['kondisi'] ?? '-' }}</span>
                                @endif
                            </td>
                            <td>{{ ($row['keterangan'] ?? '') ?: '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <div style="text-align: center; padding: 40px; color: #888;">
            Tidak ada data aset terdistribusi yang sesuai filter.
        </div>
    @endforelse

    <div class="footer">
        Dicetak oleh Sistem Informasi FR Academy Mess
    </div>

</body>
</html>
