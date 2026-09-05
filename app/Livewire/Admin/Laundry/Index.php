<?php

namespace App\Livewire\Admin\Laundry;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\RequestLaundry;

#[Layout('components.layouts.admin')]
#[Title('Manajemen Laundry')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    // Modal properties
    public $isModalOpen = false;
    public $selectedId = null;
    public $status = '';
    public $laundryDetail = null;

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function bukaModalProses($id)
    {
        $this->resetValidation();
        $this->selectedId = $id;
        $laundry = RequestLaundry::with(['reservasi.kamar', 'reservasi.tamu', 'detailLaundries'])->findOrFail($id);
        
        $this->laundryDetail = $laundry;
        $this->status = $laundry->status;
        
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
        $this->selectedId = null;
        $this->laundryDetail = null;
    }

    public function simpanProses()
    {
        $this->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
        ]);

        $laundry = RequestLaundry::findOrFail($this->selectedId);
        $laundry->update([
            'status' => $this->status,
        ]);

        $this->tutupModal();
        session()->flash('success', 'Status laundry berhasil diperbarui!');
    }

    public function hapus($id)
    {
        RequestLaundry::findOrFail($id)->delete();
        session()->flash('success', 'Data request laundry berhasil dihapus.');
    }

    public function render()
    {
        $query = RequestLaundry::with(['reservasi.kamar', 'reservasi.tamu', 'detailLaundries'])
            ->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->whereHas('reservasi.tamu', function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
            })->orWhereHas('reservasi.kamar', function($q) {
                $q->where('nomor_kamar', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.admin.laundry.index', [
            'laundries' => $query->paginate(10)
        ]);
    }
}
