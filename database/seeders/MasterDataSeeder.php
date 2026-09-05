<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;
use App\Models\AsetMess;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seeder Kamar Reguler (Lorong 1 sampai 12)
        for ($lorong = 1; $lorong <= 12; $lorong++) {
            // Setiap lorong ada 4 kamar
            for ($kamarNum = 1; $kamarNum <= 4; $kamarNum++) {
                $nomor = $lorong . '0' . $kamarNum; // Hasil: 101, 1201, dll
                
                Kamar::create([
                    'nomor_kamar' => $nomor,
                    'tipe_kamar' => 'Reguler Twin Bed',
                    'kapasitas' => 2,
                    'status' => 'kosong_bersih',
                ]);
            }
        }

        // 2. Seeder Kamar Executive (VIP)
        $vipRooms = ['VIP-01', 'VIP-02', 'VIP-03'];
        foreach ($vipRooms as $vip) {
            Kamar::create([
                'nomor_kamar' => $vip,
                'tipe_kamar' => 'Executive',
                'kapasitas' => 2,
                'status' => 'kosong_bersih',
            ]);
        }

        // 3. Seeder Aset Mess (Proporsional untuk 51 kamar)
        // 48 Kamar Reguler (Kapasitas 2) = 96 orang
        // 3 Kamar VIP (Kapasitas 2) = 6 orang
        // Total = 102 orang, 51 Kamar
        $asetData = [
            ['nama_aset' => 'Divan / Tempat Tidur', 'kategori' => 'Furniture', 'total_stok' => 102],
            ['nama_aset' => 'Kasur Ligna', 'kategori' => 'Bedding', 'total_stok' => 102],
            ['nama_aset' => 'Lemari Pakaian', 'kategori' => 'Furniture', 'total_stok' => 51],
            ['nama_aset' => 'Kipas Angin / AC', 'kategori' => 'Elektronik', 'total_stok' => 51],
            ['nama_aset' => 'Cermin', 'kategori' => 'Aksesoris', 'total_stok' => 51],
            ['nama_aset' => 'Seprei', 'kategori' => 'Linen', 'total_stok' => 204],
            ['nama_aset' => 'Bantal & Sarung Bantal', 'kategori' => 'Bedding', 'total_stok' => 204],
            ['nama_aset' => 'Bak Mandi', 'kategori' => 'Kamar Mandi', 'total_stok' => 24], // 2 per lorong
            ['nama_aset' => 'Gayung', 'kategori' => 'Kamar Mandi', 'total_stok' => 24],
        ];

        foreach ($asetData as $aset) {
            AsetMess::create($aset);
        }
    }
}
