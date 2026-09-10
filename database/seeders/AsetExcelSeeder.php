<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;
use App\Models\AsetMess;
use Illuminate\Support\Facades\DB;

class AsetExcelSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('aset_kamar')->truncate();
        AsetMess::truncate();
        // Jangan truncate kamar karena mungkin ada data dummy tamu, atau truncate saja?
        // Tapi kita bikin baru, mending hapus kamar yg fasilitas umum/mess saja?
        // Hapus kamar saja biar clean.
        Kamar::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $masterAsets = [
            ['nama_aset' => 'DIVAN (TEMPAT TIDUR)', 'kategori' => 'Furnitur', 'total_stok' => 88],
            ['nama_aset' => 'KASUR LIGNA', 'kategori' => 'Furnitur', 'total_stok' => 91],
            ['nama_aset' => 'SEPREI', 'kategori' => 'Lainnya', 'total_stok' => 113],
            ['nama_aset' => 'SARUNG BANTAL', 'kategori' => 'Linen & Kamar Mandi', 'total_stok' => 196],
            ['nama_aset' => 'BANTAL', 'kategori' => 'Linen & Kamar Mandi', 'total_stok' => 93],
            ['nama_aset' => 'LEMARI PAKAIAN', 'kategori' => 'Furnitur', 'total_stok' => 46],
            ['nama_aset' => 'KIPAS ANGIN (1 DINDING)', 'kategori' => 'Elektronik', 'total_stok' => 12],
            ['nama_aset' => 'GORDYN', 'kategori' => 'Lainnya', 'total_stok' => 54],
            ['nama_aset' => 'GAYUNG', 'kategori' => 'Lainnya', 'total_stok' => 26],
            ['nama_aset' => 'KESET KAKI', 'kategori' => 'Lainnya', 'total_stok' => 12],
            ['nama_aset' => 'CERMIN', 'kategori' => 'Lainnya', 'total_stok' => 48],
            ['nama_aset' => 'LAMPU PANJANG', 'kategori' => 'Lainnya', 'total_stok' => 50],
            ['nama_aset' => 'LAMPU BULAT', 'kategori' => 'Lainnya', 'total_stok' => 62],
            ['nama_aset' => 'KERANJANG SAMPAH', 'kategori' => 'Lainnya', 'total_stok' => 8],
            ['nama_aset' => 'KIPAS ANGIN', 'kategori' => 'Elektronik', 'total_stok' => 35],
            ['nama_aset' => 'KURSI TUNGGU', 'kategori' => 'Furnitur', 'total_stok' => 6],
            ['nama_aset' => 'MEJA MAKAN', 'kategori' => 'Furnitur', 'total_stok' => 8],
            ['nama_aset' => 'MEJA LAUK', 'kategori' => 'Furnitur', 'total_stok' => 1],
            ['nama_aset' => 'KURSI MAKAN', 'kategori' => 'Furnitur', 'total_stok' => 74],
            ['nama_aset' => 'TAPLAK MEJA WARNA WARNI', 'kategori' => 'Furnitur', 'total_stok' => 7],
            ['nama_aset' => 'TUDUNG SAJI', 'kategori' => 'Lainnya', 'total_stok' => 5],
            ['nama_aset' => 'PIRING BESAR', 'kategori' => 'Lainnya', 'total_stok' => 61],
            ['nama_aset' => 'PIRING BREAK MERAH', 'kategori' => 'Lainnya', 'total_stok' => 40],
            ['nama_aset' => 'PIRING MELAMINE', 'kategori' => 'Lainnya', 'total_stok' => 37],
            ['nama_aset' => 'PIRING SEDANG KERAMIK', 'kategori' => 'Lainnya', 'total_stok' => 8],
            ['nama_aset' => 'SENDOK MAKAN', 'kategori' => 'Lainnya', 'total_stok' => 27],
            ['nama_aset' => 'GARPU MAKAN', 'kategori' => 'Lainnya', 'total_stok' => 32],
            ['nama_aset' => 'GELAS PLASTIK', 'kategori' => 'Lainnya', 'total_stok' => 26],
            ['nama_aset' => 'TEKO', 'kategori' => 'Lainnya', 'total_stok' => 6],
            ['nama_aset' => 'PYREK', 'kategori' => 'Lainnya', 'total_stok' => 9],
            ['nama_aset' => 'MANGKOK KACA', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'MANGKOK NASI', 'kategori' => 'Lainnya', 'total_stok' => 5],
            ['nama_aset' => 'KUALI BESAR', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'KUALI SEDANG', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'KUALI KECIL', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'KOMPOR GAS', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'SENDOK GORENG', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'SENDOK GULAI', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'TABUNG GAS', 'kategori' => 'Lainnya', 'total_stok' => 5],
            ['nama_aset' => 'RICE COOKER GAS', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'PISAU BESI', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'BASKOM STAINLESS', 'kategori' => 'Lainnya', 'total_stok' => 10],
            ['nama_aset' => 'DANDANG BESAR CAMPING', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'KULKAS', 'kategori' => 'Elektronik', 'total_stok' => 2],
            ['nama_aset' => 'DISPENSER BARU KANTOR(HIJAU)', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'RAK PIRING', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'LUNCH BOX', 'kategori' => 'Lainnya', 'total_stok' => 62],
            ['nama_aset' => 'TEMPAT BUAH KACA', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'TERMOS NASI MERAH', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'TV,ANTENA,SET TOP BOX', 'kategori' => 'Elektronik', 'total_stok' => 2],
            ['nama_aset' => 'BLENDER PHILIPS BIRU', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'FREEZER PUTIH', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'KOTAK P3K', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'DISPENSER BARU BIRU UNTUK TRAINEE', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'MESIN CUCI LG', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'EMBER BILAS', 'kategori' => 'Lainnya', 'total_stok' => 5],
            ['nama_aset' => 'KERANJANG BARU', 'kategori' => 'Lainnya', 'total_stok' => 15],
            ['nama_aset' => 'KERANJANG LAMA', 'kategori' => 'Lainnya', 'total_stok' => 4],
            ['nama_aset' => 'SETRIKA', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'MEJA MAKAN BULAT BESAR', 'kategori' => 'Furnitur', 'total_stok' => 4],
            ['nama_aset' => 'TAPLAK MEJA BULAT BESAR MERAH', 'kategori' => 'Furnitur', 'total_stok' => 4],
            ['nama_aset' => 'TAPLAK MEJA PRASMANAN MERAH', 'kategori' => 'Furnitur', 'total_stok' => 1],
            ['nama_aset' => 'MEJA PANJANG KACA', 'kategori' => 'Furnitur', 'total_stok' => 1],
            ['nama_aset' => 'SOFA TAMU TANPA MEJA', 'kategori' => 'Furnitur', 'total_stok' => 1],
            ['nama_aset' => 'LEMARI TV', 'kategori' => 'Furnitur', 'total_stok' => 1],
            ['nama_aset' => 'AC', 'kategori' => 'Lainnya', 'total_stok' => 6],
            ['nama_aset' => 'TONG SAMPAH', 'kategori' => 'Lainnya', 'total_stok' => 4],
            ['nama_aset' => 'LEMARI TRAINEE', 'kategori' => 'Furnitur', 'total_stok' => 1],
            ['nama_aset' => 'DISPENSER', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'HANDUK', 'kategori' => 'Linen & Kamar Mandi', 'total_stok' => 5],
            ['nama_aset' => 'SELIMUT WARNA WARNI', 'kategori' => 'Linen & Kamar Mandi', 'total_stok' => 20],
            ['nama_aset' => 'LEMARI', 'kategori' => 'Furnitur', 'total_stok' => 3],
            ['nama_aset' => 'SINGLE BED', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'MEJA KERJA', 'kategori' => 'Furnitur', 'total_stok' => 3],
            ['nama_aset' => 'KURSI FUTURA', 'kategori' => 'Furnitur', 'total_stok' => 3],
            ['nama_aset' => 'RAK HANDUK', 'kategori' => 'Linen & Kamar Mandi', 'total_stok' => 3],
            ['nama_aset' => 'DOUBLE BED', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'BANTAL DAN GULING', 'kategori' => 'Linen & Kamar Mandi', 'total_stok' => 6],
            ['nama_aset' => 'BED COVER', 'kategori' => 'Lainnya', 'total_stok' => 2],
            ['nama_aset' => 'MEJA KECIL KACA', 'kategori' => 'Furnitur', 'total_stok' => 1],
            ['nama_aset' => 'WATER HEATER', 'kategori' => 'Lainnya', 'total_stok' => 3],
            ['nama_aset' => 'LAMPU EMERGENCY', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'MEJA BESAR KACA', 'kategori' => 'Furnitur', 'total_stok' => 1],
            ['nama_aset' => 'SOFA', 'kategori' => 'Lainnya', 'total_stok' => 1],
            ['nama_aset' => 'SHOWER', 'kategori' => 'Lainnya', 'total_stok' => 1],
        ];

        $asetMap = [];
        foreach ($masterAsets as $aset) {
            $created = AsetMess::updateOrCreate(
                ['nama_aset' => $aset['nama_aset']],
                ['kategori' => $aset['kategori'], 'total_stok' => $aset['total_stok']]
            );
            $asetMap[$aset['nama_aset']] = $created->id;
        }

        $ruanganAsets = [
            'Lorong  1' => [
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN (1 DINDING)' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'KESET KAKI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'KERANJANG SAMPAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
            'Lorong  2' => [
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN_rusak_berat' => ['real_nama' => 'KIPAS ANGIN', 'jumlah' => 1, 'kondisi' => 'Rusak Berat'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'KESET KAKI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'KERANJANG SAMPAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
            'Lorong  3' => [
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'KERANJANG SAMPAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
            'Lorong  4' => [
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
            ],
            'Lorong  5' => [
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN (1 DINDING)' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'LAMPU BULAT_rusak_berat' => ['real_nama' => 'LAMPU BULAT', 'jumlah' => 1, 'kondisi' => 'Rusak Berat'],
            ],
            'Lorong  6' => [
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 6, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 6, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'KESET KAKI' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
            ],
            'Lorong  7' => [
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN (1 DINDING)' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'KESET KAKI' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'KERANJANG SAMPAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
            'Lorong  8' => [
                'KASUR LIGNA' => ['jumlah' => 3, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 3, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 2, 'kondisi' => 'Baik'],
            ],
            'Lorong  9' => [
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'KESET KAKI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'KERANJANG SAMPAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
            'Lorong  10' => [
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 7, 'kondisi' => 'Baik'],
                'DIVAN (TEMPAT TIDUR)_rusak_ringan' => ['real_nama' => 'DIVAN (TEMPAT TIDUR)', 'jumlah' => 1, 'kondisi' => 'Rusak Ringan'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'KESET KAKI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'KERANJANG SAMPAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
            'Lorong  11' => [
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
            ],
            'Lorong  12' => [
                'KERANJANG SAMPAH' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'DIVAN (TEMPAT TIDUR)' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'KASUR LIGNA' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'LEMARI PAKAIAN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'KIPAS ANGIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'KESET KAKI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 5, 'kondisi' => 'Baik'],
            ],
            'Di Teras Mess' => [
                'KURSI TUNGGU' => ['jumlah' => 6, 'kondisi' => 'Baik'],
            ],
            'Dapur' => [
                'KIPAS ANGIN' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'MEJA MAKAN' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'MEJA LAUK' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KURSI MAKAN' => ['jumlah' => 42, 'kondisi' => 'Baik'],
                'KURSI MAKAN_rusak_berat' => ['real_nama' => 'KURSI MAKAN', 'jumlah' => 2, 'kondisi' => 'Rusak Berat'],
                'TAPLAK MEJA WARNA WARNI' => ['jumlah' => 7, 'kondisi' => 'Baik'],
                'TUDUNG SAJI' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'PIRING BESAR' => ['jumlah' => 61, 'kondisi' => 'Baik'],
                'PIRING BREAK MERAH' => ['jumlah' => 40, 'kondisi' => 'Baik'],
                'PIRING MELAMINE' => ['jumlah' => 37, 'kondisi' => 'Baik'],
                'PIRING SEDANG KERAMIK' => ['jumlah' => 8, 'kondisi' => 'Baik'],
                'SENDOK MAKAN' => ['jumlah' => 27, 'kondisi' => 'Baik'],
                'GARPU MAKAN' => ['jumlah' => 32, 'kondisi' => 'Baik'],
                'GELAS PLASTIK' => ['jumlah' => 26, 'kondisi' => 'Baik'],
                'TEKO' => ['jumlah' => 6, 'kondisi' => 'Baik'],
                'PYREK' => ['jumlah' => 9, 'kondisi' => 'Baik'],
                'MANGKOK KACA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'MANGKOK NASI' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'KUALI BESAR' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'KUALI SEDANG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KUALI SEDANG_rusak_berat' => ['real_nama' => 'KUALI SEDANG', 'jumlah' => 1, 'kondisi' => 'Rusak Berat'],
                'KUALI KECIL' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KOMPOR GAS' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'SENDOK GORENG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'SENDOK GULAI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'TABUNG GAS' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'RICE COOKER GAS' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'PISAU BESI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'BASKOM STAINLESS' => ['jumlah' => 10, 'kondisi' => 'Baik'],
                'DANDANG BESAR CAMPING' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'KULKAS' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'DISPENSER BARU KANTOR(HIJAU)' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'RAK PIRING' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'LUNCH BOX' => ['jumlah' => 62, 'kondisi' => 'Baik'],
                'TEMPAT BUAH KACA' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'TERMOS NASI MERAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'TV,ANTENA,SET TOP BOX' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'BLENDER PHILIPS BIRU' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'FREEZER PUTIH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KOTAK P3K' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'DISPENSER BARU BIRU UNTUK TRAINEE' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
            'Laundry' => [
                'MESIN CUCI LG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'EMBER BILAS' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'EMBER BILAS_rusak_berat' => ['real_nama' => 'EMBER BILAS', 'jumlah' => 1, 'kondisi' => 'Rusak Berat'],
                'KERANJANG BARU' => ['jumlah' => 15, 'kondisi' => 'Baik'],
                'KERANJANG LAMA' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'SETRIKA' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'SARUNG BANTAL' => ['jumlah' => 29, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 37, 'kondisi' => 'Baik'],
            ],
            'Executive Ruang Tamu Dan Makan' => [
                'KURSI MAKAN' => ['jumlah' => 30, 'kondisi' => 'Baik'],
                'MEJA MAKAN BULAT BESAR' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'TAPLAK MEJA BULAT BESAR MERAH' => ['jumlah' => 4, 'kondisi' => 'Baik'],
                'TAPLAK MEJA PRASMANAN MERAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'MEJA PANJANG KACA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'SOFA TAMU TANPA MEJA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'LEMARI TV' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'TV,ANTENA,SET TOP BOX' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'AC' => ['jumlah' => 3, 'kondisi' => 'Baik'],
                'TONG SAMPAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 3, 'kondisi' => 'Baik'],
                'LEMARI TRAINEE' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KOTAK P3K' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KULKAS' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'DISPENSER' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
            'Dalam Lemari Executive' => [
                'SARUNG BANTAL' => ['jumlah' => 95, 'kondisi' => 'Baik'],
                'HANDUK' => ['jumlah' => 5, 'kondisi' => 'Baik'],
                'SELIMUT WARNA WARNI' => ['jumlah' => 18, 'kondisi' => 'Baik'],
            ],
            'Kamar Executive 1' => [
                'LEMARI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'SINGLE BED' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'BANTAL' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'SELIMUT WARNA WARNI' => ['jumlah' => 2, 'kondisi' => 'Baik'],
                'MEJA KERJA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KURSI FUTURA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'RAK HANDUK' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KESET KAKI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'AC' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'TONG SAMPAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
            'Kamar Executive 2' => [
                'LEMARI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'DOUBLE BED' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'BANTAL DAN GULING' => ['jumlah' => 3, 'kondisi' => 'Baik'],
                'BED COVER' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'MEJA KERJA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KURSI FUTURA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'RAK HANDUK' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KESET KAKI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'AC' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'TONG SAMPAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'MEJA KECIL KACA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'WATER HEATER' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'WATER HEATER_rusak_berat' => ['real_nama' => 'WATER HEATER', 'jumlah' => 1, 'kondisi' => 'Rusak Berat'],
                'LAMPU EMERGENCY' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
            'Kamar Executive 3' => [
                'LEMARI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'DOUBLE BED' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'SEPREI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'BANTAL DAN GULING' => ['jumlah' => 3, 'kondisi' => 'Baik'],
                'BED COVER' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'MEJA KERJA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KURSI FUTURA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'CERMIN' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'RAK HANDUK' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'KESET KAKI' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'GAYUNG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'AC' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'GORDYN' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'TONG SAMPAH' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'LAMPU PANJANG' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'LAMPU BULAT' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'MEJA BESAR KACA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'SOFA' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'WATER HEATER' => ['jumlah' => 1, 'kondisi' => 'Baik'],
                'SHOWER' => ['jumlah' => 1, 'kondisi' => 'Baik'],
            ],
        ];

        // Buat lorong 1-12 (Reguler) dan Executive
        $kamarMess = [];
        for ($lorong = 1; $lorong <= 12; $lorong++) {
            for ($no = 1; $no <= 4; $no++) {
                $huruf = chr(64 + $no); // 1->A, 2->B, 3->C, 4->D
                $nomor = $lorong . $huruf;
                $kamarMess[] = [
                    'nomor_kamar' => "Kamar $nomor",
                    'lokasi' => "Lorong $lorong",
                    'tipe_kamar' => 'Reguler Twin Bed',
                    'kapasitas' => 2,
                    'status' => 'kosong_bersih',
                ];
            }
        }

        foreach ($kamarMess as $kamar) {
            Kamar::firstOrCreate(
                ['nomor_kamar' => $kamar['nomor_kamar']],
                $kamar
            );
        }

        foreach ($ruanganAsets as $ruang => $asets) {
            if (str_contains(strtolower($ruang), 'lorong')) {
                // Ekstrak nomor lorong (contoh: "Lorong  1" -> 1)
                preg_match('/\d+/', $ruang, $matches);
                if (!empty($matches)) {
                    $lorongNo = $matches[0];
                    
                    // Buat kembali Lorong sebagai Fasilitas Umum
                    $kamarLorong = Kamar::firstOrCreate(
                        ['nomor_kamar' => "Lorong $lorongNo"],
                        [
                            'lokasi' => 'Mess',
                            'tipe_kamar' => 'Fasilitas Umum',
                            'kapasitas' => 50,
                            'status' => 'terisi'
                        ]
                    );

                    // Ambil 4 kamar di lorong ini
                    $kamarList = [];
                    for ($no = 1; $no <= 4; $no++) {
                        $huruf = chr(64 + $no);
                        $nomor = $lorongNo . $huruf;
                        $kamarData = Kamar::where('nomor_kamar', "Kamar $nomor")->first();
                        if ($kamarData) {
                            $kamarList[] = $kamarData;
                        }
                    }
                    
                    foreach ($asets as $key => $data) {
                        $namaAset = isset($data['real_nama']) ? $data['real_nama'] : $key;
                        $jumlahTersedia = $data['jumlah'];
                        
                        if (isset($asetMap[$namaAset]) && count($kamarList) > 0) {
                            // Distribusikan aset ke kamar
                            $baseCount = floor($jumlahTersedia / count($kamarList));
                            $remainder = $jumlahTersedia % count($kamarList);
                            
                            // Masukkan baseCount ke tiap kamar
                            if ($baseCount > 0) {
                                foreach ($kamarList as $k) {
                                    $existing = DB::table('aset_kamar')
                                        ->where('kamar_id', $k->id)
                                        ->where('aset_mess_id', $asetMap[$namaAset])
                                        ->where('kondisi', $data['kondisi'])
                                        ->first();
                                        
                                    if ($existing) {
                                        DB::table('aset_kamar')
                                            ->where('id', $existing->id)
                                            ->update(['jumlah' => $existing->jumlah + $baseCount]);
                                    } else {
                                        DB::table('aset_kamar')->insert([
                                            'kamar_id' => $k->id,
                                            'aset_mess_id' => $asetMap[$namaAset],
                                            'kondisi' => $data['kondisi'],
                                            'jumlah' => $baseCount,
                                        ]);
                                    }
                                }
                            }
                            
                            // Sisa (remainder) dimasukkan ke Lorong (kamar mandi luar, dsb)
                            if ($remainder > 0) {
                                DB::table('aset_kamar')->updateOrInsert(
                                    ['kamar_id' => $kamarLorong->id, 'aset_mess_id' => $asetMap[$namaAset], 'kondisi' => $data['kondisi']],
                                    ['jumlah' => DB::raw('jumlah + ' . $remainder)] // Gunakan raw update untuk add
                                );
                            }
                        }
                    }
                }
            } else {
                // Untuk selain Lorong (Dapur, Laundry, Teras, Kamar Executive, dsb)
                $isKamarExecutive = str_starts_with(strtolower($ruang), 'kamar executive');
                $k = Kamar::firstOrCreate(
                    ['nomor_kamar' => $ruang],
                    [
                        'lokasi' => str_contains(strtolower($ruang), 'executive') ? 'Kamar Executive' : 'Gedung Utama',
                        'tipe_kamar' => $isKamarExecutive ? 'Executive Single Bed' : 'Fasilitas Umum',
                        'kapasitas' => $isKamarExecutive ? 1 : 50,
                        'status' => $isKamarExecutive ? 'kosong_bersih' : 'terisi'
                    ]
                );

                foreach ($asets as $key => $data) {
                    $namaAset = isset($data['real_nama']) ? $data['real_nama'] : $key;
                    
                    if (isset($asetMap[$namaAset])) {
                        DB::table('aset_kamar')->updateOrInsert(
                            ['kamar_id' => $k->id, 'aset_mess_id' => $asetMap[$namaAset], 'kondisi' => $data['kondisi']],
                            ['jumlah' => $data['jumlah']]
                        );
                    }
                }
            }
        }
    }
}
