<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\BahanBaku;
use Illuminate\Support\Str;

class MenuDanResepSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'nama_menu' => 'Nasi Goreng',
                'deskripsi' => 'Nasi goreng kampung dengan kecap dan bumbu rempah',
                'resep' => [
                    'Beras topi koki @20kg' => 0.005, // 0.1 kg (asumsi 1 sak 20kg = 0.005 sak)
                    'Minyak goreng' => 0.005,
                    'Kecap manis ABC refill' => 0.01,
                    'Garam halus' => 0.01,
                    'Bawang merah' => 0.01,
                    'Bawang putih' => 0.005,
                    'Cabe merah' => 0.01,
                ]
            ],
            [
                'nama_menu' => 'Ayam Sambal',
                'deskripsi' => 'Ayam potong goreng dengan sambal balado',
                'resep' => [
                    'Ayam potong daging' => 0.15,
                    'Cabe merah' => 0.05,
                    'Bawang merah' => 0.02,
                    'Bawang putih' => 0.01,
                    'Minyak goreng' => 0.01,
                    'Tomat' => 0.02,
                ]
            ],
            [
                'nama_menu' => 'Telor Dadar',
                'deskripsi' => 'Telor dadar tebal khas padang',
                'resep' => [
                    'Telur ayam' => 0.033, // 1 butir (dari 1 papan isi 30)
                    'Bawang merah' => 0.01,
                    'Minyak goreng' => 0.005,
                    'Cabe merah' => 0.005,
                ]
            ],
            [
                'nama_menu' => 'Sayur Asam',
                'deskripsi' => 'Sayur asam segar dengan sayuran',
                'resep' => [
                    'Sayur asam' => 0.1,
                    'Kacang hijau' => 0.01, // pengganti kacang tanah sementara
                    'Bawang merah' => 0.01,
                ]
            ],
            [
                'nama_menu' => 'Tongkol Sambal',
                'deskripsi' => 'Ikan tongkol disiram sambal balado',
                'resep' => [
                    'Ikan tongkol' => 0.15,
                    'Cabe merah giling' => 0.05,
                    'Bawang merah' => 0.02,
                    'Tomat' => 0.02,
                    'Minyak goreng' => 0.01,
                ]
            ],
            [
                'nama_menu' => 'Gulai Nangka',
                'deskripsi' => 'Gulai nangka muda dengan santan kental',
                'resep' => [
                    'Nangka muda' => 0.1,
                    'Santan gulai nangka' => 0.05,
                    'Bawang merah' => 0.01,
                    'Kunyit' => 0.005,
                ]
            ],
            [
                'nama_menu' => 'Kacang Hijau (Snack)',
                'deskripsi' => 'Bubur kacang hijau manis',
                'resep' => [
                    'Kacang hijau' => 0.05,
                    'Gula merah' => 0.02,
                    'Santan bubur kcg hijau' => 0.03,
                ]
            ],
            [
                'nama_menu' => 'Lontong Sayur',
                'deskripsi' => 'Lontong dengan kuah gulai jipang',
                'resep' => [
                    'Lontong plastik' => 0.1,
                    'Santan gulai lontong' => 0.05,
                    'Jipang' => 0.05,
                    'Telur ayam' => 0.033,
                    'Bawang merah' => 0.01,
                ]
            ],
            [
                'nama_menu' => 'Tongseng Daging',
                'deskripsi' => 'Tongseng daging sapi dengan kol',
                'resep' => [
                    'Daging sapi' => 0.1,
                    'Kol' => 0.05,
                    'Bawang merah' => 0.02,
                    'Kecap manis ABC refill' => 0.01,
                    'Cabe rawit' => 0.01,
                ]
            ],
            [
                'nama_menu' => 'Tumis Kangkung',
                'deskripsi' => 'Kangkung tumis terasi',
                'resep' => [
                    'Kangkung' => 0.5,
                    'Bawang putih' => 0.01,
                    'Cabe merah' => 0.01,
                    'Terasi' => 0.01,
                    'Minyak goreng' => 0.005,
                ]
            ],
            [
                'nama_menu' => 'Soto Padang',
                'deskripsi' => 'Soto daging sapi khas padang dengan bihun',
                'resep' => [
                    'Daging sapi' => 0.05,
                    'Bihun jagung' => 0.05,
                    'Bumbu soto bulat/halus' => 0.1,
                    'Minyak soto' => 0.05,
                    'Bawang merah' => 0.01,
                ]
            ],
            [
                'nama_menu' => 'Gulai Tauco Ikan',
                'deskripsi' => 'Gulai ikan tongkol dengan bumbu tauco',
                'resep' => [
                    'Ikan tongkol' => 0.1,
                    'Tauco' => 0.05,
                    'Cabe hijau' => 0.02,
                    'Bawang merah' => 0.01,
                ]
            ],
            [
                'nama_menu' => 'Mie Goreng Sayur',
                'deskripsi' => 'Mie telor goreng dengan sawi',
                'resep' => [
                    'Mie telor' => 0.05,
                    'Sawi putih' => 0.05,
                    'Telur ayam' => 0.033,
                    'Kecap manis ABC refill' => 0.01,
                    'Bawang putih' => 0.01,
                ]
            ],
            [
                'nama_menu' => 'Ayam Penyet',
                'deskripsi' => 'Ayam penyet dengan sambal terasi pedas',
                'resep' => [
                    'Ayam potong daging' => 0.15,
                    'Cabe rawit' => 0.02,
                    'Bawang merah' => 0.01,
                    'Tempe' => 0.05,
                    'Terasi' => 0.01,
                    'Tomat' => 0.01,
                ]
            ],
            [
                'nama_menu' => 'Pisang Barangan',
                'deskripsi' => 'Buah Pisang Barangan segar',
                'resep' => [
                    'Pisang barangan' => 0.05,
                ]
            ],
        ];

        foreach ($menus as $menuData) {
            $menu = Menu::firstOrCreate(
                ['nama_menu' => $menuData['nama_menu']],
                ['deskripsi' => $menuData['deskripsi']]
            );

            // Bersihkan resep lama jika ada
            $menu->bahanBakus()->detach();

            foreach ($menuData['resep'] as $namaBahan => $jumlah) {
                // Cari bahan berdasarkan kemiripan nama
                $bahan = BahanBaku::where('nama_bahan', 'like', "%{$namaBahan}%")->first();
                if ($bahan) {
                    $menu->bahanBakus()->attach($bahan->id, ['jumlah_dibutuhkan' => $jumlah]);
                }
            }
        }
    }
}
