<?php

namespace App\Livewire\Admin\Aset;

use App\Models\AsetMess;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('MASTER ASET MESS')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    // Form Modal
    public $isModalOpen = false;

    public $isDetailModalOpen = false;

    public $isEdit = false;

    public $selectedId = null;

    public $selectedAsetId = null;

    // Riwayat Modal
    public $isModalRiwayatOpen = false;

    public $riwayatAsetId = null;

    public $riwayatAsetTitle = '';

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
        $aset = AsetMess::findOrFail($id);
        $this->selectedAsetId = $aset->id;
        $this->isDetailModalOpen = true;
    }

    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->selectedAsetId = null;
    }

    public function bukaModalRiwayat($id)
    {
        $aset = AsetMess::with(['riwayatAktivitas' => function ($q) {
            $q->latest();
        }, 'riwayatAktivitas.user'])->findOrFail($id);

        // Fallback pemulihan foto bukti perbaikan dari aset_kamar jika belum tersimpan di riwayat_aktivitas
        foreach ($aset->riwayatAktivitas as $riwayat) {
            if (empty($riwayat->foto_bukti) && str_contains($riwayat->aksi, 'Perbaikan')) {
                $foto = DB::table('aset_kamar')
                    ->where('aset_mess_id', $aset->id)
                    ->whereNotNull('foto_perbaikan')
                    ->orderByDesc('id')
                    ->value('foto_perbaikan');

                if ($foto) {
                    $riwayat->foto_bukti = $foto;
                    $riwayat->save();
                }
            }
        }

        $this->riwayatAsetId = $aset->id;
        $this->riwayatAsetTitle = $aset->nama_aset;
        $this->isModalRiwayatOpen = true;
    }

    public function tutupModalRiwayat()
    {
        $this->isModalRiwayatOpen = false;
        $this->riwayatAsetId = null;
    }

    public function render()
    {
        $query = AsetMess::with('kamars')->orderBy('created_at', 'desc');

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('nama_aset', 'like', '%'.$this->search.'%')
                    ->orWhere('kategori', 'like', '%'.$this->search.'%');
            });
        }

        $asets = $query->paginate($this->perPage);

        // Pre-process agregasi kondisi
        $asets->getCollection()->transform(function ($aset) {
            $totalBaik = 0;
            $totalRusak = 0;
            $totalHilang = 0;

            foreach ($aset->kamars as $kamar) {
                $jumlah = $kamar->pivot?->jumlah ?? 0;
                $kondisi = $kamar->pivot?->kondisi ?? '';

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

        $selectedAset = null;
        if ($this->isDetailModalOpen && $this->selectedAsetId) {
            $selectedAset = AsetMess::with(['kamars' => function ($query) {
                $query->orderBy('nomor_kamar', 'asc');
            }])->find($this->selectedAsetId);
        }

        $riwayatList = collect();
        if ($this->isModalRiwayatOpen && $this->riwayatAsetId) {
            $aset = AsetMess::find($this->riwayatAsetId);
            if ($aset) {
                $riwayatList = $aset->riwayatAktivitas()
                    ->with('user')
                    ->latest()
                    ->get();
            }
        }

        return view('livewire.admin.aset.index', [
            'asets' => $asets,
            'selectedAset' => $selectedAset,
            'riwayatList' => $riwayatList,
        ]);
    }
}
