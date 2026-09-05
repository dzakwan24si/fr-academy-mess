<?php

namespace App\Livewire\Guest\Profil;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
#[Title('Profil Saya')]
class Index extends Component
{
    public $nama;
    public $no_hp;
    public $perusahaan;
    public $jabatan;

    public function mount()
    {
        $tamu = Auth::guard('tamu')->user();
        $this->nama = $tamu->nama;
        $this->no_hp = $tamu->no_hp;
        $this->perusahaan = $tamu->perusahaan;
        $this->jabatan = $tamu->jabatan;
    }

    public function simpan()
    {
        $tamu = Auth::guard('tamu')->user();

        $this->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric|min:10|unique:tamus,no_hp,' . $tamu->id,
            'perusahaan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $tamu->update([
            'nama' => $this->nama,
            'no_hp' => $this->no_hp,
            'perusahaan' => $this->perusahaan,
            'jabatan' => $this->jabatan,
        ]);

        session()->flash('success', 'Profil berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.guest.profil.index');
    }
}
