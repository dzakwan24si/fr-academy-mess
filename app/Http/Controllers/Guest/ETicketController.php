<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Services\QRCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ETicketController extends Controller
{
    public function download($id)
    {
        $reservasi = Reservasi::with(['tamu', 'kamar'])->findOrFail($id);

        // Security check: Only the guest who made the reservation can download it
        abort_if($reservasi->tamu_id !== auth('tamu')->id(), 403, 'Akses ditolak. Anda tidak diizinkan melihat e-ticket ini.');

        // Only allow download if status is approved, checked_in, or completed
        abort_if(! in_array($reservasi->status, ['approved', 'checked_in', 'completed']), 404, 'E-Ticket belum tersedia.');

        try {
            // Ensure storage/fonts directory exists for DomPDF font cache
            $fontDir = storage_path('fonts');
            if (! file_exists($fontDir)) {
                @mkdir($fontDir, 0775, true);
            }

            // Generate QR code locally in pure PHP (SVG base64 requires 0 extensions, completely offline)
            $qrCodeData = 'RSV-'.str_pad($reservasi->id, 4, '0', STR_PAD_LEFT);
            $qrCodeBase64 = null;

            if (class_exists(QRCode::class)) {
                $qrCodeBase64 = QRCode::getBase64Svg($qrCodeData, 2, 120);
                if (! $qrCodeBase64 && extension_loaded('gd')) {
                    $qrCodeBase64 = QRCode::getBase64Png($qrCodeData, 4);
                }
            }

            // Determine logo: prefer JPG because DomPDF renders JPEG natively without PHP-GD extension
            $jpgLogo = public_path('logofr.jpg');
            $pngLogo = public_path('logofr.png');
            $logoBase64 = null;

            if (file_exists($jpgLogo)) {
                $logoBase64 = 'data:image/jpeg;base64,'.base64_encode(file_get_contents($jpgLogo));
            } elseif (file_exists($pngLogo) && extension_loaded('gd')) {
                $logoBase64 = 'data:image/png;base64,'.base64_encode(file_get_contents($pngLogo));
            }

            $pdf = Pdf::loadView('pdf.e-ticket', [
                'reservasi' => $reservasi,
                'qrCode' => $qrCodeBase64,
                'logoBase64' => $logoBase64,
            ])->setPaper([0, 0, 380, 435], 'portrait');

            $namaTamu = $reservasi->tamu?->nama ?? 'Tamu';
            $fileName = 'E-Ticket-'.str_pad($reservasi->id, 4, '0', STR_PAD_LEFT).'-'.str_replace(' ', '-', $namaTamu).'.pdf';

            return $pdf->download($fileName);
        } catch (HttpException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error('E-Ticket Generation Error: '.$e->getMessage()."\nFile: ".$e->getFile().':'.$e->getLine());

            $errorMessage = config('app.debug')
                ? "Terjadi kendala saat memproses E-Ticket PDF:\n\n".$e->getMessage()."\n\nLokasi: ".$e->getFile().':'.$e->getLine()
                : 'Terjadi kendala saat memproses E-Ticket PDF. Silakan hubungi Front Office / Koordinator Mess atau coba beberapa saat lagi.';

            return response($errorMessage, 500)
                ->header('Content-Type', 'text/plain');
        }
    }
}
