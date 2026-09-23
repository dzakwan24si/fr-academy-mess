<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Kamar;
use App\Models\Tamu;
use App\Models\Reservasi;

class ImportReservasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/reservasi_data.json'));
        $data = json_decode($json, true);

        if (!$data) {
            $this->command->error("Data JSON tidak ditemukan atau kosong!");
            return;
        }

        $countTamu = 0;
        $countKamar = 0;
        $countReservasi = 0;

        foreach ($data as $row) {
            $nomorKamar = $row['kamar'];
            
            // 1. Create or Find Kamar
            $kamar = Kamar::firstOrCreate(
                ['nomor_kamar' => $nomorKamar],
                [
                    'tipe_kamar' => 'Reguler Twin Bed',
                    'kapasitas' => 2,
                    'status' => 'terisi',
                    'lokasi' => 'Lantai Dasar' // default
                ]
            );

            // Update status kamar menjadi terisi jika sebelumnya kosong
            if ($kamar->status !== 'terisi' || $kamar->status !== 'maintenance') {
                $kamar->update(['status' => 'terisi']);
            }
            
            if ($kamar->wasRecentlyCreated) $countKamar++;

            // 2. Create or Find Tamu by No HP (Handling duplicate phone numbers for different people)
            $noHp = $row['no_hp'];
            $tamu = Tamu::firstWhere('no_hp', $noHp);

            if ($tamu && strtolower(trim($tamu->nama)) !== strtolower(trim($row['nama']))) {
                $suffix = 1;
                while (Tamu::where('no_hp', $noHp . '-' . $suffix)->exists()) {
                    $suffix++;
                }
                $noHp = $noHp . '-' . $suffix;
                $tamu = null; // Force create new
            }

            if (!$tamu) {
                $tamu = Tamu::create([
                    'nama' => $row['nama'],
                    'perusahaan' => 'FR Academy',
                    'jabatan' => $row['jabatan'],
                    'kategori' => 'trainee',
                    'no_hp' => $noHp
                ]);
                $countTamu++;
            }

            // 3. Create Reservasi
            $reservasiExists = Reservasi::where('tamu_id', $tamu->id)
                ->where('kamar_id', $kamar->id)
                ->where('tanggal_checkin', '2026-08-01')
                ->exists();

            if (!$reservasiExists) {
                Reservasi::create([
                    'tamu_id' => $tamu->id,
                    'kamar_id' => $kamar->id,
                    'tanggal_checkin' => '2026-08-01',
                    'tanggal_checkout' => '2026-09-30',
                    'keperluan_menginap' => 'Pelatihan Program ' . $row['jabatan'],
                    'status' => 'checked_in',
                    'perkiraan_jam_checkin' => '14:00:00'
                ]);
                $countReservasi++;
            }
        }

        $this->command->info("Seeder selesai!");
        $this->command->info("Kamar baru dibuat: {$countKamar}");
        $this->command->info("Tamu baru dibuat: {$countTamu}");
        $this->command->info("Reservasi baru dibuat: {$countReservasi}");
    }
}
