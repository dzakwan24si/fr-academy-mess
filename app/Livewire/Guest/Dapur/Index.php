<?php

namespace App\Livewire\Guest\Dapur;

use App\Models\FeedbackMasakan;
use App\Models\RencanaMenuHarian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

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

        $tamu = Auth::guard('tamu')->user() ?? Auth::user();
        if ($tamu) {
            $existing = FeedbackMasakan::where('rencana_menu_harian_id', $rencanaId)
                ->where('tamu_id', $tamu->id)
                ->first();
            if ($existing) {
                $this->komentar = $existing->komentar ?? '';
            }
        }
    }

    public function simpanFeedback()
    {
        $this->validate([
            'selectedRencanaId' => 'required|exists:rencana_menu_harians,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $tamu = Auth::guard('tamu')->user() ?? Auth::user();

        if (! $tamu) {
            session()->flash('error', 'Sesi login Anda telah berakhir. Silakan login kembali.');

            return;
        }

        // Check if already rated
        $existing = FeedbackMasakan::where('rencana_menu_harian_id', $this->selectedRencanaId)
            ->where('tamu_id', $tamu->id)
            ->first();

        if ($existing) {
            $existing->update([
                'rating' => $this->rating,
                'komentar' => $this->komentar,
            ]);
            session()->flash('success', 'Penilaian masakan berhasil diperbarui!');
        } else {
            FeedbackMasakan::create([
                'rencana_menu_harian_id' => $this->selectedRencanaId,
                'tamu_id' => $tamu->id,
                'rating' => $this->rating,
                'komentar' => $this->komentar,
            ]);
            session()->flash('success', 'Terima kasih atas penilaian Anda!');
        }

        $this->reset(['selectedRencanaId', 'rating', 'komentar']);
    }

    public function render()
    {
        $tamu = Auth::guard('tamu')->user() ?? Auth::user();
        $today = Carbon::today()->toDateString();

        $menus = RencanaMenuHarian::with('menu')
            ->where('tanggal', $today)
            ->orderByRaw("FIELD(waktu, 'pagi', 'siang', 'malam')")
            ->get();

        // Ambil semua riwayat feedback user hari ini
        $feedbacks = $tamu ? FeedbackMasakan::where('tamu_id', $tamu->id)
            ->whereIn('rencana_menu_harian_id', $menus->pluck('id'))
            ->get()
            ->keyBy('rencana_menu_harian_id') : collect();

        return view('livewire.guest.dapur.index', [
            'menus' => $menus,
            'feedbacks' => $feedbacks,
        ]);
    }
}
