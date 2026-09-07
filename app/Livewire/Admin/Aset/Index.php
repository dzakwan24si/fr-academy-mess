<?php

namespace App\Livewire\Admin\Aset;

use App\Models\AsetMess;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('MASTER ASET MESS')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    
    // Form Modal
    public $isModalOpen = false;
    public $isDetailModalOpen = false;
    public $isEdit = false;
    public $selectedId = null;
    public $selectedAset = null;

    // Fields
    public $nama_aset;
    public $kategori = 'Elektronik';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function bukaModal($id = null)
    {
        $this->resetValidation();
        if ($id) {
            $this->isEdit = true;
            $this->selectedId = $id;
            
            $aset = AsetMess::findOrFail($id);
            $this->nama_aset = $aset->nama_aset;
            $this->kategori = $aset->kategori;
        } else {
            $this->isEdit = false;
            $this->selectedId = null;
            $this->reset(['nama_aset', 'kategori']);
            $this->kategori = 'Elektronik';
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
            'nama_aset' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
        ]);

        if ($this->isEdit) {
            $aset = AsetMess::findOrFail($this->selectedId);
            $aset->update([
                'nama_aset' => $this->nama_aset,
                'kategori' => $this->kategori,
            ]);
        } else {
            AsetMess::create([
                'nama_aset' => $this->nama_aset,
                'kategori' => $this->kategori,
            ]);
        }

        $this->tutupModal();
    }

    public function hapus($id)
    {
        AsetMess::findOrFail($id)->delete();
    }

    public function showDetail($id)
    {
        $this->selectedAset = AsetMess::with(['kamars' => function ($query) {
            $query->orderBy('nomor_kamar', 'asc');
        }])->findOrFail($id);
        
        $this->isDetailModalOpen = true;
    }

    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->selectedAset = null;
    }

    public function render()
    {
        $query = AsetMess::with('kamars')->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->where('nama_aset', 'like', '%' . $this->search . '%')
                  ->orWhere('kategori', 'like', '%' . $this->search . '%');
        }

        $asets = $query->paginate(10);

        // Pre-process agregasi kondisi
        $asets->getCollection()->transform(function ($aset) {
            $totalBaik = 0;
            $totalRusak = 0;
            $totalHilang = 0;

            foreach ($aset->kamars as $kamar) {
                $jumlah = $kamar->pivot->jumlah;
                $kondisi = $kamar->pivot->kondisi;

                if ($kondisi === 'Baik') {
                    $totalBaik += $jumlah;
                } elseif (in_array($kondisi, ['Rusak Ringan', 'Rusak Berat'])) {
                    $totalRusak += $jumlah;
                } elseif ($kondisi === 'Hilang') {
                    $totalHilang += $jumlah;
                }
            }

            $aset->total_baik = $totalBaik;
            $aset->total_rusak = $totalRusak;
            $aset->total_hilang = $totalHilang;
            $aset->total_distribusi = $totalBaik + $totalRusak + $totalHilang;

            return $aset;
        });

        return view('livewire.admin.aset.index', [
            'asets' => $asets
        ]);
    }
}
