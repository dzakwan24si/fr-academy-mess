<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Belanja</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            color: #000;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .page-break {
            page-break-before: always;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .header-title h2 {
            margin: 0;
            font-size: 14pt;
        }
        .header-title h3 {
            margin: 0;
            font-size: 12pt;
        }
        .info-section {
            width: 100%;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
        .info-table {
            border: none;
            font-size: 10pt;
            font-weight: bold;
        }
        .info-table td {
            padding: 2px 5px;
            vertical-align: top;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10pt;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #000;
            padding: 4px 6px;
        }
        table.data-table th {
            text-align: center;
            background-color: #f2f2f2;
            font-weight: bold;
            -webkit-print-color-adjust: exact;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row {
            font-weight: bold;
        }
        .total-row td {
            border: none;
        }
        
        /* Signature Section */
        .signature-section {
            margin-top: 50px;
            width: 100%;
        }
        .signature-table {
            width: 100%;
            text-align: center;
            border: none;
            font-weight: bold;
            font-size: 11pt;
        }
        .signature-table td {
            width: 33.33%;
            vertical-align: bottom;
            padding-top: 80px; /* Space for signature */
        }
        .signature-line {
            display: inline-block;
            border-bottom: 1px solid #000;
            width: 80%;
            margin-top: 10px;
        }
        
        .form-code {
            position: absolute;
            top: 0;
            right: 0;
            border: 2px solid #000;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 11pt;
        }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    
    <div class="no-print" style="padding: 10px; background: #f8f9fa; text-align: center; border-bottom: 1px solid #ddd; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #007bff; color: white; border: none; cursor: pointer; font-size: 14px; border-radius: 4px;">Cetak Dokumen</button>
        <button onclick="window.location.href='{{ route('admin.dapur') }}'" style="padding: 8px 16px; background: #6c757d; color: white; border: none; cursor: pointer; font-size: 14px; border-radius: 4px; margin-left: 10px;">Kembali</button>
    </div>

    @foreach(['Kering' => $bahanKering, 'Basah' => $bahanBasah] as $kategori => $items)
    @if(count($items) > 0)
    <div style="position: relative;" class="{{ $loop->iteration > 1 ? 'page-break' : '' }}">
        <div style="position: absolute; top: 0; left: 0;">
            <img src="{{ asset('logofr.png') }}" style="height: 55px;" alt="Logo">
        </div>
        <div class="form-code">FORM/TA/05{{ $kategori == 'Kering' ? 'a' : 'b' }}</div>
        
        <div class="header-title">
            <h2>DAFTAR BELANJA {{ strtoupper($kategori) }}</h2>
            <h2>LEARNING & DEVELOPMENT</h2>
            <h3>NO : {{ date('m') }}/L&D/VIII/{{ date('Y') }}</h3>
        </div>

        <div class="info-section">
            <table class="info-table">
                <tr>
                    <td>Kepada Yth :</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Sdr/I. Toko</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Di. Tempat.</td>
                    <td></td>
                </tr>
            </table>

            <table class="info-table">
                <tr>
                    <td>Nama Pelatihan</td>
                    <td>: {{ $namaPelatihan }}</td>
                </tr>
                <tr>
                    <td>Jumlah Peserta</td>
                    <td>: {{ $jumlahPeserta }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pelatihan</td>
                    <td>: {{ $tanggalPelatihan }}</td>
                </tr>
            </table>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 30%;">Nama Bahan</th>
                    <th style="width: 5%;">Stn</th>
                    <th style="width: 5%;">Qty</th>
                    <th style="width: 5%;">Vol</th>
                    <th style="width: 15%;">Harga Hikmah</th>
                    <th style="width: 15%;">Jumlah</th>
                    <th style="width: 20%;">Tanggal Diterima</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($items as $index => $item)
                    @php $grandTotal += $item['total_harga']; @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item['nama_bahan'] }}</td>
                        <td class="text-center">{{ $item['satuan'] }}</td>
                        <td class="text-center">{{ rtrim(rtrim(number_format($item['qty_beli'], 2, ',', '.'), '0'), ',') }}</td>
                        <td class="text-center">{{ $item['keterangan_volume'] ?? '' }}</td>
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Rp</span>
                                <span>{{ number_format($item['harga_satuan'], 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Rp</span>
                                <span>{{ number_format($item['total_harga'], 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align: right; font-weight: bold; font-size: 11pt; padding-right: 25%;">
            Rp &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($grandTotal, 0, ',', '.') }}
        </div>

        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>Disetujui oleh</td>
                    <td>Diperiksa oleh</td>
                    <td>Dibuat oleh</td>
                </tr>
                <tr>
                    <td>
                        <!-- Signature Space -->
                        <br><br><br><br>
                        <span class="signature-line"></span>
                        <br>
                        Training Manager
                    </td>
                    <td>
                        <!-- Signature Space -->
                        <br><br><br><br>
                        <span class="signature-line"></span>
                        <br>
                        KTU/TA
                    </td>
                    <td>
                        <!-- Signature Space -->
                        <br><br><br><br>
                        <span class="signature-line"></span>
                        <br>
                        Koord. Mess
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endif
    @endforeach

</body>
</html>
