<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Barcode Ruangan FR Academy</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #59A338;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #114045;
            margin: 0 0 10px 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        .page-break {
            page-break-after: always;
        }
        .barcode-container {
            text-align: center;
            border: 4px dashed #59A338;
            border-radius: 20px;
            padding: 40px;
            margin: 50px auto;
            width: 80%;
            max-width: 500px;
        }
        .barcode-title {
            font-size: 32px;
            font-weight: bold;
            color: #114045;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .barcode-desc {
            font-size: 16px;
            color: #555;
            margin-bottom: 40px;
        }
        .barcode-img {
            width: 300px;
            height: 300px;
            margin: 0 auto;
            border: 2px solid #eee;
            padding: 10px;
            background: #fff;
            border-radius: 15px;
        }
        .barcode-footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888;
            font-style: italic;
        }
        .grid {
            width: 100%;
        }
        .grid td {
            width: 50%;
            padding: 20px;
            text-align: center;
            vertical-align: top;
        }
        .small-barcode-box {
            border: 2px dashed #114045;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }
        .small-title {
            font-size: 20px;
            font-weight: bold;
            color: #114045;
            margin-bottom: 10px;
        }
        .small-img {
            width: 150px;
            height: 150px;
            margin: 0 auto 10px auto;
        }
    </style>
</head>
<body>

    <!-- Halaman 1: Barcode Ruang Makan -->
    <div class="header">
        <h1>FR Academy Mess</h1>
        <p>Scan Barcode Untuk Layanan Digital</p>
    </div>

    <div class="barcode-container">
        <div class="barcode-title">RUANG MAKAN</div>
        <div class="barcode-desc">Scan barcode ini untuk memberikan penilaian dan masukan terkait kualitas hidangan.</div>
        
        <div class="barcode-img">
            <img src="data:image/png;base64,{{ $makanBase64 }}" alt="QR Ruang Makan" style="width: 100%; height: 100%;">
        </div>
        
        <div class="barcode-footer">
            Terima kasih atas penilaian Anda.<br>
            Kenyamanan Anda adalah prioritas kami.
        </div>
    </div>

    <div class="page-break"></div>

    <!-- Halaman Berikutnya: Barcode Per Kamar -->
    <div class="header">
        <h1>FR Academy Mess</h1>
        <p>Barcode Layanan Kamar (Dapat dipotong dan ditempel di tiap kamar)</p>
    </div>

    <table class="grid">
        @php $count = 0; @endphp
        @foreach($kamars as $kamar)
            @if($count % 2 == 0)
                <tr>
            @endif
            
            <td>
                <div class="small-barcode-box">
                    <div class="small-title">{{ stripos($kamar->nomor_kamar, 'Kamar') !== false ? $kamar->nomor_kamar : 'Kamar ' . $kamar->nomor_kamar }}</div>
                    <div style="font-size: 12px; color: #666; margin-bottom: 15px;">Scan untuk akses sistem layanan kamar dan pelaporan masalah.</div>
                    
                    <div class="small-img">
                        <img src="data:image/png;base64,{{ $kamarBase64 }}" alt="QR Kamar" style="width: 100%; height: 100%;">
                    </div>
                </div>
            </td>

            @if($count % 2 == 1 || $loop->last)
                </tr>
            @endif
            
            @php $count++; @endphp
            
            @if($count > 0 && $count % 8 == 0 && !$loop->last)
                </table>
                <div class="page-break"></div>
                <div class="header">
                    <h1>FR Academy Mess</h1>
                    <p>Barcode Layanan Kamar (Lanjutan)</p>
                </div>
                <table class="grid">
            @endif
        @endforeach
    </table>

</body>
</html>
