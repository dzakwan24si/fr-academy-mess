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
                'nomor_kamar' => 'G1A',
                'lokasi' => 'Guest House G1',
                'tipe_kamar' => 'Guest House',
                'kapasitas' => 2,
                'status' => 'kosong_bersih',
            ],
            [
                'nomor_kamar' => 'G1B',
                'lokasi' => 'Guest House G1',
                'tipe_kamar' => 'Guest House',
                'kapasitas' => 2,
                'status' => 'kosong_bersih',
            ],
            [
                'nomor_kamar' => 'G1C',
                'lokasi' => 'Guest House G1',
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
