<?php

namespace App\Livewire\Admin\Survei;

use App\Models\SurveiKepuasanKamar;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

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
        $query = SurveiKepuasanKamar::with([
            'reservasi' => function ($q) {
                $q->withTrashed()->with([
                    'tamu' => fn ($t) => $t->withTrashed(),
                    'kamar' => fn ($k) => $k->withTrashed(),
                ]);
            },
        ])->latest();

        if ($this->bulan !== 'all') {
            $query->whereMonth('created_at', $this->bulan);
        }

        if ($this->tahun !== 'all') {
            $query->whereYear('created_at', $this->tahun);
        }

        if ($this->search) {
            $query->where(function ($nested) {
                $nested->whereHas('reservasi.tamu', function ($q) {
                    $q->where('nama', 'like', '%'.$this->search.'%');
                })->orWhereHas('reservasi.kamar', function ($q) {
                    $q->where('nomor_kamar', 'like', '%'.$this->search.'%');
                });
            });
        }

        $surveis = $query->paginate($this->perPage);

        // Calculate averages
        $statsQuery = SurveiKepuasanKamar::query();

        if ($this->bulan !== 'all') {
            $statsQuery->whereMonth('created_at', $this->bulan);
        }

        if ($this->tahun !== 'all') {
            $statsQuery->whereYear('created_at', $this->tahun);
        }

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
        // Pastikan direktori fonts tersedia untuk cache DomPDF
        $fontDir = storage_path('fonts');
        if (! file_exists($fontDir)) {
            @mkdir($fontDir, 0775, true);
        }

        $query = SurveiKepuasanKamar::with([
            'reservasi' => function ($q) {
                $q->withTrashed()->with([
                    'tamu' => fn ($t) => $t->withTrashed(),
                    'kamar' => fn ($k) => $k->withTrashed(),
                ]);
            },
        ])->latest();

        if ($this->bulan !== 'all') {
            $query->whereMonth('created_at', $this->bulan);
        }

        if ($this->tahun !== 'all') {
            $query->whereYear('created_at', $this->tahun);
        }

        if ($this->search) {
            $query->where(function ($nested) {
                $nested->whereHas('reservasi.tamu', function ($q) {
                    $q->where('nama', 'like', '%'.$this->search.'%');
                })->orWhereHas('reservasi.kamar', function ($q) {
                    $q->where('nomor_kamar', 'like', '%'.$this->search.'%');
                });
            });
        }

        $data = $query->get();

        $totalResponden = $data->count();
        if ($totalResponden > 0) {
            $rataRataRating = $data->map(function ($s) {
                if ($s->kebersihan_kamar !== null) {
                    return ($s->kebersihan_kamar + $s->kebersihan_toilet + $s->kualitas_makanan + $s->kenyamanan_fasilitas + $s->pelayanan_staf) / 5;
                }

                return $s->rating;
            })->avg();
        } else {
            $rataRataRating = 0;
        }

        // Siapkan logo dalam format base64 agar aman dirender oleh DomPDF di server linux/production
        $logoPath = public_path('logofr.jpg');
        if (! file_exists($logoPath)) {
            $logoPath = public_path('logofr.png');
        }
        $logoBase64 = file_exists($logoPath) ? 'data:image/'.pathinfo($logoPath, PATHINFO_EXTENSION).';base64,'.base64_encode(file_get_contents($logoPath)) : null;

        $namaBulan = $this->bulan === 'all'
            ? 'Semua Bulan'
            : Carbon::createFromDate(null, (int) $this->bulan, 1)->translatedFormat('F');

        $pdf = Pdf::loadView('pdf.laporan-evaluasi', [
            'data' => $data,
            'totalResponden' => $totalResponden,
            'rataRataRating' => round((float) $rataRataRating, 1),
            'bulan' => $namaBulan,
            'tahun' => $this->tahun === 'all' ? 'Semua Tahun' : $this->tahun,
            'logoBase64' => $logoBase64,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "Laporan-Kepuasan-Tamu-{$namaBulan}-{$this->tahun}.pdf");
    }
}
