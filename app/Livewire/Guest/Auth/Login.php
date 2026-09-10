<?php

namespace App\Livewire\Guest\Auth;

use App\Models\Tamu;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $no_hp;
    public $nama;
    public $perusahaan;
    public $jabatan;
    
    public $isRegistering = false;

    public function cekNomor()
    {
        $this->validate([
            'no_hp' => 'required|numeric|min:10'
        ]);

        $tamu = Tamu::where('no_hp', $this->no_hp)->first();

        if ($tamu) {
            Auth::guard('tamu')->login($tamu);
            
            $reservasi = Reservasi::where('tamu_id', $tamu->id)
                ->whereIn('status', ['pending', 'approved', 'checked_in'])
                ->first();
                
            if ($reservasi) {
                return redirect()->intended(route('guest.dashboard'));
            } else {
                return redirect()->intended(route('guest.booking'));
            }
        } else {
            $this->isRegistering = true;
        }
    }
    
    public function batalDaftar()
    {
        $this->isRegistering = false;
        $this->reset(['nama', 'perusahaan', 'jabatan']);
    }

    public function daftarTamu()
    {
        $this->validate([
            'no_hp' => 'required|numeric|min:10|unique:tamus,no_hp',
            'nama' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        $tamu = Tamu::create([
            'no_hp' => $this->no_hp,
            'nama' => $this->nama,
            'perusahaan' => $this->perusahaan,
            'jabatan' => $this->jabatan,
        ]);

        Auth::guard('tamu')->login($tamu);

        return redirect()->intended(route('guest.booking'));
    }

    public function render()
    {
        return view('livewire.guest.auth.login');
    }
}
