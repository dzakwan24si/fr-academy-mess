<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Services\QRCode;
use Barryvdh\DomPDF\Facade\Pdf;

class ETicketController extends Controller
{
    public function download($id)
    {
        $reservasi = Reservasi::with(['tamu', 'kamar'])->findOrFail($id);

        // Security check: Only the guest who made the reservation can download it
        abort_if($reservasi->tamu_id !== auth('tamu')->id(), 403, 'Akses ditolak. Anda tidak diizinkan melihat e-ticket ini.');

        // Only allow download if status is approved, checked_in, or completed
        abort_if(! in_array($reservasi->status, ['approved', 'checked_in', 'completed']), 404, 'E-Ticket belum tersedia.');

        // Generate QR code locally in pure PHP (no external API calls, offline-ready)
        $qrCodeData = 'RSV-'.str_pad($reservasi->id, 4, '0', STR_PAD_LEFT);
        $qrCodeBase64 = QRCode::getBase64Png($qrCodeData, 4);

        // Load logo as base64 for reliable DomPDF embedding
        $logoPath = public_path('logofr.png');
        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,'.base64_encode(file_get_contents($logoPath)) : null;

        $pdf = Pdf::loadView('pdf.e-ticket', [
            'reservasi' => $reservasi,
            'qrCode' => $qrCodeBase64,
            'logoBase64' => $logoBase64,
        ])->setPaper([0, 0, 380, 435], 'portrait');

        $namaTamu = $reservasi->tamu?->nama ?? 'Tamu';
        $fileName = 'E-Ticket-'.str_pad($reservasi->id, 4, '0', STR_PAD_LEFT).'-'.str_replace(' ', '-', $namaTamu).'.pdf';

        return $pdf->download($fileName);
    }
}
