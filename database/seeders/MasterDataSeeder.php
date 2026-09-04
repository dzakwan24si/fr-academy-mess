<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Kamar
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Kamar::create([
                'nomor_kamar' => '10' . $i,
                'kapasitas' => 4,
                'status' => 'tersedia'
            ]);
        }

        // Create Bahan Baku
        \App\Models\BahanBaku::create(['nama_bahan' => 'Beras', 'stok' => 50, 'satuan' => 'kg']);
        \App\Models\BahanBaku::create(['nama_bahan' => 'Telur', 'stok' => 100, 'satuan' => 'butir']);
        \App\Models\BahanBaku::create(['nama_bahan' => 'Minyak Goreng', 'stok' => 20, 'satuan' => 'liter']);
    }
}
