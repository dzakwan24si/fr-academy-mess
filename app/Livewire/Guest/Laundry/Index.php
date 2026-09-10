<?php

namespace App\Livewire\Guest\Laundry;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\RequestLaundry;
use App\Models\DetailLaundry;
use App\Models\Reservasi;
use App\Models\User;
use App\Notifications\NewLaundryRequestNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

#[Layout('layouts.app')]
#[Title('Request Laundry')]
class Index extends Component
{
    public $items = [];

    public function mount()
    {
        // Init with one empty item row
        $this->tambahItem();
    }

    public function tambahItem()
    {
        $this->items[] = ['item_pakaian' => '', 'jumlah' => 1];
    }

    public function hapusItem($index)
    {
        if (count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function simpan()
    {
        $this->validate([
            'items' => 'required|array|min:1',
            'items.*.item_pakaian' => 'required|string|max:255',
            'items.*.jumlah' => 'required|integer|min:1',
        ], [
            'items.*.item_pakaian.required' => 'Nama pakaian harus diisi.',
            'items.*.jumlah.required' => 'Jumlah harus diisi.',
            'items.*.jumlah.min' => 'Jumlah minimal 1.',
        ]);

        $tamu = Auth::guard('tamu')->user();
        $reservasi = Reservasi::where('tamu_id', $tamu->id)
            ->whereIn('status', ['approved', 'checked_in'])
            ->first();

        if (!$reservasi) {
            session()->flash('error', 'Anda tidak memiliki reservasi aktif untuk request laundry.');
            return;
        }

        DB::beginTransaction();
        try {
            $requestLaundry = RequestLaundry::create([
                'reservasi_id' => $reservasi->id,
                'tanggal_request' => Carbon::now()->toDateString(),
                'status' => 'menunggu'
            ]);

            foreach ($this->items as $item) {
                DetailLaundry::create([
                    'request_laundry_id' => $requestLaundry->id,
                    'item_pakaian' => $item['item_pakaian'],
                    'jumlah' => $item['jumlah']
                ]);
            }

            $admins = User::role(['Superadmin', 'Koordinator Mess'])->get();
            Notification::send($admins, new NewLaundryRequestNotification($requestLaundry));

            DB::commit();

            session()->flash('success', 'Request laundry berhasil dikirim! Silakan letakkan pakaian Anda di keranjang depan kamar.');
            $this->items = [];
            $this->tambahItem();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $tamu = Auth::guard('tamu')->user();
        $reservasi = Reservasi::where('tamu_id', $tamu->id)
            ->whereIn('status', ['approved', 'checked_in'])
            ->first();

        $riwayatLaundries = [];
        if ($reservasi) {
            $riwayatLaundries = RequestLaundry::with('detailLaundries')
                ->where('reservasi_id', $reservasi->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('livewire.guest.laundry.index', [
            'reservasi' => $reservasi,
            'riwayatLaundries' => $riwayatLaundries
        ]);
    }
}
