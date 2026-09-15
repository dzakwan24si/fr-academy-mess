<?php

namespace App\Livewire\Admin\Survei;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\SurveiKepuasanKamar;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('layouts.admin')]
#[Title('Evaluasi & Survei')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;
    
    public $search = '';
    public $bulan;
    public $tahun;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = SurveiKepuasanKamar::with(['reservasi.tamu', 'reservasi.kamar'])
            ->whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->latest();

        if ($this->search) {
            $query->whereHas('reservasi.tamu', function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
            })->orWhereHas('reservasi.kamar', function ($q) {
                $q->where('nomor_kamar', 'like', '%' . $this->search . '%');
            });
        }

        $surveis = $query->paginate($this->perPage);

        // Calculate averages
        $statsQuery = SurveiKepuasanKamar::whereMonth('created_at', $this->bulan)->whereYear('created_at', $this->tahun);
        
        $stats = [
            'total' => (clone $statsQuery)->count(),
            'avg_kamar' => (clone $statsQuery)->avg('kebersihan_kamar') ?? 0,
            'avg_toilet' => (clone $statsQuery)->avg('kebersihan_toilet') ?? 0,
            'avg_makanan' => (clone $statsQuery)->avg('kualitas_makanan') ?? 0,
            'avg_fasilitas' => (clone $statsQuery)->avg('kenyamanan_fasilitas') ?? 0,
            'avg_staf' => (clone $statsQuery)->avg('pelayanan_staf') ?? 0,
        ];

        return view('livewire.admin.survei.index', compact('surveis', 'stats'));
    }

    public function exportPdf()
    {
        $query = SurveiKepuasanKamar::with(['reservasi.tamu', 'reservasi.kamar'])
            ->whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->latest();

        if ($this->search) {
            $query->whereHas('reservasi.tamu', function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
            })->orWhereHas('reservasi.kamar', function ($q) {
                $q->where('nomor_kamar', 'like', '%' . $this->search . '%');
            });
        }

        $data = $query->get();
        
        $totalResponden = $data->count();
        // Since we want the overall average for the PDF
        if ($totalResponden > 0) {
            // We use the same manual calculation logic as the old view
            // The table has rating, and maybe the 5 new categories
            $rataRataRating = $data->map(function ($s) {
                if ($s->kebersihan_kamar !== null) {
                    return ($s->kebersihan_kamar + $s->kebersihan_toilet + $s->kualitas_makanan + $s->kenyamanan_fasilitas + $s->pelayanan_staf) / 5;
                }
                return $s->rating;
            })->avg();
        } else {
            $rataRataRating = 0;
        }

        $pdf = Pdf::loadView('pdf.laporan-evaluasi', [
            'data' => $data,
            'totalResponden' => $totalResponden,
            'rataRataRating' => round((float) $rataRataRating, 1),
            'bulan' => \Carbon\Carbon::create()->month($this->bulan)->translatedFormat('F'),
            'tahun' => $this->tahun
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "Laporan-Kepuasan-Tamu.pdf");
    }
}
