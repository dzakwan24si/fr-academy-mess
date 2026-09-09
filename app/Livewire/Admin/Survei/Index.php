<?php

namespace App\Livewire\Admin\Survei;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\SurveiKepuasanKamar;
use Livewire\WithPagination;

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
}
