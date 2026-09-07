<?php

namespace App\Livewire\Admin\Kamar;

use App\Models\Kamar;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('MANAJEMEN KAMAR')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    // Form Modal
    public $isModalOpen = false;
    public $isEdit = false;
    public $kamar_id = null;

    // Fields
    public $nomor_kamar;
    public $lokasi;
    public $tipe_kamar = 'Reguler Twin Bed';
    public $kapasitas = 2;
    public $status = 'kosong_bersih';

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function bukaModal($id = null)
    {
        $this->resetValidation();
        if ($id) {
            $kamar = Kamar::findOrFail($id);
            $this->kamar_id = $kamar->id;
            $this->nomor_kamar = $kamar->nomor_kamar;
            $this->lokasi = $kamar->lokasi;
            $this->tipe_kamar = $kamar->tipe_kamar;
            $this->kapasitas = $kamar->kapasitas;
            $this->status = $kamar->status;
            $this->isEdit = true;
        } else {
            $this->isEdit = false;
            $this->kamar_id = null;
            $this->reset(['nomor_kamar', 'lokasi', 'tipe_kamar', 'kapasitas', 'status']);
            $this->tipe_kamar = 'Reguler Twin Bed';
            $this->kapasitas = 2;
            $this->status = 'kosong_bersih';
        }
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
    }

    public function simpan()
    {
        $this->validate([
            'nomor_kamar' => 'required|string|max:50|unique:kamars,nomor_kamar,' . $this->kamar_id,
            'lokasi' => 'nullable|string|max:255',
            'tipe_kamar' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:kosong_bersih,kosong_kotor,terisi,maintenance',
        ]);

        Kamar::updateOrCreate(
            ['id' => $this->kamar_id],
            [
                'nomor_kamar' => $this->nomor_kamar,
                'lokasi' => $this->lokasi,
                'tipe_kamar' => $this->tipe_kamar,
                'kapasitas' => $this->kapasitas,
                'status' => $this->status,
            ]
        );

        $this->tutupModal();
    }

    public function hapus($id)
    {
        Kamar::findOrFail($id)->delete();
    }

    public function render()
    {
        $query = Kamar::orderBy('nomor_kamar', 'asc');

        if (!empty($this->search)) {
            $query->where('nomor_kamar', 'like', '%' . $this->search . '%')
                  ->orWhere('tipe_kamar', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.admin.kamar.index', [
            'kamars' => $query->paginate(10)
        ]);
    }
}
