<?php

namespace App\Livewire\Admin\Reservasi;

use App\Models\Reservasi;
use App\Models\Kamar;
use App\Models\User;
use App\Models\Tamu;
use App\Notifications\StatusReservasiNotification;
use App\Notifications\KebersihanKamarNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('MANAJEMEN RESERVASI')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';
    public $filterStatus = '';
    
    public $isModalTolakOpen = false;
    public $alasanTolak = '';
    public $selectedReservasiId = null;

    // Form Walk-in Reservation
    public $isModalBuatOpen = false;
    public $form_nama = '';
    public $form_no_hp = '';
    public $form_perusahaan = '';
    public $form_jabatan = '';
    public $form_tgl_checkin = '';
    public $form_tgl_checkout = '';
    public $form_kamar_id = '';
    public $form_keperluan = '';

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

        if ($reservasi->tamu) {
            $reservasi->tamu->notify(new StatusReservasiNotification($reservasi));
        }
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

        if ($reservasi->tamu) {
            $reservasi->tamu->notify(new StatusReservasiNotification($reservasi));
        }

        $this->tutupModalTolak();
    }

    public function bukaModalBuat()
    {
        $this->reset([
            'form_nama', 'form_no_hp', 'form_perusahaan', 'form_jabatan',
            'form_tgl_checkin', 'form_tgl_checkout', 'form_kamar_id', 'form_keperluan'
        ]);
        $this->form_tgl_checkin = \Carbon\Carbon::today()->format('Y-m-d');
        $this->isModalBuatOpen = true;
    }

    public function tutupModalBuat()
    {
        $this->isModalBuatOpen = false;
    }

    public function simpanWalkIn()
    {
        $this->validate([
            'form_nama' => 'required|string|max:255',
            'form_no_hp' => 'required|string|max:20',
            'form_perusahaan' => 'nullable|string|max:255',
            'form_jabatan' => 'nullable|string|max:255',
            'form_tgl_checkin' => 'required|date',
            'form_tgl_checkout' => 'required|date|after_or_equal:form_tgl_checkin',
            'form_keperluan' => 'required|string',
            'form_kamar_id' => 'nullable|exists:kamars,id'
        ]);

        // Cari Tamu berdasarkan No HP, atau buat baru
        $tamu = \App\Models\Tamu::firstOrCreate(
            ['no_hp' => $this->form_no_hp],
            [
                'nama' => $this->form_nama,
                'perusahaan' => $this->form_perusahaan,
                'jabatan' => $this->form_jabatan
            ]
        );

        // Buat Reservasi dengan status 'approved'
        Reservasi::create([
            'tamu_id' => $tamu->id,
            'kamar_id' => $this->form_kamar_id ?: null,
            'tanggal_checkin' => $this->form_tgl_checkin,
            'tanggal_checkout' => $this->form_tgl_checkout,
            'keperluan_menginap' => $this->form_keperluan,
            'status' => 'approved'
        ]);

        $this->tutupModalBuat();
    }

    public function prosesCheckIn($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($reservasi) {
            $reservasi->update(['status' => 'checked_in']);
            
            if ($reservasi->kamar) {
                $reservasi->kamar->update(['status' => 'terisi']);
            }
        });
    }

    public function prosesCheckOut($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($reservasi) {
            $reservasi->update(['status' => 'completed']);
            
            if ($reservasi->kamar) {
                $reservasi->kamar->update(['status' => 'kosong_kotor']);

                // Notify about dirty room
                $admins = User::role(['Superadmin', 'Koordinator Mess', 'Staf Kebersihan'])->get();
                if ($admins->count() > 0) {
                    Notification::send($admins, new KebersihanKamarNotification($reservasi->kamar, 'kotor'));
                }
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
            'reservasis' => $query->paginate($this->perPage),
            'availableRooms' => Kamar::where('status', 'kosong_bersih')->get()
        ]);
    }
}
