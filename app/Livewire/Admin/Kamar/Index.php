<?php

namespace App\Livewire\Admin\Kamar;

use App\Models\Kamar;
use App\Models\User;
use App\Notifications\KebersihanKamarNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('MANAJEMEN KAMAR')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';
    public $filterStatus = '';

    // Riwayat Modal
    public $isModalRiwayatOpen = false;
    public $riwayatList = [];
    public $riwayatKamarTitle = '';

    // Form Modal
    public $isModalOpen = false;
    public $isEdit = false;
    public $kamar_id = null;

    // Fields
    public $nomor_kamar;
    public $lokasi;
    public $tipe_kamar = 'Reguler Twin Bed';
    public $kapasitas = 2;
    public $status = 'kosong_bersih';

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function bukaModal($id = null)
    {
        $this->resetValidation();
        if ($id) {
            $kamar = Kamar::findOrFail($id);
            $this->kamar_id = $kamar->id;
            $this->nomor_kamar = $kamar->nomor_kamar;
            $this->lokasi = $kamar->lokasi;
            $this->tipe_kamar = $kamar->tipe_kamar;
            $this->kapasitas = $kamar->kapasitas;
            $this->status = $kamar->status;
            $this->isEdit = true;
        } else {
            $this->isEdit = false;
            $this->kamar_id = null;
            $this->reset(['nomor_kamar', 'lokasi', 'tipe_kamar', 'kapasitas', 'status']);
            $this->tipe_kamar = 'Reguler Twin Bed';
            $this->kapasitas = 2;
            $this->status = 'kosong_bersih';
        }
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
    }

    public function simpan()
    {
        $this->validate([
            'nomor_kamar' => 'required|string|max:50|unique:kamars,nomor_kamar,' . $this->kamar_id,
            'lokasi' => 'nullable|string|max:255',
            'tipe_kamar' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:kosong_bersih,kosong_kotor,terisi,maintenance',
        ]);

        $isNewOrUpdated = false;
        $kamar = Kamar::find($this->kamar_id);
        $oldStatus = $kamar ? $kamar->status : null;

        $kamar = Kamar::updateOrCreate(
            ['id' => $this->kamar_id],
            [
                'nomor_kamar' => $this->nomor_kamar,
                'lokasi' => $this->lokasi,
                'tipe_kamar' => $this->tipe_kamar,
                'kapasitas' => $this->kapasitas,
                'status' => $this->status,
            ]
        );

        if ($oldStatus != 'kosong_bersih' && $this->status == 'kosong_bersih') {
            $admins = User::role(['Superadmin', 'Koordinator Mess'])->get();
            Notification::send($admins, new KebersihanKamarNotification($kamar, 'bersih'));
        }

        if ($oldStatus !== $this->status) {
            $aksi = 'Status Kamar Diubah';
            if ($this->status == 'kosong_bersih') $aksi = 'Kamar Dibersihkan';
            elseif ($this->status == 'maintenance') $aksi = 'Kamar Dalam Perbaikan';
            elseif ($this->status == 'terisi') $aksi = 'Kamar Ditempati';
            elseif ($this->status == 'kosong_kotor') $aksi = 'Kamar Kotor';

            \App\Models\RiwayatAktivitas::create([
                'trackable_type' => \App\Models\Kamar::class,
                'trackable_id' => $kamar->id,
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'aksi' => $aksi,
                'keterangan' => 'Status kamar diubah menjadi ' . ucwords(str_replace('_', ' ', $this->status)),
            ]);
        }

        $this->tutupModal();
    }

    public function hapus($id)
    {
        Kamar::findOrFail($id)->delete();
    }

    public function bukaModalRiwayat($id)
    {
        $kamar = Kamar::with(['riwayatAktivitas' => function($q) {
            $q->latest();
        }, 'riwayatAktivitas.user'])->findOrFail($id);
        $this->riwayatList = $kamar->riwayatAktivitas;
        $this->riwayatKamarTitle = $kamar->nomor_kamar;
        $this->isModalRiwayatOpen = true;
    }

    public function tutupModalRiwayat()
    {
        $this->isModalRiwayatOpen = false;
        $this->riwayatList = [];
    }

    public function render()
    {
        $query = Kamar::orderByRaw("CASE WHEN tipe_kamar = 'Fasilitas Umum' THEN 1 ELSE 0 END")
                      ->orderBy('nomor_kamar', 'asc');

        if (!empty($this->search)) {
            $query->where('nomor_kamar', 'like', '%' . $this->search . '%')
                  ->orWhere('tipe_kamar', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.admin.kamar.index', [
            'kamars' => $query->paginate($this->perPage)
        ]);
    }
}
