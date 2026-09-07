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
                            'stok' => $bahan->stok,
                            'total_qty' => 0,
                            'qty_beli' => 0,
                            'total_harga' => 0,
                        ];
                    }
                    
                    $kebutuhanBahan[$bahan->id]['total_qty'] += $qtyDibutuhkan;
                }
            }
        }

        // Kalkulasi Total Harga dan Qty Beli (setelah dikurangi stok Gudang)
        foreach ($kebutuhanBahan as $key => $item) {
            $kekurangan = $item['total_qty'] - $item['stok'];
            
            if ($kekurangan > 0) {
                $kebutuhanBahan[$key]['qty_beli'] = $kekurangan;
                $kebutuhanBahan[$key]['total_harga'] = $kekurangan * $item['harga_satuan'];
            } else {
                // Hapus bahan dari daftar belanja jika stok gudang sudah mencukupi
                unset($kebutuhanBahan[$key]);
            }
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
    public function printJadwal(Request $request)
    {
        $startDate = $request->query('start');
        $endDate = $request->query('end');
        $namaPelatihan = $request->query('pelatihan', '');
        $jumlahPeserta = $request->query('peserta', '');

        if (!$startDate || !$endDate) {
            abort(400, 'Parameter rentang tanggal tidak valid.');
        }

        $rencanaHarians = RencanaMenuHarian::with('menu')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'asc')
            ->get();

        $infoHarian = \App\Models\InformasiHarianDapur::whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->keyBy('tanggal');

        // Group by Tanggal, then by Waktu
        $jadwal = [];
        $currentDate = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($currentDate->lte($end)) {
            $dateString = $currentDate->format('Y-m-d');
            $jadwal[$dateString] = [
                'hari' => $currentDate->locale('id')->isoFormat('dddd'),
                'tanggal_format' => $currentDate->locale('id')->isoFormat('D MMMM YYYY'),
                'jus_trainer' => isset($infoHarian[$dateString]) ? $infoHarian[$dateString]->jus_trainer : '',
                'menus' => [
                    'pagi' => [],
                    'siang' => [],
                    'malam' => []
                ],
                'porsi' => [
                    'pagi' => 0,
                    'siang' => 0,
                    'malam' => 0
                ]
            ];
            $currentDate->addDay();
        }

        foreach ($rencanaHarians as $rencana) {
            $waktu = strtolower($rencana->waktu);
            if (isset($jadwal[$rencana->tanggal]['menus'][$waktu])) {
                $jadwal[$rencana->tanggal]['menus'][$waktu][] = $rencana->menu->nama_menu;
                // Ambil porsi terbesar untuk waktu tersebut jika ada banyak menu
                if ($rencana->target_porsi > $jadwal[$rencana->tanggal]['porsi'][$waktu]) {
                    $jadwal[$rencana->tanggal]['porsi'][$waktu] = $rencana->target_porsi;
                }
            }
        }

        // Format tanggal header
        $startFormat = Carbon::parse($startDate)->locale('id')->isoFormat('D MMMM YYYY');
        $endFormat = Carbon::parse($endDate)->locale('id')->isoFormat('D MMMM YYYY');
        $periode = $startFormat . ' - ' . $endFormat;

        return view('exports.print-jadwal-menu', compact(
            'jadwal',
            'namaPelatihan',
            'jumlahPeserta',
            'periode'
        ));
    }
}
