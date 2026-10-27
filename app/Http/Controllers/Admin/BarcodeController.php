<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Barryvdh\DomPDF\Facade\Pdf;

class BarcodeController extends Controller
{
    public function cetak()
    {
        $kamars = Kamar::where('tipe_kamar', '!=', 'Fasilitas Umum')->orderBy('nomor_kamar', 'asc')->get();

        $ruangMakanUrl = route('guest.dashboard'); // Nanti tamu bisa pilih menu survei dari dashboard
        // Untuk survei kepuasan makanan, kita bisa mengarahkannya langsung kalau ada routenya,
        // tapi sementara arahkan ke dashboard tamu.

        $qrContext = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
            'http' => [
                'timeout' => 5,
            ],
        ]);

        $makanApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='.urlencode($ruangMakanUrl).'&margin=0';
        $makanRaw = @file_get_contents($makanApiUrl, false, $qrContext);
        $makanBase64 = $makanRaw ? base64_encode($makanRaw) : '';

        $kamarApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.urlencode(route('guest.dashboard')).'&margin=0';
        $kamarRaw = @file_get_contents($kamarApiUrl, false, $qrContext);
        $kamarBase64 = $kamarRaw ? base64_encode($kamarRaw) : '';

        $pdf = Pdf::loadView('admin.barcode.cetak', [
            'kamars' => $kamars,
            'makanBase64' => $makanBase64,
            'kamarBase64' => $kamarBase64,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Barcode-Ruangan-FR-Academy.pdf');
    }
}
