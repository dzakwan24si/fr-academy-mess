<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM/TA/04.a - Daftar Menu</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #000;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .no-print {
            display: block;
        }
        @media print {
            .no-print { display: none !important; }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        .header-container {
            width: 100%;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .header-left {
            width: 150px;
            flex-shrink: 0;
        }
        
        .header-center {
            flex-grow: 1;
            text-align: center;
        }
        
        .header-right {
            width: 150px;
            flex-shrink: 0;
            text-align: right;
        }
        
        .form-code {
            display: inline-block;
            border: 2px solid #000;
            padding: 4px 8px;
            font-weight: bold;
            font-size: 11pt;
        }

        .header-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header-title h2 {
            margin: 0;
            font-size: 14pt;
        }
        .header-title h3 {
            margin: 0;
            font-size: 12pt;
        }

        .footer-notes {
            text-align: left;
            font-size: 8pt;
            margin-top: 15px;
            line-height: 1.4;
            border: 1px solid #000;
            padding: 8px;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .footer-notes strong {
            display: block;
            margin-bottom: 5px;
            font-size: 9pt;
        }
        .footer-notes p {
            margin: 0 0 2px 0;
            white-space: normal;
        }

        .info-table {
            border: none;
            font-size: 9pt;
            font-weight: bold;
            margin-top: 20px; /* space for logo */
        }
        .info-table td {
            padding: 2px 5px;
            vertical-align: top;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9pt;
            table-layout: fixed;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #000;
            padding: 2px;
            vertical-align: top;
        }
        table.data-table th {
            text-align: center;
            font-weight: bold;
            padding: 5px;
            text-transform: uppercase;
        }
        
        .col-hari { width: 8%; }
        .col-tanggal { width: 12%; }
        .col-jus { width: 10%; }
        .col-makan { width: 23.33%; }
        
        .menu-list {
            display: flex;
            flex-direction: column;
            min-height: 90px;
            height: 100%;
        }
        .menu-items-wrapper {
            flex-grow: 1;
        }
        .menu-item {
            text-align: center;
            border-bottom: 1px dotted #ccc;
            padding: 2px 0;
            text-transform: uppercase;
        }
        .menu-item:last-child {
            border-bottom: none;
        }
        .snack-item {
            background-color: #92d050 !important; /* Green from PDF */
            text-align: center;
            font-weight: bold;
            padding: 2px 0;
            text-transform: uppercase;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        .porsi-footer {
            background-color: #ffc000 !important; /* Yellow from PDF */
            text-align: left;
            font-weight: bold;
            padding: 2px 4px;
            font-size: 9pt;
            border-top: 1px solid #000;
        }

        /* Signature Section */
        .signature-table {
            width: 100%;
            text-align: center;
            border: none;
            font-size: 10pt;
            margin-top: 15px;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .signature-table td {
            width: 33.33%;
            vertical-align: bottom;
        }
        .signature-line {
            display: inline-block;
            border-bottom: 1px solid #000;
            width: 80%;
            margin-top: 5px;
            margin-bottom: 2px;
            font-weight: bold;
        }
        
        .text-center { text-align: center; }
        .align-middle { vertical-align: middle !important; }
        .uppercase { text-transform: uppercase; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body onload="window.print()">
    
    <div class="no-print" style="padding: 10px; background: #f8f9fa; text-align: center; border-bottom: 1px solid #ddd; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #007bff; color: white; border: none; cursor: pointer; font-size: 14px; border-radius: 4px;">Cetak / Simpan PDF</button>
        <button onclick="window.location.href='{{ route('admin.dapur') }}'" style="padding: 8px 16px; background: #6c757d; color: white; border: none; cursor: pointer; font-size: 14px; border-radius: 4px; margin-left: 10px;">Tutup Halaman</button>
    </div>

    <div class="header-container">
        <!-- Left -->
        <div class="header-left">
            <img src="{{ asset('logofr.png') }}" style="height: 45px; margin-bottom: 5px;" alt="Logo FR">
        </div>

        <!-- Center -->
        <div class="header-center">
            <div class="header-title">
                <h2>DAFTAR MENU</h2>
                <h3>LEARNING & DEVELOPMENT</h3>
            </div>
        </div>

        <!-- Right -->
        <div class="header-right">
            <div class="form-code">FORM/TA/04.a</div>
        </div>
    </div>

    <table class="info-table" style="margin-top: 5px; margin-bottom: 15px;">
        <tr>
            <td style="width: 70px;">PELATIHAN</td>
            <td>: {{ strtoupper($namaPelatihan) }}</td>
        </tr>
        <tr>
            <td>JUMLAH</td>
            <td>: {{ $jumlahPeserta }}</td>
        </tr>
        <tr>
            <td>PERIODE</td>
            <td>: {{ strtoupper($periode) }}</td>
        </tr>
    </table>

    <!-- TABEL UTAMA -->
    <table class="data-table">
        <thead>
            <tr>
                <th class="col-hari">HARI</th>
                <th class="col-tanggal">TANGGAL</th>
                <th class="col-jus">JUS TRAINER</th>
                <th class="col-makan">PAGI</th>
                <th class="col-makan">SIANG</th>
                <th class="col-makan">MALAM</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal as $date => $data)
            <tr>
                <td class="text-center font-bold align-middle uppercase">
                    {{ $data['hari'] }}
                </td>
                <td class="text-center align-middle">
                    {{ $data['tanggal_format'] }}
                </td>
                <td class="text-center align-middle uppercase font-bold">
                    {{ $data['jus_trainer'] }}
                </td>

                <!-- PAGI -->
                <td style="padding: 0;">
                    <div class="menu-list">
                        <div class="menu-items-wrapper">
                            @foreach($data['menus']['pagi'] as $menu)
                                @if(!str_contains(strtoupper($menu), 'SNACK'))
                                    <div class="menu-item">{{ $menu }}</div>
                                @endif
                            @endforeach
                        </div>
                        
                        @foreach($data['menus']['pagi'] as $menu)
                            @if(str_contains(strtoupper($menu), 'SNACK'))
                                <div class="snack-item">{{ $menu }}</div>
                            @endif
                        @endforeach
                        
                        @if(count($data['menus']['pagi']) > 0)
                            <div class="porsi-footer">
                                @php
                                    $porsiPagi = $data['porsi']['pagi'] > 0 ? $data['porsi']['pagi'] : $jumlahPeserta;
                                    $extraPagi = $porsiPagi > $jumlahPeserta ? $porsiPagi - $jumlahPeserta : 0;
                                @endphp
                                Jumlah Org : {{ $jumlahPeserta }}{{ $extraPagi > 0 ? '+'.$extraPagi : '' }}
                            </div>
                        @endif
                    </div>
                </td>

                <!-- SIANG -->
                <td style="padding: 0;">
                    <div class="menu-list">
                        <div class="menu-items-wrapper">
                            @foreach($data['menus']['siang'] as $menu)
                                @if(!str_contains(strtoupper($menu), 'SNACK'))
                                    <div class="menu-item">{{ $menu }}</div>
                                @endif
                            @endforeach
                        </div>
                        
                        @foreach($data['menus']['siang'] as $menu)
                            @if(str_contains(strtoupper($menu), 'SNACK'))
                                <div class="snack-item">{{ $menu }}</div>
                            @endif
                        @endforeach
                        
                        @if(count($data['menus']['siang']) > 0)
                            <div class="porsi-footer">
                                @php
                                    $porsiSiang = $data['porsi']['siang'] > 0 ? $data['porsi']['siang'] : $jumlahPeserta;
                                    $extraSiang = $porsiSiang > $jumlahPeserta ? $porsiSiang - $jumlahPeserta : 0;
                                @endphp
                                Jumlah Org : {{ $jumlahPeserta }}{{ $extraSiang > 0 ? '+'.$extraSiang : '' }}
                            </div>
                        @endif
                    </div>
                </td>

                <!-- MALAM -->
                <td style="padding: 0;">
                    <div class="menu-list">
                        <div class="menu-items-wrapper">
                            @foreach($data['menus']['malam'] as $menu)
                                @if(!str_contains(strtoupper($menu), 'SNACK'))
                                    <div class="menu-item">{{ $menu }}</div>
                                @endif
                            @endforeach
                        </div>
                        
                        @foreach($data['menus']['malam'] as $menu)
                            @if(str_contains(strtoupper($menu), 'SNACK'))
                                <div class="snack-item">{{ $menu }}</div>
                            @endif
                        @endforeach
                        
                        @if(count($data['menus']['malam']) > 0)
                            <div class="porsi-footer">
                                @php
                                    $porsiMalam = $data['porsi']['malam'] > 0 ? $data['porsi']['malam'] : $jumlahPeserta;
                                    $extraMalam = $porsiMalam > $jumlahPeserta ? $porsiMalam - $jumlahPeserta : 0;
                                @endphp
                                Jumlah Org : {{ $jumlahPeserta }}{{ $extraMalam > 0 ? '+'.$extraMalam : '' }}
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td>
                <div>Disetujui oleh,</div>
                <div style="height: 60px;"></div>
                <div class="signature-line"></div>
                <div>Training Manager</div>
            </td>
            <td>
                <div>Diperiksa oleh,</div>
                <div style="height: 60px;"></div>
                <div class="signature-line"></div>
                <div>KTU/TA</div>
            </td>
            <td>
                <div>Dibuat oleh,</div>
                <div style="height: 60px;"></div>
                <div class="signature-line"></div>
                <div>Koord.Mess</div>
            </td>
        </tr>
    </table>

    <!-- CATATAN -->
    <div class="footer-notes">
        <strong>Catatan Khusus:</strong>
        <p>1. Segala menu telor bulat wajib digoreng dan disambal.</p>
        <p>2. Menu ayam goreng di-slice agar matang bagian kedalam.</p>
        <p>3. Menu ikan goreng pastikan goreng kering matang bagian dalam.</p>
        <p>4. Menu gulai ayam/sup ayam sepotong di ubah menjadi 2 potong (berat timbangan tetap) agar tidak terlalu besar.</p>
        <p>5. Menu soto/mie ayam mohon saos kecap dipisah, biar trainee yang menakar sendiri.</p>
    </div>
</body>
</html>
