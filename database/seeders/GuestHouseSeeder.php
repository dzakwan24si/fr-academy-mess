<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;

class GuestHouseSeeder extends Seeder
{
    public function run()
    {
        $guestHouses = [
            [
                'nomor_kamar' => 'G1.03A.1',
                'lokasi' => 'Guest House G1 (03A)',
                'tipe_kamar' => 'Guest House',
                'kapasitas' => 2,
                'status' => 'kosong_bersih',
            ],
            [
                'nomor_kamar' => 'G1.03A.2',
                'lokasi' => 'Guest House G1 (03A)',
                'tipe_kamar' => 'Guest House',
                'kapasitas' => 2,
                'status' => 'kosong_bersih',
            ],
            [
                'nomor_kamar' => 'G1.10.1',
                'lokasi' => 'Guest House G1 (10)',
                'tipe_kamar' => 'Guest House',
                'kapasitas' => 2,
                'status' => 'kosong_bersih',
            ],
            [
                'nomor_kamar' => 'G1.10.2',
                'lokasi' => 'Guest House G1 (10)',
                'tipe_kamar' => 'Guest House',
                'kapasitas' => 2,
                'status' => 'kosong_bersih',
            ],
        ];

        foreach ($guestHouses as $gh) {
            Kamar::firstOrCreate(
                ['nomor_kamar' => $gh['nomor_kamar']],
                $gh
            );
        }
    }
}
