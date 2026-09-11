<?php

namespace App\Livewire\Admin\Kebersihan;

use App\Models\Kamar;
use App\Models\RiwayatAktivitas;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\KebersihanKamarNotification;
use Illuminate\Support\Facades\Notification;

#[Layout('layouts.admin')]
#[Title('Tugas Kebersihan')]
class Index extends Component
{
    use WithFileUploads;

    public $kamarIdAktif = null;
    public $kamarNomorAktif = '';
    public $isModalSelesaiOpen = false;
    public $fotoBukti;
    public $catatanKebersihan = '';

    public function bukaModalSelesai($id, $nomor)
    {
        $this->resetValidation();
        $this->kamarIdAktif = $id;
        $this->kamarNomorAktif = $nomor;
        $this->fotoBukti = null;
        $this->catatanKebersihan = '';
        $this->isModalSelesaiOpen = true;
    }

    public function tutupModalSelesai()
    {
        $this->isModalSelesaiOpen = false;
        $this->kamarIdAktif = null;
        $this->kamarNomorAktif = '';
        $this->fotoBukti = null;
        $this->catatanKebersihan = '';
    }

    public function simpanPenyelesaian()
    {
        $this->validate([
            'fotoBukti' => 'nullable|image|max:2048',
            'catatanKebersihan' => 'nullable|string|max:500',
        ]);

        $kamar = Kamar::findOrFail($this->kamarIdAktif);
        
        $pathFoto = null;
        if ($this->fotoBukti) {
            $pathFoto = $this->fotoBukti->store('bukti_kebersihan', 'public');
        }

        $kamar->update(['status' => 'kosong_bersih']);

        $keterangan = 'Status kamar diubah menjadi Kosong Bersih oleh Staf Kebersihan.';
        if (!empty($this->catatanKebersihan)) {
            $keterangan .= ' Catatan: ' . $this->catatanKebersihan;
        }

        RiwayatAktivitas::create([
            'trackable_type' => Kamar::class,
            'trackable_id' => $kamar->id,
            'user_id' => Auth::id(),
            'aksi' => 'Kamar Dibersihkan',
            'keterangan' => $keterangan,
            'foto_bukti' => $pathFoto
        ]);

        $admins = User::role(['Superadmin', 'Koordinator Mess'])->get();
        Notification::send($admins, new KebersihanKamarNotification($kamar, 'bersih'));

        session()->flash('success', 'Kamar berhasil ditandai bersih!');
        $this->tutupModalSelesai();
    }

    public function render()
    {
        $kamars = Kamar::where('status', 'kosong_kotor')
            ->orderBy('nomor_kamar', 'asc')
            ->get();

        return view('livewire.admin.kebersihan.index', [
            'kamars' => $kamars
        ]);
    }
}
