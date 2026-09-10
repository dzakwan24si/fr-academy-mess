<?php

namespace App\Livewire\Admin\Kamar;

use App\Models\Kamar;
use App\Models\AsetMess;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('INVENTARIS KAMAR')]
class Aset extends Component
{
    public Kamar $kamar;

    // Form Modal
    public $isModalOpen = false;
    public $isEdit = false;
    public $selectedPivotId = null;

    // Fields
    public $aset_mess_id;
    public $jumlah = 1;
    public $kondisi = 'Baik';
    public $keterangan = '';
    public $tanggal_maintenance = null;

    public function mount(Kamar $kamar)
    {
        $this->kamar = $kamar;
    }

    public function bukaModal($pivotId = null)
    {
        $this->resetValidation();
        if ($pivotId) {
            $this->isEdit = true;
            $this->selectedPivotId = $pivotId;
            
            // Find pivot data manually from relationship
            $aset = $this->kamar->asets()->wherePivot('id', $pivotId)->first();
            
            $this->aset_mess_id = $aset->id;
            $this->jumlah = $aset->pivot->jumlah;
            $this->kondisi = $aset->pivot->kondisi;
            $this->keterangan = $aset->pivot->keterangan;
            $this->tanggal_maintenance = $aset->pivot->tanggal_maintenance;
        } else {
            $this->isEdit = false;
            $this->selectedPivotId = null;
            $this->reset(['aset_mess_id', 'keterangan', 'tanggal_maintenance']);
            $this->jumlah = 1;
            $this->kondisi = 'Baik';
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
            'aset_mess_id' => 'required|exists:aset_messes,id',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'keterangan' => 'nullable|string',
            'tanggal_maintenance' => 'nullable|date',
        ]);

        if ($this->isEdit) {
            $this->kamar->asets()->wherePivot('id', $this->selectedPivotId)->updateExistingPivot($this->aset_mess_id, [
                'jumlah' => $this->jumlah,
                'kondisi' => $this->kondisi,
                'keterangan' => $this->keterangan,
                'tanggal_maintenance' => $this->tanggal_maintenance,
            ]);
        } else {
            $this->kamar->asets()->attach($this->aset_mess_id, [
                'jumlah' => $this->jumlah,
                'kondisi' => $this->kondisi,
                'keterangan' => $this->keterangan,
                'tanggal_maintenance' => $this->tanggal_maintenance,
            ]);
        }

        $this->tutupModal();
        
        // Refresh kamar relation
        $this->kamar->load('asets');
    }

    public function hapus($pivotId, $asetId)
    {
        $this->kamar->asets()->wherePivot('id', $pivotId)->detach($asetId);
        $this->kamar->load('asets');
    }

    public function render()
    {
        $masterAset = AsetMess::orderBy('nama_aset', 'asc')->get();
        
        $asetLorong = [];
        if (str_contains(strtolower($this->kamar->nomor_kamar), 'lorong')) {
            preg_match('/\d+/', $this->kamar->nomor_kamar, $matches);
            if (!empty($matches)) {
                $lorongNo = $matches[0];
                $kamarIds = [];
                for ($no = 1; $no <= 4; $no++) {
                    $kamarIds[] = "Kamar " . sprintf('%d%02d', $lorongNo, $no);
                }
                
                $kamars = Kamar::whereIn('nomor_kamar', $kamarIds)->with('asets')->get();
                
                // Aggregate assets
                foreach ($kamars as $k) {
                    foreach ($k->asets as $aset) {
                        $key = $aset->id . '_' . $aset->pivot->kondisi;
                        if (!isset($asetLorong[$key])) {
                            $asetLorong[$key] = [
                                'nama_aset' => $aset->nama_aset,
                                'kategori' => $aset->kategori,
                                'jumlah' => 0,
                                'kondisi' => $aset->pivot->kondisi,
                            ];
                        }
                        $asetLorong[$key]['jumlah'] += $aset->pivot->jumlah;
                    }
                }
            }
        }

        return view('livewire.admin.kamar.aset', [
            'masterAset' => $masterAset,
            'asetLorong' => collect($asetLorong)->values()
        ]);
    }
}
