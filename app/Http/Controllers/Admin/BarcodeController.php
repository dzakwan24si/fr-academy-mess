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

        // Generate offline vector SVG QR code embedded via base64 for DomPDF
        $makanBase64 = QRCode::getBase64Svg($ruangMakanUrl, 2, 280);

        // QR Code untuk kamar diarahkan ke portal tamu
        $kamarUrl = route('guest.dashboard');
        $kamarBase64 = QRCode::getBase64Svg($kamarUrl, 2, 140);

        $pdf = Pdf::loadView('admin.barcode.cetak', [
            'kamars' => $kamars,
            'makanBase64' => $makanBase64,
            'kamarBase64' => $kamarBase64,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Barcode-Ruangan-FR-Academy.pdf');
    }
}
