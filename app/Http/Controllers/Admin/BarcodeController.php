<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Services\QRCode;
use Barryvdh\DomPDF\Facade\Pdf;

class BarcodeController extends Controller
{
    public function cetak()
    {
        $kamars = Kamar::where('tipe_kamar', '!=', 'Fasilitas Umum')->orderBy('nomor_kamar', 'asc')->get();

        $ruangMakanUrl = route('guest.dashboard');

        // Generate offline vector SVG QR code (pure PHP, no external API, exact print size)
        $makanSvg = QRCode::getSvg($ruangMakanUrl, 2, 280);

        // QR Code untuk kamar diarahkan ke portal tamu
        $kamarUrl = route('guest.dashboard');
        $kamarSvg = QRCode::getSvg($kamarUrl, 2, 140);

        $pdf = Pdf::loadView('admin.barcode.cetak', [
            'kamars' => $kamars,
            'makanSvg' => $makanSvg,
            'kamarSvg' => $kamarSvg,
            'makanBase64' => null,
            'kamarBase64' => null,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Barcode-Ruangan-FR-Academy.pdf');
    }
}
