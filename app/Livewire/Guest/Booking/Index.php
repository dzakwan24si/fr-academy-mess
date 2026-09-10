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
    public $tanggal_checkout;

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
    }

    public function tutupModalBooking()
    {
        $this->isBookingModalOpen = false;
        $this->selectedKamar = null;
        $this->keperluan = '';
    }

    public function konfirmasiBooking()
    {
        $this->validate([
            'tanggal_checkin' => 'required|date|after_or_equal:today',
            'tanggal_checkout' => 'required|date|after:tanggal_checkin',
            'keperluan' => 'required|string|min:5',
        ]);

        $tamu = Auth::guard('tamu')->user();

        $reservasi = Reservasi::create([
            'tamu_id' => $tamu->id,
            'kamar_id' => $this->selectedKamar->id,
            'tanggal_checkin' => $this->tanggal_checkin,
            'tanggal_checkout' => $this->tanggal_checkout,
            'keperluan_menginap' => $this->keperluan,
            'status' => 'pending'
        ]);

        $admins = User::role(['Superadmin', 'Koordinator Mess'])->get();
        Notification::send($admins, new NewReservasiNotification($reservasi));
        
        $this->tutupModalBooking();

        return redirect()->route('guest.dashboard');
    }

    // Reset pagination when filter changes
    public function updatedTipeKamar()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = Kamar::where('status', 'kosong_bersih');

        if ($this->tipe_kamar != '') {
            $query->where('tipe_kamar', 'like', '%' . $this->tipe_kamar . '%');
        }

        $kamars = $query->paginate(6);

        return view('livewire.guest.booking.index', [
            'kamars' => $kamars
        ]);
    }
}
