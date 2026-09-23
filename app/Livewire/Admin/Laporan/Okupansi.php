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

        if ($this->bulan !== 'all' && $this->tahun !== 'all') {
            $startOfMonth = Carbon::create($this->tahun, $this->bulan, 1)->startOfMonth()->format('Y-m-d');
            $endOfMonth = Carbon::create($this->tahun, $this->bulan, 1)->endOfMonth()->format('Y-m-d');
            
            $query->where('tanggal_checkin', '<=', $endOfMonth)
                  ->where('tanggal_checkout', '>=', $startOfMonth);
        } elseif ($this->tahun !== 'all') {
            $startOfYear = Carbon::create($this->tahun, 1, 1)->startOfYear()->format('Y-m-d');
            $endOfYear = Carbon::create($this->tahun, 1, 1)->endOfYear()->format('Y-m-d');
            
            $query->where('tanggal_checkin', '<=', $endOfYear)
                  ->where('tanggal_checkout', '>=', $startOfYear);
        } elseif ($this->bulan !== 'all') {
            $query->whereMonth('tanggal_checkin', $this->bulan);
        }

        return $query;
    }

    public function render()
    {
        $reservasis = $this->getQuery()->orderBy('tanggal_checkin', 'desc')->paginate(15);
        
        // Data rekap untuk UI (opsional, tapi bagus untuk manajerial)
        $totalTamu = $this->getQuery()->count();
        $totalSelesai = $this->getQuery()->where('status', 'completed')->count();

        // Data Chart: Trainee vs Tamu Umum
        $traineeCount = $this->getQuery()->whereHas('tamu', function($q) {
            $q->where('kategori', 'trainee');
        })->count();
        
        $umumCount = $totalTamu - $traineeCount;

        // Data Chart: Kamar Paling Sering Digunakan
        // Clone the base query to preserve filters but change the select/group/order
        $topKamar = $this->getQuery()
            ->whereNotNull('kamar_id')
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

        if ($this->bulan !== 'all' && $this->tahun !== 'all') {
            $startOfMonth = Carbon::create($this->tahun, $this->bulan, 1)->startOfMonth()->format('Y-m-d');
            $endOfMonth = Carbon::create($this->tahun, $this->bulan, 1)->endOfMonth()->format('Y-m-d');
            
            $topKomplainQuery->where('reservasis.tanggal_checkin', '<=', $endOfMonth)
                             ->where('reservasis.tanggal_checkout', '>=', $startOfMonth);
        } elseif ($this->tahun !== 'all') {
            $startOfYear = Carbon::create($this->tahun, 1, 1)->startOfYear()->format('Y-m-d');
            $endOfYear = Carbon::create($this->tahun, 1, 1)->endOfYear()->format('Y-m-d');
            
            $topKomplainQuery->where('reservasis.tanggal_checkin', '<=', $endOfYear)
                             ->where('reservasis.tanggal_checkout', '>=', $startOfYear);
        } elseif ($this->bulan !== 'all') {
            $topKomplainQuery->whereMonth('reservasis.tanggal_checkin', $this->bulan);
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
        $data = $this->getQuery()->orderBy('tanggal_checkin', 'desc')->get();
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
