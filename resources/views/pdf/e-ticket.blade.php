<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket Reservasi #{{ str_pad($reservasi->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 10px;
            color: #333;
        }
        .ticket-box {
            border: 2px dashed #59A338;
            padding: 20px;
            border-radius: 12px;
            background-color: #F8FBF8;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #59A338;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header img {
            max-height: 45px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #2E7D32;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #555;
            font-weight: bold;
        }
        .content-wrapper {
            width: 100%;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
        }
        .content-table td {
            vertical-align: top;
        }
        .info-col {
            width: 70%;
        }
        .qr-col {
            width: 30%;
            text-align: right;
        }
        .qr-col img {
            width: 120px;
            height: 120px;
            border: 1px solid #ddd;
            padding: 5px;
            background: #fff;
            border-radius: 8px;
        }
        .detail-row {
            margin-bottom: 12px;
        }
        .detail-label {
            font-size: 11px;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detail-value {
            font-size: 15px;
            font-weight: bold;
            color: #2E7D32;
        }
        .detail-value.guest-name {
            font-size: 18px;
            color: #114045;
        }
        .detail-sub {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            background-color: #2E7D32;
            color: #fff;
            font-size: 11px;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
            margin-top: 5px;
        }
        .footer {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            font-size: 11px;
            color: #555;
        }
        .footer strong {
            color: #2E7D32;
        }
        .meal-times {
            margin: 10px 0;
            padding: 10px;
            background-color: #e8f5e9;
            border-radius: 6px;
            text-align: center;
        }
        .meal-times span {
            font-weight: bold;
            color: #114045;
            margin: 0 5px;
        }
    </style>
</head>
<body>

    <div class="ticket-box">
        <div class="header">
            <img src="{{ public_path('logofr.png') }}" alt="FR Academy Logo">
            <h1>E-Ticket Reservasi</h1>
            <p>ID: RSV-{{ str_pad($reservasi->id, 4, '0', STR_PAD_LEFT) }}</p>
        </div>

        <table class="content-table">
            <tr>
                <td class="info-col">
                    <div class="detail-row">
                        <div class="detail-label">Tamu</div>
                        <div class="detail-value guest-name">{{ $reservasi->tamu->nama }}</div>
                        <div class="detail-sub">{{ $reservasi->tamu->perusahaan ?? '-' }} ({{ $reservasi->tamu->jabatan ?? '-' }})</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Kamar & Tipe</div>
                        @if($reservasi->kamar)
                            <div class="detail-value">{{ $reservasi->kamar->nomor_kamar }}</div>
                            <div class="detail-sub">{{ $reservasi->kamar->tipe_kamar }}</div>
                        @else
                            <div class="detail-value">Menunggu Alokasi</div>
                            <div class="detail-sub">-</div>
                        @endif
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Jadwal Menginap</div>
                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($reservasi->tanggal_checkin)->translatedFormat('d M Y') }} 
                            &ndash; 
                            {{ $reservasi->tanggal_checkout ? \Carbon\Carbon::parse($reservasi->tanggal_checkout)->translatedFormat('d M Y') : 'Selesai' }}
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="status-badge">
                            @if($reservasi->status == 'approved')
                                Disetujui (Menunggu Check-in)
                            @elseif($reservasi->status == 'checked_in')
                                Aktif (Check-in)
                            @elseif($reservasi->status == 'completed')
                                Selesai
                            @else
                                {{ ucfirst($reservasi->status) }}
                            @endif
                        </div>
                    </div>
                </td>
                <td class="qr-col">
                    @if($qrCode)
                        <img src="{{ $qrCode }}" alt="QR Code">
                    @endif
                </td>
            </tr>
        </table>

        <div class="footer">
            <div class="meal-times">
                <strong>Jadwal Ruang Makan:</strong><br>
                <span>Pagi: 06.00</span> | <span>Siang: 12.00</span> | <span>Malam: 19.00</span>
            </div>
            <p><strong>Informasi Penting:</strong> Mohon tunjukkan E-Ticket (QR Code) ini kepada Koord Mess / Front Office saat proses *check-in* atau masuk ke area Mess.</p>
        </div>
    </div>

</body>
</html>
