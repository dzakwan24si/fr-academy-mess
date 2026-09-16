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
        $aktivitas = collect();

        if (!$reservasi) {
            $lastReservasi = Reservasi::where('tamu_id', $tamu->id)->latest()->first();
        } else {
            // 1. Fetch Laundry Requests
            $laundries = \App\Models\RequestLaundry::with('detailLaundries')
                ->where('reservasi_id', $reservasi->id)
                ->latest()
                ->get()
                ->map(function($item) {
                    $totalPcs = $item->detailLaundries->sum('jumlah');
                    return (object) [
                        'type' => 'laundry',
                        'title' => 'Request Laundry (' . $totalPcs . ' Pcs)',
                        'time' => $item->created_at,
                        'status' => $item->status,
                        'id' => $item->id
                    ];
                });

            // 2. Fetch Complaints
            $komplains = \App\Models\KomplainKerusakan::where('reservasi_id', $reservasi->id)
                ->latest()
                ->get()
                ->map(function($item) {
                    return (object) [
                        'type' => 'komplain',
                        'title' => 'Laporan Kerusakan',
                        'desc' => $item->deskripsi,
                        'time' => $item->created_at,
                        'status' => $item->status_perbaikan,
                        'id' => $item->id
                    ];
                });

            $aktivitas = $laundries->concat($komplains)->sortByDesc('time')->take(5);
        }

        return view('livewire.guest.dashboard', [
            'tamu' => $tamu,
            'reservasi' => $reservasi,
            'lastReservasi' => $lastReservasi,
            'aktivitas' => $aktivitas
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

    public function ajukanCheckout()
    {
        $tamu = Auth::guard('tamu')->user();
        $reservasi = Reservasi::where('tamu_id', $tamu->id)
            ->where('status', 'checked_in')
            ->first();
            
        if ($reservasi) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($reservasi) {
                $reservasi->update(['status' => 'completed']);
                
                if ($reservasi->kamar) {
                    $reservasi->kamar->update(['status' => 'kosong_kotor']);

                    // Notify about dirty room
                    $admins = \App\Models\User::role(['Superadmin', 'Koordinator Mess', 'Staf Kebersihan'])->get();
                    if ($admins->count() > 0) {
                        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\KebersihanKamarNotification($reservasi->kamar, 'kotor'));
                    }
                }
            });
            
            // Log activity manually for the checkout
            \Illuminate\Support\Facades\DB::table('riwayat_aktivitas')->insert([
                'user_id' => null, // Guest action, not admin
                'trackable_type' => \App\Models\Reservasi::class,
                'trackable_id' => $reservasi->id,
                'aksi' => 'Checkout',
                'keterangan' => 'Tamu melakukan self check-out melalui dashboard tamu.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return redirect()->route('guest.dashboard');
        }
    }
}
