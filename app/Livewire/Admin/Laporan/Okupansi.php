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
        }
    }

    public function getQuery()
    {
        return Reservasi::with(['tamu', 'kamar'])
            ->whereIn('status', ['approved', 'checked_in', 'completed'])
            ->whereMonth('tanggal_checkin', $this->bulan)
            ->whereYear('tanggal_checkin', $this->tahun)
            ->orderBy('tanggal_checkin', 'desc');
    }

    public function render()
    {
        $reservasis = $this->getQuery()->paginate(15);
        
        // Data rekap untuk UI (opsional, tapi bagus untuk manajerial)
        $totalTamu = $this->getQuery()->count();
        $totalSelesai = $this->getQuery()->where('status', 'completed')->count();

        return view('livewire.admin.laporan.okupansi', [
            'reservasis' => $reservasis,
            'totalTamu' => $totalTamu,
            'totalSelesai' => $totalSelesai,
        ]);
    }

    public function exportPdf()
    {
        $data = $this->getQuery()->get();
        $namaBulan = Carbon::create()->month($this->bulan)->translatedFormat('F');

        $pdf = Pdf::loadView('pdf.laporan-okupansi', [
            'data' => $data,
            'bulan' => $namaBulan,
            'tahun' => $this->tahun
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "Laporan-Okupansi-{$namaBulan}-{$this->tahun}.pdf");
    }
}
