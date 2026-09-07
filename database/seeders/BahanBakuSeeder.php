<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BahanBaku;

class BahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === BAHAN KERING ===
        $bahanKering = [
            ['nama_bahan' => 'Beras belida @20kg', 'satuan' => 'kg', 'harga_satuan' => 16000, 'keterangan_volume' => '1 sak = 20kg'],
            ['nama_bahan' => 'Beras topi koki @20kg', 'satuan' => 'kg', 'harga_satuan' => 16000, 'keterangan_volume' => '1 sak = 20kg'],
            ['nama_bahan' => 'Bihun jagung', 'satuan' => 'pak', 'harga_satuan' => 43000],
            ['nama_bahan' => 'Daia', 'satuan' => 'bks', 'harga_satuan' => 20000],
            ['nama_bahan' => 'Garam halus', 'satuan' => 'pak', 'harga_satuan' => 100000],
            ['nama_bahan' => 'Gas', 'satuan' => 'tbg', 'harga_satuan' => 270000],
            ['nama_bahan' => 'Gula merah', 'satuan' => 'kg', 'harga_satuan' => 28000],
            ['nama_bahan' => 'Gula putih', 'satuan' => 'kg', 'harga_satuan' => 21000],
            ['nama_bahan' => 'Kacang hijau', 'satuan' => 'kg', 'harga_satuan' => 32000],
            ['nama_bahan' => 'Kecap manis ABC refill', 'satuan' => 'bks', 'harga_satuan' => 23000],
            ['nama_bahan' => 'Kerupuk merah', 'satuan' => 'kg', 'harga_satuan' => 26000],
            ['nama_bahan' => 'Kerupuk udang', 'satuan' => 'kg', 'harga_satuan' => 28000],
            ['nama_bahan' => 'Ketumbar halus', 'satuan' => 'ppn', 'harga_satuan' => 12000],
            ['nama_bahan' => 'Kispray', 'satuan' => 'ppn', 'harga_satuan' => 7000],
            ['nama_bahan' => 'Merica halus', 'satuan' => 'ppn', 'harga_satuan' => 12000],
            ['nama_bahan' => 'Mie lidi', 'satuan' => 'bks', 'harga_satuan' => 9000],
            ['nama_bahan' => 'Mie telor', 'satuan' => 'dus', 'harga_satuan' => 80000],
            ['nama_bahan' => 'Minyak goreng', 'satuan' => 'liter', 'harga_satuan' => 22500, 'keterangan_volume' => '1 dus = 12 liter'],
            ['nama_bahan' => 'Plastik PE @10kg', 'satuan' => 'kg', 'harga_satuan' => 50000],
            ['nama_bahan' => 'Plastik press gulung', 'satuan' => 'glg', 'harga_satuan' => 23000],
            ['nama_bahan' => 'Royco ayam/sapi', 'satuan' => 'bks', 'harga_satuan' => 10000],
            ['nama_bahan' => 'Saus sambal ABC refill', 'satuan' => 'bks', 'harga_satuan' => 35000],
            ['nama_bahan' => 'Sunlight 800ml', 'satuan' => 'bks', 'harga_satuan' => 20000],
            ['nama_bahan' => 'Teh sarimurni', 'satuan' => 'ppn', 'harga_satuan' => 18000],
            ['nama_bahan' => 'Tepung beras', 'satuan' => 'bks', 'harga_satuan' => 11000],
            ['nama_bahan' => 'Tepung ketan', 'satuan' => 'bks', 'harga_satuan' => 17000],
            ['nama_bahan' => 'Tepung terigu', 'satuan' => 'kg', 'harga_satuan' => 15000],
            ['nama_bahan' => 'Terasi', 'satuan' => 'pak', 'harga_satuan' => 12000],
            ['nama_bahan' => 'Red bell warna hijau', 'satuan' => 'btl', 'harga_satuan' => 10000],
            ['nama_bahan' => 'Aqua 600ml', 'satuan' => 'dus', 'harga_satuan' => 52000],
            ['nama_bahan' => 'Bayfresh kaleng', 'satuan' => 'klg', 'harga_satuan' => 28000],
            ['nama_bahan' => 'Cling', 'satuan' => 'bks', 'harga_satuan' => 7000],
            ['nama_bahan' => 'Hit kaleng', 'satuan' => 'klg', 'harga_satuan' => 37000],
            ['nama_bahan' => 'Kapur barus bulat', 'satuan' => 'bks', 'harga_satuan' => 25000],
            ['nama_bahan' => 'Kopi kapal api 380gr', 'satuan' => 'bks', 'harga_satuan' => 35000],
            ['nama_bahan' => 'Sos @2liter', 'satuan' => 'bks', 'harga_satuan' => 25000],
            ['nama_bahan' => 'Teh celup sariwangi', 'satuan' => 'ktk', 'harga_satuan' => 8000],
            ['nama_bahan' => 'Tisu biasa nice', 'satuan' => 'bal', 'harga_satuan' => 45000],
            ['nama_bahan' => 'Tisu toilet gulung nice', 'satuan' => 'bal', 'harga_satuan' => 45000],
            ['nama_bahan' => 'Tisu wastafel montiss', 'satuan' => 'bks', 'harga_satuan' => 13000],
            ['nama_bahan' => 'Wipol refill @390ml', 'satuan' => 'bks', 'harga_satuan' => 13000],
        ];

        foreach ($bahanKering as $bahan) {
            BahanBaku::firstOrCreate(
                ['nama_bahan' => $bahan['nama_bahan']],
                [
                    'kategori_bahan' => 'Kering',
                    'stok' => 100, // Dummy initial stock
                    'satuan' => $bahan['satuan'],
                    'harga_satuan' => $bahan['harga_satuan']
                ]
            );
        }

        // === BAHAN BASAH ===
        $bahanBasah = [
            ['nama_bahan' => 'Alpukat', 'satuan' => 'kg', 'harga_satuan' => 35000],
            ['nama_bahan' => 'Mangga', 'satuan' => 'kg', 'harga_satuan' => 30000],
            ['nama_bahan' => 'Ayam potong daging', 'satuan' => 'kg', 'harga_satuan' => 57000, 'keterangan_volume' => '120 ptg'],
            ['nama_bahan' => 'Ayam soto daging', 'satuan' => 'kg', 'harga_satuan' => 57000],
            ['nama_bahan' => 'Bawang bombay', 'satuan' => 'kg', 'harga_satuan' => 50000],
            ['nama_bahan' => 'Bawang merah', 'satuan' => 'kg', 'harga_satuan' => 45000],
            ['nama_bahan' => 'Bawang prei + sup', 'satuan' => 'kg', 'harga_satuan' => 45000],
            ['nama_bahan' => 'Bawang putih', 'satuan' => 'kg', 'harga_satuan' => 50000],
            ['nama_bahan' => 'Bawang tombak', 'satuan' => 'kg', 'harga_satuan' => 25000],
            ['nama_bahan' => 'Bumbu soto bulat/halus', 'satuan' => 'ppn', 'harga_satuan' => 12000],
            ['nama_bahan' => 'Cabe hijau', 'satuan' => 'kg', 'harga_satuan' => 60000],
            ['nama_bahan' => 'Cabe merah', 'satuan' => 'kg', 'harga_satuan' => 60000],
            ['nama_bahan' => 'Cabe merah giling', 'satuan' => 'kg', 'harga_satuan' => 60000],
            ['nama_bahan' => 'Cabe rawit', 'satuan' => 'kg', 'harga_satuan' => 90000],
            ['nama_bahan' => 'Daging sapi', 'satuan' => 'kg', 'harga_satuan' => 170000, 'keterangan_volume' => '60 ptg'],
            ['nama_bahan' => 'Daun langko', 'satuan' => 'ikt', 'harga_satuan' => 2000],
            ['nama_bahan' => 'Ikan tongkol', 'satuan' => 'kg', 'harga_satuan' => 55000, 'keterangan_volume' => '60 ptg'],
            ['nama_bahan' => 'Jahe', 'satuan' => 'kg', 'harga_satuan' => 45000],
            ['nama_bahan' => 'Jeruk nipis', 'satuan' => 'kg', 'harga_satuan' => 30000],
            ['nama_bahan' => 'Jipang', 'satuan' => 'kg', 'harga_satuan' => 15000],
            ['nama_bahan' => 'Kangkung', 'satuan' => 'ikt', 'harga_satuan' => 4000],
            ['nama_bahan' => 'Kembang tahu', 'satuan' => 'bks', 'harga_satuan' => 7000],
            ['nama_bahan' => 'Kentang', 'satuan' => 'kg', 'harga_satuan' => 20000],
            ['nama_bahan' => 'Kol', 'satuan' => 'kg', 'harga_satuan' => 12000],
            ['nama_bahan' => 'Kunyit', 'satuan' => 'kg', 'harga_satuan' => 25000],
            ['nama_bahan' => 'Lontong plastik', 'satuan' => 'bks', 'harga_satuan' => 3000],
            ['nama_bahan' => 'Minyak soto', 'satuan' => 'bks', 'harga_satuan' => 4000],
            ['nama_bahan' => 'Nangka muda', 'satuan' => 'kg', 'harga_satuan' => 15000],
            ['nama_bahan' => 'Petai', 'satuan' => 'kg', 'harga_satuan' => 85000],
            ['nama_bahan' => 'Pisang barangan', 'satuan' => 'buah', 'harga_satuan' => 2000, 'keterangan_volume' => '1 sisir = 11 buah'],
            ['nama_bahan' => 'Sawi putih', 'satuan' => 'kg', 'harga_satuan' => 25000],
            ['nama_bahan' => 'Sayur asam', 'satuan' => 'bks', 'harga_satuan' => 3000],
            ['nama_bahan' => 'Semangka', 'satuan' => 'kg', 'harga_satuan' => 15000],
            ['nama_bahan' => 'Santan bubur kcg hijau', 'satuan' => 'kg', 'harga_satuan' => 15000],
            ['nama_bahan' => 'Santan gulai lontong', 'satuan' => 'kg', 'harga_satuan' => 15000],
            ['nama_bahan' => 'Santan gulai nangka', 'satuan' => 'kg', 'harga_satuan' => 15000],
            ['nama_bahan' => 'Tahu goreng', 'satuan' => 'bks', 'harga_satuan' => 7000],
            ['nama_bahan' => 'Tahu putih', 'satuan' => 'bks', 'harga_satuan' => 7000],
            ['nama_bahan' => 'Tauco', 'satuan' => 'kg', 'harga_satuan' => 22000],
            ['nama_bahan' => 'Telur ayam', 'satuan' => 'butir', 'harga_satuan' => 1867, 'keterangan_volume' => '1 papan = 30 butir'],
            ['nama_bahan' => 'Tempe', 'satuan' => 'bks', 'harga_satuan' => 7000],
            ['nama_bahan' => 'Timun', 'satuan' => 'kg', 'harga_satuan' => 18000],
            ['nama_bahan' => 'Toge pendek', 'satuan' => 'kg', 'harga_satuan' => 14000],
            ['nama_bahan' => 'Tomat', 'satuan' => 'kg', 'harga_satuan' => 25000],
            ['nama_bahan' => 'Udang asin', 'satuan' => 'kg', 'harga_satuan' => 140000],
            ['nama_bahan' => 'Wortel', 'satuan' => 'kg', 'harga_satuan' => 25000],
        ];

        foreach ($bahanBasah as $bahan) {
            BahanBaku::firstOrCreate(
                ['nama_bahan' => $bahan['nama_bahan']],
                [
                    'kategori_bahan' => 'Basah',
                    'stok' => 100, // Dummy initial stock
                    'satuan' => $bahan['satuan'],
                    'harga_satuan' => $bahan['harga_satuan'],
                    'keterangan_volume' => $bahan['keterangan_volume'] ?? null
                ]
            );
        }
    }
}
