<?php

namespace App\Livewire\Guest\Dapur;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\RencanaMenuHarian;
use App\Models\FeedbackMasakan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Layout('layouts.app')]
#[Title('Menu Makanan Hari Ini')]
class Index extends Component
{
    public $rating = 0;
    public $komentar = '';
    public $selectedRencanaId = null;

    public function beriRating($rencanaId, $rate)
    {
        $this->selectedRencanaId = $rencanaId;
        $this->rating = $rate;
    }

    public function simpanFeedback()
    {
        $this->validate([
            'selectedRencanaId' => 'required|exists:rencana_menu_harians,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000'
        ]);

        $tamu = Auth::guard('tamu')->user();

        // Check if already rated
        $existing = FeedbackMasakan::where('rencana_menu_harian_id', $this->selectedRencanaId)
            ->where('tamu_id', $tamu->id)
            ->first();

        if ($existing) {
            $existing->update([
                'rating' => $this->rating,
                'komentar' => $this->komentar
            ]);
            session()->flash('success', 'Penilaian masakan berhasil diperbarui!');
        } else {
            FeedbackMasakan::create([
                'rencana_menu_harian_id' => $this->selectedRencanaId,
                'tamu_id' => $tamu->id,
                'rating' => $this->rating,
                'komentar' => $this->komentar
            ]);
            session()->flash('success', 'Terima kasih atas penilaian Anda!');
        }

        $this->reset(['selectedRencanaId', 'rating', 'komentar']);
    }

    public function render()
    {
        $tamu = Auth::guard('tamu')->user();
        $today = Carbon::today()->toDateString();

        $menus = RencanaMenuHarian::with('menu')
            ->where('tanggal', $today)
            ->orderByRaw("FIELD(waktu, 'pagi', 'siang', 'malam')")
            ->get();

        // Ambil semua riwayat feedback user hari ini
        $feedbacks = FeedbackMasakan::where('tamu_id', $tamu->id)
            ->whereIn('rencana_menu_harian_id', $menus->pluck('id'))
            ->get()
            ->keyBy('rencana_menu_harian_id');

        return view('livewire.guest.dapur.index', [
            'menus' => $menus,
            'feedbacks' => $feedbacks
        ]);
    }
}
