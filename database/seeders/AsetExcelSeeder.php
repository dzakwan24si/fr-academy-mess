<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kamar;
use App\Models\AsetMess;
use Illuminate\Support\Facades\DB;

class AsetExcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama jika perlu (Opsional, di-comment agar aman)
        // DB::table('aset_kamar')->truncate();
        
        // 1. BUAT MASTER ASET DARI EXCEL (DUMMY DATA BERDASARKAN PEMAHAMAN)
        $masterAsets = [
            // Kebutuhan Mess
            ['nama_aset' => 'Kasur Busa', 'kategori' => 'Furnitur', 'total_stok' => 100],
            ['nama_aset' => 'Kasur Springbed', 'kategori' => 'Furnitur', 'total_stok' => 50],
            ['nama_aset' => 'Divan Kayu', 'kategori' => 'Furnitur', 'total_stok' => 100],
            ['nama_aset' => 'Lemari Pakaian 2 Pintu', 'kategori' => 'Furnitur', 'total_stok' => 100],
            ['nama_aset' => 'Bantal', 'kategori' => 'Linen & Kamar Mandi', 'total_stok' => 200],
            ['nama_aset' => 'Sprei', 'kategori' => 'Linen & Kamar Mandi', 'total_stok' => 200],
            ['nama_aset' => 'AC Panasonic 1/2 PK', 'kategori' => 'Elektronik', 'total_stok' => 50],
            ['nama_aset' => 'Gorden', 'kategori' => 'Lainnya', 'total_stok' => 100],
            ['nama_aset' => 'Kipas Angin', 'kategori' => 'Elektronik', 'total_stok' => 50],
            ['nama_aset' => 'Televisi 32 Inch', 'kategori' => 'Elektronik', 'total_stok' => 10],
            ['nama_aset' => 'Kulkas Mini', 'kategori' => 'Elektronik', 'total_stok' => 10],
            
            // Kebutuhan Fasilitas Umum
            ['nama_aset' => 'Meja Bulat', 'kategori' => 'Furnitur', 'total_stok' => 20],
            ['nama_aset' => 'Meja Panjang', 'kategori' => 'Furnitur', 'total_stok' => 15],
            ['nama_aset' => 'Kursi Merah Futura', 'kategori' => 'Furnitur', 'total_stok' => 150],
            ['nama_aset' => 'Infocus / Proyektor', 'kategori' => 'Elektronik', 'total_stok' => 5],
            ['nama_aset' => 'Whiteboard', 'kategori' => 'Peralatan', 'total_stok' => 10],
            ['nama_aset' => 'Sound System', 'kategori' => 'Elektronik', 'total_stok' => 3],
        ];

        $asetMap = [];
        foreach ($masterAsets as $aset) {
            $created = AsetMess::firstOrCreate(
                ['nama_aset' => $aset['nama_aset']],
                ['kategori' => $aset['kategori'], 'total_stok' => $aset['total_stok']]
            );
            $asetMap[$aset['nama_aset']] = $created->id;
        }

        // 2. DATA KAMAR MESS (Berdasarkan Lorong 1-12 & Executive)
        $kamarMess = [];
        // Buat lorong 1-12 (Reguler)
        for ($lorong = 1; $lorong <= 12; $lorong++) {
            for ($no = 1; $no <= 5; $no++) {
                $nomor = sprintf('%d%02d', $lorong, $no);
                $kamarMess[] = [
                    'nomor_kamar' => "Kamar $nomor",
                    'lokasi' => "Lorong $lorong",
                    'tipe_kamar' => 'Reguler Twin Bed',
                    'kapasitas' => 2,
                    'status' => 'kosong_bersih',
                ];
            }
        }
        // Executive
        for ($no = 1; $no <= 5; $no++) {
            $nomor = sprintf('VIP-%02d', $no);
            $kamarMess[] = [
                'nomor_kamar' => $nomor,
                'lokasi' => "Kamar Executive",
                'tipe_kamar' => 'Executive Single Bed',
                'kapasitas' => 1,
                'status' => 'kosong_bersih',
            ];
        }

        foreach ($kamarMess as $kamar) {
            $k = Kamar::firstOrCreate(
                ['nomor_kamar' => $kamar['nomor_kamar']],
                $kamar
            );

            // Assign Aset ke Kamar Mess
            if (str_contains($k->nomor_kamar, 'VIP')) {
                // Kamar Executive dapet Kasur Springbed, Kulkas, TV, AC
                $k->asets()->syncWithoutDetaching([
                    $asetMap['Kasur Springbed'] => ['jumlah' => 1, 'kondisi' => 'Baik'],
                    $asetMap['Divan Kayu'] => ['jumlah' => 1, 'kondisi' => 'Baik'],
                    $asetMap['Lemari Pakaian 2 Pintu'] => ['jumlah' => 1, 'kondisi' => 'Baik'],
                    $asetMap['AC Panasonic 1/2 PK'] => ['jumlah' => 1, 'kondisi' => 'Baik'],
                    $asetMap['Televisi 32 Inch'] => ['jumlah' => 1, 'kondisi' => 'Baik'],
                    $asetMap['Kulkas Mini'] => ['jumlah' => 1, 'kondisi' => 'Baik'],
                ]);
            } else {
                // Kamar Reguler Lorong dapet Kasur Busa (Twin), Kipas/AC
                $k->asets()->syncWithoutDetaching([
                    $asetMap['Kasur Busa'] => ['jumlah' => 2, 'kondisi' => 'Baik'],
                    $asetMap['Divan Kayu'] => ['jumlah' => 2, 'kondisi' => 'Baik'],
                    $asetMap['Lemari Pakaian 2 Pintu'] => ['jumlah' => 2, 'kondisi' => 'Rusak Ringan'],
                    $asetMap['Kipas Angin'] => ['jumlah' => 1, 'kondisi' => 'Baik'],
                ]);
            }
        }

        // 3. DATA FASILITAS UMUM / KANTOR (R. Planter, Aula, dll)
        $fasilitasUmum = [
            'Ruang Planter' => [
                'Meja Bulat' => 6, 'AC Panasonic 1/2 PK' => 5, 'Meja Panjang' => 1, 'Sound System' => 1, 'Kursi Merah Futura' => 35, 'Infocus / Proyektor' => 1, 'Whiteboard' => 1
            ],
            'Ruang Administrasi' => [
                'AC Panasonic 1/2 PK' => 2, 'Meja Panjang' => 4, 'Kursi Merah Futura' => 10, 'Whiteboard' => 1
            ],
            'R. Loyality & Integrity' => [
                'AC Panasonic 1/2 PK' => 4, 'Whiteboard' => 1, 'Kursi Merah Futura' => 36
            ],
            'Aula' => [
                'Kursi Merah Futura' => 100, 'Sound System' => 2, 'Infocus / Proyektor' => 2, 'AC Panasonic 1/2 PK' => 8
            ],
            'Gudang Mess' => [
                // Bisa diisi stok awal barang-barang di gudang yang belum didistribusikan
                'Kasur Busa' => 20, 'Bantal' => 50, 'Sprei' => 50, 'Kipas Angin' => 5
            ]
        ];

        foreach ($fasilitasUmum as $ruang => $asets) {
            $k = Kamar::firstOrCreate(
                ['nomor_kamar' => $ruang],
                [
                    'lokasi' => 'Gedung Utama',
                    'tipe_kamar' => 'Fasilitas Umum',
                    'kapasitas' => 50,
                    'status' => 'terisi' // Atau status khusus fasum
                ]
            );

            foreach ($asets as $namaAset => $jumlah) {
                if (isset($asetMap[$namaAset])) {
                    $k->asets()->syncWithoutDetaching([
                        $asetMap[$namaAset] => ['jumlah' => $jumlah, 'kondisi' => 'Baik']
                    ]);
                }
            }
        }
    }
}
