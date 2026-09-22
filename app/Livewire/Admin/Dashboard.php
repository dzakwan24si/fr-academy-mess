<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Reservasi;
use App\Models\Kamar;
use App\Models\KomplainKerusakan;
use App\Models\RequestLaundry;
use App\Models\RencanaMenuHarian;
use Carbon\Carbon;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public $chartRange = 7;
    public $showDetailModal = false;
    public $detailType = '';
    public $detailTitle = '';
    public $detailData = [];
    public function updatedChartRange()
    {
        $data = $this->getChartData();
        $this->dispatch('chart-updated', chartData: $data['data'], chartDates: $data['dates']);
    }

    private function getChartData()
    {
        $chartDates = [];
        $chartData = [];
        for ($i = $this->chartRange - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDates[] = $date->format('d M');
            
            $occupancy = Reservasi::whereDate('tanggal_checkin', '<=', $date)
                ->whereDate('tanggal_checkout', '>=', $date)
                ->whereIn('status', ['checked_in', 'completed'])
                ->count();
            $chartData[] = $occupancy;
        }
        return ['dates' => $chartDates, 'data' => $chartData];
    }

    public function render()
    {
        $today = Carbon::today();

        // 1. Kamar Metrics (Exclude Fasilitas Umum)
        $totalKamar = Kamar::where('tipe_kamar', '!=', 'Fasilitas Umum')->count();
        $kamarTerisi = Kamar::where('tipe_kamar', '!=', 'Fasilitas Umum')->where('status', 'terisi')->count();
        $kamarKotor = Kamar::where('tipe_kamar', '!=', 'Fasilitas Umum')->where('status', 'kosong_kotor')->count();

        // 2. Reservation Metrics
        $checkInHariIni = Reservasi::whereDate('tanggal_checkin', $today)->count();
        $checkOutHariIni = Reservasi::whereDate('tanggal_checkout', $today)->count();
        $reservasiPending = Reservasi::where('status', 'pending')->count();

        // 3. Operational Metrics
        $komplainBaru = KomplainKerusakan::where('status_perbaikan', 'dilaporkan')->count();
        $laundryBaru = RequestLaundry::where('status', 'menunggu')->count();

        // 4. Kitchen Metrics
        $porsiPagi = RencanaMenuHarian::whereDate('tanggal', $today)->where('waktu', 'Pagi')->max('target_porsi') ?? 0;
        $porsiSiang = RencanaMenuHarian::whereDate('tanggal', $today)->where('waktu', 'Siang')->max('target_porsi') ?? 0;
        $porsiMalam = RencanaMenuHarian::whereDate('tanggal', $today)->where('waktu', 'Malam')->max('target_porsi') ?? 0;

        // 5. Chart Data
        $chartInfo = $this->getChartData();
        $chartDates = $chartInfo['dates'];
        $chartData = $chartInfo['data'];

        // 6. Quick Info Tables (Recent 5 Reservations)
        $recentReservations = Reservasi::with(['tamu', 'kamar'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', compact(
            'totalKamar', 'kamarTerisi', 'kamarKotor',
            'checkInHariIni', 'checkOutHariIni', 'reservasiPending',
            'komplainBaru', 'laundryBaru',
            'porsiPagi', 'porsiSiang', 'porsiMalam',
            'chartDates', 'chartData',
            'recentReservations'
        ));
    }

    public function create()
    {
        // Placeholder untuk '+ Tambah Data'
    }

    public function view($id)
    {
        // Placeholder untuk 'View'
    }

    public function edit($id)
    {
        // Placeholder untuk 'Edit'
    }

    public function delete($id)
    {
        // Placeholder untuk 'Delete'
    }

    public function showDetail($type)
    {
        $this->detailType = $type;
        $this->showDetailModal = true;
        $today = Carbon::today();

        switch ($type) {
            case 'okupansi':
                $this->detailTitle = 'Detail Kamar Terisi';
                // Ambil semua reservasi aktif beserta data kamar dan tamu
                $this->detailData = Reservasi::with(['tamu', 'kamar'])
                    ->whereIn('status', ['checked_in'])
                    ->orderBy('tanggal_checkin', 'desc')
                    ->get();
                break;

            case 'kedatangan':
                $this->detailTitle = 'Jadwal Kedatangan Hari Ini';
                $this->detailData = Reservasi::with(['tamu', 'kamar'])
                    ->whereDate('tanggal_checkin', $today)
                    ->get();
                break;

            case 'kepulangan':
                $this->detailTitle = 'Jadwal Kepulangan Hari Ini';
                $this->detailData = Reservasi::with(['tamu', 'kamar'])
                    ->whereDate('tanggal_checkout', $today)
                    ->get();
                break;

            case 'pending':
                $this->detailTitle = 'Reservasi Menunggu Persetujuan';
                $this->detailData = Reservasi::with(['tamu', 'kamar'])
                    ->where('status', 'pending')
                    ->get();
                break;

            case 'perlu_bersih':
                $this->detailTitle = 'Daftar Kamar Perlu Dibersihkan';
                $this->detailData = Kamar::whereIn('status', ['kosong_kotor', 'kotor_sebagian'])
                    ->where('tipe_kamar', '!=', 'Fasilitas Umum')
                    ->get();
                break;

            case 'komplain_baru':
                $this->detailTitle = 'Laporan Komplain Baru';
                $this->detailData = KomplainKerusakan::with(['reservasi.tamu', 'reservasi.kamar'])
                    ->where('status_perbaikan', 'dilaporkan')
                    ->latest()
                    ->get();
                break;
        }
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->detailType = '';
        $this->detailData = [];
    }
}
