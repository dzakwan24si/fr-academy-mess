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

    // --- State & Methods untuk Survei & Evaluasi ---
    public $isModalSurveiOpen = false;
    public $kebersihan_kamar = 0;
    public $kebersihan_toilet = 0;
    public $kualitas_makanan = 0;
    public $kenyamanan_fasilitas = 0;
    public $pelayanan_staf = 0;
    public $saran_masukan = '';

    public function bukaModalSurvei()
    {
        $this->reset(['kebersihan_kamar', 'kebersihan_toilet', 'kualitas_makanan', 'kenyamanan_fasilitas', 'pelayanan_staf', 'saran_masukan']);
        // Default to 0 stars
        $this->kebersihan_kamar = 0;
        $this->kebersihan_toilet = 0;
        $this->kualitas_makanan = 0;
        $this->kenyamanan_fasilitas = 0;
        $this->pelayanan_staf = 0;
        $this->isModalSurveiOpen = true;
    }

    public function tutupModalSurvei()
    {
        $this->isModalSurveiOpen = false;
    }

    public function simpanSurvei()
    {
        $tamu = Auth::guard('tamu')->user();
        $reservasi = Reservasi::where('tamu_id', $tamu->id)
            ->whereIn('status', ['checked_in'])
            ->first();

        if (!$reservasi) {
            session()->flash('error', 'Anda harus dalam status Check-in untuk mengisi survei.');
            return;
        }

        $this->validate([
            'kebersihan_kamar' => 'required|integer|min:1|max:5',
            'kebersihan_toilet' => 'required|integer|min:1|max:5',
            'kualitas_makanan' => 'required|integer|min:1|max:5',
            'kenyamanan_fasilitas' => 'required|integer|min:1|max:5',
            'pelayanan_staf' => 'required|integer|min:1|max:5',
            'saran_masukan' => 'nullable|string|max:1000',
        ]);

        \App\Models\SurveiKepuasanKamar::create([
            'reservasi_id' => $reservasi->id,
            'kebersihan_kamar' => $this->kebersihan_kamar,
            'kebersihan_toilet' => $this->kebersihan_toilet,
            'kualitas_makanan' => $this->kualitas_makanan,
            'kenyamanan_fasilitas' => $this->kenyamanan_fasilitas,
            'pelayanan_staf' => $this->pelayanan_staf,
            'saran_masukan' => $this->saran_masukan,
            // Fallback for old required fields
            'rating' => round(($this->kebersihan_kamar + $this->kebersihan_toilet + $this->kualitas_makanan + $this->kenyamanan_fasilitas + $this->pelayanan_staf) / 5),
            'komentar' => substr($this->saran_masukan, 0, 50),
        ]);

        $this->tutupModalSurvei();
        session()->flash('success_survei', 'Terima kasih atas penilaian Anda!');
    }
}
