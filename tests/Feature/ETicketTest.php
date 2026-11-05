<?php

namespace Tests\Feature;

use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\Tamu;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ETicketTest extends TestCase
{
    use DatabaseTransactions;

    public static function setUpBeforeClass(): void
    {
        putenv('DB_CONNECTION=mysql');
        putenv('DB_DATABASE=db_mess_fracademy');
        $_ENV['DB_CONNECTION'] = 'mysql';
        $_ENV['DB_DATABASE'] = 'db_mess_fracademy';
        $_SERVER['DB_CONNECTION'] = 'mysql';
        $_SERVER['DB_DATABASE'] = 'db_mess_fracademy';
        parent::setUpBeforeClass();
    }

    public function test_guest_can_download_eticket_fast_and_without_error(): void
    {
        $tamu = Tamu::create([
            'nama' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'perusahaan' => 'First Resources',
            'jabatan' => 'Staff',
            'kategori' => 'tamu_umum',
        ]);

        $kamar = Kamar::firstOrCreate([
            'nomor_kamar' => 'TEST-01',
        ], [
            'tipe_kamar' => 'Reguler Single',
            'kapasitas' => 1,
            'is_tersedia' => true,
        ]);

        $reservasi = Reservasi::create([
            'tamu_id' => $tamu->id,
            'kamar_id' => $kamar->id,
            'tanggal_checkin' => now()->toDateString(),
            'tanggal_checkout' => now()->addDays(2)->toDateString(),
            'status' => 'approved',
            'keperluan_menginap' => 'Dinas',
        ]);

        $startTime = microtime(true);

        $response = $this->actingAs($tamu, 'tamu')
            ->get(route('guest.eticket', $reservasi->id));

        $duration = microtime(true) - $startTime;

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertLessThan(15.0, $duration, 'PDF generation should finish cleanly');
    }
}
