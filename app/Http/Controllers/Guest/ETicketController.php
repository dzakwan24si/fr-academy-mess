<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ETicketController extends Controller
{
    public function download($id)
    {
        $reservasi = Reservasi::with(['tamu', 'kamar'])->findOrFail($id);

        // Security check: Only the guest who made the reservation can download it
        abort_if($reservasi->tamu_id !== auth('tamu')->id(), 403, 'Akses ditolak. Anda tidak diizinkan melihat e-ticket ini.');

        // Only allow download if status is approved, checked_in, or completed
        abort_if(!in_array($reservasi->status, ['approved', 'checked_in', 'completed']), 404, 'E-Ticket belum tersedia.');

        // Generate QR code URL
        // Data format: 'RSV-' + ID (4 digits padding)
        $qrData = urlencode('RSV-' . str_pad($reservasi->id, 4, '0', STR_PAD_LEFT));
        // api.qrserver.com returns a PNG image which works with DOMPDF
        // We use base64 encoding to prevent DOMPDF from making external HTTP requests during render, which can be slow or blocked
        
        $qrImageUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . $qrData;
        $qrCodeBase64 = null;
        try {
            $imageContent = @file_get_contents($qrImageUrl);
            if ($imageContent !== false) {
                $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($imageContent);
            }
        } catch (\Exception $e) {
            // Silently fallback if API fails
        }

        $pdf = Pdf::loadView('pdf.e-ticket', [
            'reservasi' => $reservasi,
            'qrCode' => $qrCodeBase64
        ])->setPaper([0, 0, 380, 435], 'portrait');

        $fileName = 'E-Ticket-' . str_pad($reservasi->id, 4, '0', STR_PAD_LEFT) . '-' . str_replace(' ', '-', $reservasi->tamu->nama) . '.pdf';

        return $pdf->download($fileName);
    }
}
