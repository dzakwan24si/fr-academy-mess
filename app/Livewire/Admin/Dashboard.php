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
    public function render()
    {
        $today = Carbon::today();

        // 1. Kamar Metrics
        $totalKamar = Kamar::count();
        $kamarTerisi = Kamar::where('status', 'terisi')->count();
        $kamarKotor = Kamar::where('status', 'kosong_kotor')->count();

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

        // 5. Chart Data (7 Days Occupancy)
        $chartDates = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDates[] = $date->format('d M');
            
            $occupancy = Reservasi::whereDate('tanggal_checkin', '<=', $date)
                ->whereDate('tanggal_checkout', '>=', $date)
                ->whereIn('status', ['checked_in', 'completed'])
                ->count();
            $chartData[] = $occupancy;
        }

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
}
