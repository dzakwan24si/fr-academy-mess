<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        $tamu = Auth::guard('tamu')->user();
        $reservasi = Reservasi::with('kamar')
            ->where('tamu_id', $tamu->id)
            ->whereIn('status', ['pending', 'approved', 'checked_in'])
            ->first();

        // Fetch last reservation if no active one exists, to check for rejection
        $lastReservasi = null;
        if (!$reservasi) {
            $lastReservasi = Reservasi::where('tamu_id', $tamu->id)->latest()->first();
        }

        return view('livewire.guest.dashboard', [
            'tamu' => $tamu,
            'reservasi' => $reservasi,
            'lastReservasi' => $lastReservasi
        ]);
    }
}
