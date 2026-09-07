<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RencanaMenuHarian;
use App\Models\BahanBaku;
use Carbon\Carbon;

class DapurExportController extends Controller
{
    public function printBelanja(Request $request)
    {
        $startDate = $request->query('start');
        $endDate = $request->query('end');
        $namaPelatihan = $request->query('pelatihan', 'FAT I,MAT I,TAT I 2027');
        $jumlahPeserta = $request->query('peserta', '55 Orang');
        $tanggalPelatihan = $request->query('tanggal_teks', '24 Agustus - 1 September 2026');

        if (!$startDate || !$endDate) {
            abort(400, 'Parameter rentang tanggal tidak valid.');
        }

        // Ambil semua rencana menu dalam rentang tanggal, beserta resepnya
        $rencanaHarians = RencanaMenuHarian::with('menu.bahanBakus')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        $kebutuhanBahan = [];

        foreach ($rencanaHarians as $rencana) {
            $porsi = $rencana->target_porsi > 0 ? $rencana->target_porsi : 100; // Fallback jika tidak ada porsi

            if ($rencana->menu && $rencana->menu->bahanBakus) {
                foreach ($rencana->menu->bahanBakus as $bahan) {
                    $qtyDibutuhkan = $bahan->pivot->jumlah_dibutuhkan * $porsi;
                    
                    if (!isset($kebutuhanBahan[$bahan->id])) {
                        $kebutuhanBahan[$bahan->id] = [
                            'id' => $bahan->id,
                            'nama_bahan' => $bahan->nama_bahan,
                            'satuan' => $bahan->satuan,
                            'kategori' => $bahan->kategori_bahan,
                            'keterangan_volume' => $bahan->keterangan_volume,
                            'harga_satuan' => $bahan->harga_satuan,
                            'total_qty' => 0,
                            'total_harga' => 0,
                        ];
                    }
                    
                    $kebutuhanBahan[$bahan->id]['total_qty'] += $qtyDibutuhkan;
                }
            }
        }

        // Kalkulasi Total Harga untuk setiap item
        foreach ($kebutuhanBahan as $key => $item) {
            $kebutuhanBahan[$key]['total_harga'] = $item['total_qty'] * $item['harga_satuan'];
        }

        // Pisahkan Kering dan Basah
        $bahanKering = collect($kebutuhanBahan)->where('kategori', 'Kering')->values();
        $bahanBasah = collect($kebutuhanBahan)->where('kategori', 'Basah')->values();

        return view('exports.print-belanja', compact(
            'bahanKering', 
            'bahanBasah', 
            'namaPelatihan', 
            'jumlahPeserta', 
            'tanggalPelatihan'
        ));
    }
}
