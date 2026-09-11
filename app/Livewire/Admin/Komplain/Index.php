<?php

namespace App\Livewire\Admin\Komplain;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\KomplainKerusakan;
use App\Models\User;
use App\Notifications\KomplainSelesaiNotification;
use Illuminate\Support\Facades\Notification;

#[Layout('layouts.admin')]
#[Title('Komplain & Kerusakan')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';
    public $filterStatus = '';

    // Modal properties
    public $isModalOpen = false;
    public $selectedId = null;
    public $status_perbaikan = '';
    public $teknisi_id = null;
    
    // For view details
    public $komplainDetail = null;

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
        $komplain = KomplainKerusakan::with(['reservasi.kamar', 'reservasi.tamu', 'teknisi'])->findOrFail($id);
        
        $this->komplainDetail = $komplain;
        $this->status_perbaikan = $komplain->status_perbaikan;
        $this->teknisi_id = $komplain->teknisi_id;
        
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
        $this->selectedId = null;
        $this->komplainDetail = null;
    }

    public function simpanProses()
    {
        $this->validate([
            'status_perbaikan' => 'required|in:dilaporkan,diproses,selesai',
            'teknisi_id' => 'nullable|exists:users,id',
        ]);

        $komplain = KomplainKerusakan::findOrFail($this->selectedId);
        $oldStatus = $komplain->status_perbaikan;
        
        $komplain->update([
            'status_perbaikan' => $this->status_perbaikan,
            'teknisi_id' => $this->teknisi_id ?: null,
        ]);

        if ($oldStatus != 'selesai' && $this->status_perbaikan == 'selesai') {
            $admins = User::role(['Superadmin', 'Koordinator Mess'])->get();
            Notification::send($admins, new KomplainSelesaiNotification($komplain));
            
            if ($komplain->reservasi && $komplain->reservasi->tamu) {
                $komplain->reservasi->tamu->notify(new KomplainSelesaiNotification($komplain));
            }

            if ($komplain->reservasi && $komplain->reservasi->kamar_id) {
                \App\Models\RiwayatAktivitas::create([
                    'trackable_type' => \App\Models\Kamar::class,
                    'trackable_id' => $komplain->reservasi->kamar_id,
                    'user_id' => \Illuminate\Support\Facades\Auth::id(),
                    'aksi' => 'Perbaikan Komplain Selesai',
                    'keterangan' => 'Komplain (' . $komplain->judul_komplain . ') telah diselesaikan oleh Admin.',
                ]);
            }
        }

        // If completed, maybe free up room if it was in maintenance? 
        // For now, let's keep it simple and just update the complaint status.

        $this->tutupModal();
        session()->flash('success', 'Status komplain berhasil diperbarui!');
    }

    public function hapus($id)
    {
        KomplainKerusakan::findOrFail($id)->delete();
        session()->flash('success', 'Data komplain berhasil dihapus.');
    }

    public function render()
    {
        $query = KomplainKerusakan::with(['reservasi.kamar', 'reservasi.tamu', 'teknisi'])
            ->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->whereHas('reservasi.tamu', function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
            })->orWhereHas('reservasi.kamar', function($q) {
                $q->where('nomor_kamar', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterStatus)) {
            $query->where('status_perbaikan', $this->filterStatus);
        }

        $teknisis = User::role('Teknisi')->get();

        return view('livewire.admin.komplain.index', [
            'komplains' => $query->paginate($this->perPage),
            'teknisis' => $teknisis
        ]);
    }
}
