<?php

namespace App\Livewire\Guest\Booking;

use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\User;
use App\Notifications\NewReservasiNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $tipe_kamar = '';
    public $tanggal_checkin;
    public $perkiraan_jam_checkin;
    public $tanggal_checkout;

    public $search = '';
    public $perPage = 6;
    public $perPageOptions = [6, 12, 18, 24, 30];

    // Modal state
    public $isBookingModalOpen = false;
    public $selectedKamar = null;
    public $keperluan = '';

    public function mount()
    {
        $this->tanggal_checkin = Carbon::today()->format('Y-m-d');
        $this->tanggal_checkout = Carbon::tomorrow()->format('Y-m-d');
    }

    public function bukaModalBooking($kamarId)
    {
        $this->selectedKamar = Kamar::find($kamarId);
        $this->isBookingModalOpen = true;
        $this->keperluan = '';
        $this->perkiraan_jam_checkin = '';
    }

    public function tutupModalBooking()
    {
        $this->isBookingModalOpen = false;
        $this->selectedKamar = null;
        $this->keperluan = '';
        $this->perkiraan_jam_checkin = '';
    }

    public function konfirmasiBooking()
    {
        $this->validate([
            'tanggal_checkin' => 'required|date|after_or_equal:today',
            'perkiraan_jam_checkin' => 'required',
            'tanggal_checkout' => 'required|date|after:tanggal_checkin',
            'keperluan' => 'required|string|min:5',
        ]);

        $tamu = Auth::guard('tamu')->user();

        $reservasi = Reservasi::create([
            'tamu_id' => $tamu->id,
            'kamar_id' => $this->selectedKamar->id,
            'tanggal_checkin' => $this->tanggal_checkin,
            'perkiraan_jam_checkin' => $this->perkiraan_jam_checkin ?: null,
            'tanggal_checkout' => $this->tanggal_checkout,
            'keperluan_menginap' => $this->keperluan,
            'status' => 'pending'
        ]);

        $admins = User::role(['Superadmin', 'Koordinator Mess'])->get();
        Notification::send($admins, new NewReservasiNotification($reservasi));
        
        $this->tutupModalBooking();

        return redirect()->route('guest.dashboard');
    }

    public function updatedTipeKamar()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = Kamar::query()
            ->withCount(['reservasis as active_guests_count' => function ($query) {
                $query->whereIn('status', ['approved', 'checked_in']);
            }])
            ->where('tipe_kamar', '!=', 'Fasilitas Umum')
            ->where('nomor_kamar', 'not like', 'Lorong%')
            ->orderByRaw("CASE WHEN status = 'kosong_bersih' THEN 0 ELSE 1 END")
            ->orderByRaw("REPLACE(nomor_kamar, 'Kamar ', '') ASC");

        if ($this->tipe_kamar != '') {
            $query->where('tipe_kamar', 'like', '%' . $this->tipe_kamar . '%');
        }

        if ($this->search != '') {
            $query->where(function ($q) {
                $q->where('nomor_kamar', 'like', '%' . $this->search . '%')
                  ->orWhere('tipe_kamar', 'like', '%' . $this->search . '%');
            });
        }

        $kamars = $query->paginate($this->perPage);

        return view('livewire.guest.booking.index', [
            'kamars' => $kamars
        ]);
    }
}
