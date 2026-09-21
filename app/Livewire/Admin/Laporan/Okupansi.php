<?php

namespace App\Livewire\Admin\Laporan;

use App\Models\Reservasi;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

#[Layout('layouts.admin')]
#[Title('LAPORAN OKUPANSI')]
class Okupansi extends Component
{
    use WithPagination;

    public $bulan;
    public $tahun;

    public function mount()
    {
        $this->bulan = Carbon::now()->month;
        $this->tahun = Carbon::now()->year;
    }

    public function updated($property)
    {
        if ($property === 'bulan' || $property === 'tahun') {
            $this->resetPage();
            $this->dispatch('charts-updated');
        }
    }

    public function getQuery()
    {
        $query = Reservasi::with(['tamu', 'kamar'])
            ->whereIn('status', ['approved', 'checked_in', 'completed']);

        if ($this->bulan !== 'all') {
            $query->whereMonth('tanggal_checkin', $this->bulan);
        }

        if ($this->tahun !== 'all') {
            $query->whereYear('tanggal_checkin', $this->tahun);
        }

        return $query->orderBy('tanggal_checkin', 'desc');
    }

    public function render()
    {
        $reservasis = $this->getQuery()->paginate(15);
        
        // Data rekap untuk UI (opsional, tapi bagus untuk manajerial)
        $totalTamu = $this->getQuery()->count();
        $totalSelesai = $this->getQuery()->where('status', 'completed')->count();

        // Data Chart: Trainee vs Tamu Umum
        $traineeCount = $this->getQuery()->whereHas('tamu', function($q) {
            $q->where('kategori', 'trainee');
        })->count();
        
        $umumCount = $totalTamu - $traineeCount;

        // Data Chart: Kamar Paling Sering Digunakan
        $topKamarQuery = Reservasi::whereNotNull('kamar_id')
            ->whereIn('status', ['approved', 'checked_in', 'completed']);
            
        if ($this->bulan !== 'all') {
            $topKamarQuery->whereMonth('tanggal_checkin', $this->bulan);
        }
        if ($this->tahun !== 'all') {
            $topKamarQuery->whereYear('tanggal_checkin', $this->tahun);
        }

        $topKamar = $topKamarQuery
            ->select('kamar_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('kamar_id')
            ->orderBy('total', 'desc')
            ->with('kamar')
            ->get();

        // Data Chart: Kamar Paling Sering Komplain
        $topKomplainQuery = \Illuminate\Support\Facades\DB::table('komplain_kerusakans')
            ->join('reservasis', 'komplain_kerusakans.reservasi_id', '=', 'reservasis.id')
            ->join('kamars', 'reservasis.kamar_id', '=', 'kamars.id')
            ->whereNull('komplain_kerusakans.deleted_at')
            ->whereNull('reservasis.deleted_at');

        if ($this->bulan !== 'all') {
            $topKomplainQuery->whereMonth('reservasis.tanggal_checkin', $this->bulan);
        }
        if ($this->tahun !== 'all') {
            $topKomplainQuery->whereYear('reservasis.tanggal_checkin', $this->tahun);
        }

        $topKomplain = $topKomplainQuery
            ->select('kamars.nomor_kamar', \Illuminate\Support\Facades\DB::raw('count(komplain_kerusakans.id) as total'))
            ->groupBy('kamars.nomor_kamar')
            ->orderBy('total', 'desc')
            ->get();

        return view('livewire.admin.laporan.okupansi', [
            'reservasis' => $reservasis,
            'totalTamu' => $totalTamu,
            'totalSelesai' => $totalSelesai,
            'traineeCount' => $traineeCount,
            'umumCount' => $umumCount,
            'topKamar' => $topKamar,
            'topKomplain' => $topKomplain,
        ]);
    }

    public function exportPdf()
    {
        $data = $this->getQuery()->get();
        $namaBulan = $this->bulan === 'all' ? 'Semua Bulan' : Carbon::create()->month((int) $this->bulan)->translatedFormat('F');

        $pdf = Pdf::loadView('pdf.laporan-okupansi', [
            'data' => $data,
            'bulan' => $namaBulan,
            'tahun' => $this->tahun === 'all' ? 'Semua Tahun' : $this->tahun
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "Laporan-Okupansi-{$namaBulan}-{$this->tahun}.pdf");
    }
}
