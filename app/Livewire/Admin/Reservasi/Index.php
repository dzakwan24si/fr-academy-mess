<?php

namespace App\Livewire\Admin\Reservasi;

use App\Models\Reservasi;
use App\Models\Kamar;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('MANAJEMEN RESERVASI')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    
    public $isModalTolakOpen = false;
    public $alasanTolak = '';
    public $selectedReservasiId = null;

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function setujuiBooking($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status' => 'approved']);
    }

    public function bukaModalTolak($id)
    {
        $this->selectedReservasiId = $id;
        $this->alasanTolak = '';
        $this->isModalTolakOpen = true;
    }
    
    public function tutupModalTolak()
    {
        $this->isModalTolakOpen = false;
        $this->selectedReservasiId = null;
        $this->alasanTolak = '';
    }

    public function tolakBooking()
    {
        $this->validate([
            'alasanTolak' => 'required|string|min:5'
        ]);

        $reservasi = Reservasi::findOrFail($this->selectedReservasiId);
        $reservasi->update([
            'status' => 'rejected',
            'alasan_penolakan' => $this->alasanTolak
        ]);

        $this->tutupModalTolak();
    }

    public function prosesCheckIn($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status' => 'checked_in']);
    }

    public function prosesCheckOut($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($reservasi) {
            $reservasi->update(['status' => 'completed']);
            
            if ($reservasi->kamar) {
                $reservasi->kamar->update(['status' => 'kotor']);
            }
        });
    }

    public function render()
    {
        $query = Reservasi::with(['tamu', 'kamar'])
            ->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->whereHas('tamu', function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.admin.reservasi.index', [
            'reservasis' => $query->paginate(10)
        ]);
    }
}
