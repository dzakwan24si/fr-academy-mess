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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = SurveiKepuasanKamar::with(['reservasi.tamu', 'reservasi.kamar'])
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
        $stats = [
            'total' => SurveiKepuasanKamar::count(),
            'avg_kamar' => SurveiKepuasanKamar::avg('kebersihan_kamar') ?? 0,
            'avg_toilet' => SurveiKepuasanKamar::avg('kebersihan_toilet') ?? 0,
            'avg_makanan' => SurveiKepuasanKamar::avg('kualitas_makanan') ?? 0,
            'avg_fasilitas' => SurveiKepuasanKamar::avg('kenyamanan_fasilitas') ?? 0,
            'avg_staf' => SurveiKepuasanKamar::avg('pelayanan_staf') ?? 0,
        ];

        return view('livewire.admin.survei.index', compact('surveis', 'stats'));
    }

    public function exportPdf()
    {
        $query = SurveiKepuasanKamar::with(['reservasi.tamu', 'reservasi.kamar'])
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
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "Laporan-Kepuasan-Tamu.pdf");
    }
}
