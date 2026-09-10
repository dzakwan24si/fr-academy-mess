<?php

namespace App\Livewire\Guest\Komplain;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\KomplainKerusakan;
use App\Models\Reservasi;
use App\Models\User;
use App\Notifications\NewKomplainNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

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

        $komplain = KomplainKerusakan::create([
            'reservasi_id' => $reservasi->id,
            'deskripsi' => $this->deskripsi,
            'foto_bukti' => $fotoPath,
            'status_perbaikan' => 'dilaporkan'
        ]);

        $admins = User::role(['Superadmin', 'Koordinator Mess'])->get();
        // Teknisi may be notified if we have a role for Teknisi, but maybe let's get all users with Teknisi role if it exists, or just keep it simple. User specified "Superadmin, Koord Mess, dan Teknisi (Pak Tepung)".
        $teknisi = User::where('name', 'like', '%Tepung%')->orWhere('email', 'like', '%teknisi%')->first();
        if ($teknisi) {
            $admins->push($teknisi);
        }
        
        Notification::send($admins, new NewKomplainNotification($komplain));

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
