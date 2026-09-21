<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;
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
        ]);

        $makanApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($ruangMakanUrl) . '&margin=0';
        $makanBase64 = base64_encode(file_get_contents($makanApiUrl, false, $qrContext));

        $kamarApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode(route('guest.dashboard')) . '&margin=0';
        $kamarBase64 = base64_encode(file_get_contents($kamarApiUrl, false, $qrContext));

        $pdf = Pdf::loadView('admin.barcode.cetak', [
            'kamars' => $kamars,
            'makanBase64' => $makanBase64,
            'kamarBase64' => $kamarBase64
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Barcode-Ruangan-FR-Academy.pdf');
    }
}
