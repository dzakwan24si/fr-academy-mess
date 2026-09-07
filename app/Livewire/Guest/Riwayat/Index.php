<?php

namespace App\Livewire\Guest\Riwayat;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('Riwayat Reservasi')]
class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $tamu = Auth::guard('tamu')->user();
        
        $riwayats = Reservasi::with('kamar')
            ->where('tamu_id', $tamu->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.guest.riwayat.index', [
            'tamu' => $tamu,
            'riwayats' => $riwayats
        ]);
    }
}
