<?php

namespace App\Livewire\Guest\Komplain;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\KomplainKerusakan;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('Lapor Kerusakan')]
class Index extends Component
{
    use WithFileUploads;

    public $deskripsi;
    public $foto_bukti;

    public function simpan()
    {
        $this->validate([
            'deskripsi' => 'required|string|min:10',
            'foto_bukti' => 'nullable|image|max:5120', // Max 5MB
        ]);

        $tamu = Auth::guard('tamu')->user();
        $reservasi = Reservasi::where('tamu_id', $tamu->id)
            ->whereIn('status', ['approved', 'checked_in'])
            ->first();

        if (!$reservasi) {
            session()->flash('error', 'Anda tidak memiliki reservasi aktif untuk dilaporkan.');
            return;
        }

        $fotoPath = null;
        if ($this->foto_bukti) {
            $fotoPath = $this->foto_bukti->store('komplain', 'public');
        }

        KomplainKerusakan::create([
            'reservasi_id' => $reservasi->id,
            'deskripsi' => $this->deskripsi,
            'foto_bukti' => $fotoPath,
            'status_perbaikan' => 'dilaporkan'
        ]);

        session()->flash('success', 'Laporan kerusakan berhasil dikirim. Teknisi kami akan segera menindaklanjuti.');
        $this->reset(['deskripsi', 'foto_bukti']);
    }

    public function render()
    {
        $tamu = Auth::guard('tamu')->user();
        $reservasi = Reservasi::where('tamu_id', $tamu->id)
            ->whereIn('status', ['approved', 'checked_in'])
            ->first();

        $komplains = [];
        if ($reservasi) {
            $komplains = KomplainKerusakan::where('reservasi_id', $reservasi->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('livewire.guest.komplain.index', [
            'reservasi' => $reservasi,
            'komplains' => $komplains
        ]);
    }
}
