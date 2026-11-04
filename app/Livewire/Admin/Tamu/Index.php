<?php

namespace App\Livewire\Admin\Tamu;

use App\Models\Tamu;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('DATA TAMU')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $filterKategori = 'all';

    public $filterStatus = 'all';

    // State Modal Edit / Tambah
    public $isModalOpen = false;

    public $isEdit = false;

    public $tamuId = null;

    public $nama = '';

    public $perusahaan = '';

    public $jabatan = '';

    public $no_hp = '';

    public $kategori = 'tamu_umum';

    // State Modal Riwayat
    public $isRiwayatModalOpen = false;

    public $selectedTamu = null;

    public $riwayatReservasis = [];

    // State Modal Konfirmasi Hapus
    public $isDeleteModalOpen = false;

    public $tamuToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterKategori()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function bukaModalTambah()
    {
        $this->reset(['tamuId', 'nama', 'perusahaan', 'jabatan', 'no_hp']);
        $this->kategori = 'tamu_umum';
        $this->isEdit = false;
        $this->isModalOpen = true;
    }

    public function bukaModalEdit($id)
    {
        $tamu = Tamu::find($id);
        if (! $tamu) {
            session()->flash('error', 'Data tamu tidak ditemukan.');

            return;
        }

        $this->tamuId = $tamu->id;
        $this->nama = $tamu->nama;
        $this->perusahaan = $tamu->perusahaan;
        $this->jabatan = $tamu->jabatan;
        $this->no_hp = $tamu->no_hp;
        $this->kategori = $tamu->kategori ?? 'tamu_umum';

        $this->isEdit = true;
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
        $this->reset(['tamuId', 'nama', 'perusahaan', 'jabatan', 'no_hp']);
    }

    public function simpan()
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'perusahaan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'kategori' => 'required|in:tamu_umum,trainee',
            'no_hp' => [
                'required',
                'numeric',
                'min_digits:10',
                $this->isEdit
                    ? 'unique:tamus,no_hp,'.$this->tamuId
                    : 'unique:tamus,no_hp',
            ],
        ];

        $this->validate($rules);

        if ($this->isEdit) {
            $tamu = Tamu::find($this->tamuId);
            if ($tamu) {
                $tamu->update([
                    'nama' => $this->nama,
                    'perusahaan' => $this->perusahaan,
                    'jabatan' => $this->jabatan,
                    'kategori' => $this->kategori,
                    'no_hp' => $this->no_hp,
                ]);
                session()->flash('success', 'Data tamu berhasil diperbarui.');
            }
        } else {
            Tamu::create([
                'nama' => $this->nama,
                'perusahaan' => $this->perusahaan,
                'jabatan' => $this->jabatan,
                'kategori' => $this->kategori,
                'no_hp' => $this->no_hp,
            ]);
            session()->flash('success', 'Tamu baru berhasil didaftarkan.');
        }

        $this->tutupModal();
    }

    public function bukaModalRiwayat($id)
    {
        $tamu = Tamu::with(['reservasis' => function ($q) {
            $q->with('kamar')->orderBy('tanggal_checkin', 'desc');
        }])->find($id);

        if (! $tamu) {
            session()->flash('error', 'Data tamu tidak ditemukan.');

            return;
        }

        $this->selectedTamu = $tamu;
        $this->riwayatReservasis = $tamu->reservasis;
        $this->isRiwayatModalOpen = true;
    }

    public function tutupModalRiwayat()
    {
        $this->isRiwayatModalOpen = false;
        $this->selectedTamu = null;
        $this->riwayatReservasis = [];
    }

    public function konfirmasiHapus($id)
    {
        $tamu = Tamu::withCount('reservasis')->find($id);
        if (! $tamu) {
            session()->flash('error', 'Data tamu tidak ditemukan.');

            return;
        }

        $this->tamuToDelete = $tamu;
        $this->isDeleteModalOpen = true;
    }

    public function tutupModalHapus()
    {
        $this->isDeleteModalOpen = false;
        $this->tamuToDelete = null;
    }

    public function hapusTamu()
    {
        if (! $this->tamuToDelete) {
            return;
        }

        $tamu = Tamu::find($this->tamuToDelete->id);
        if ($tamu) {
            // Modifikasi nomor HP agar dibebaskan jika nomor tersebut ingin didaftarkan ulang
            $oldPhone = $tamu->no_hp;
            $tamu->no_hp = $oldPhone.'_del_'.time();
            $tamu->save();
            $tamu->delete();

            session()->flash('success', "Akun tamu {$tamu->nama} ({$oldPhone}) berhasil dihapus dan nomor HP telah dibebaskan.");
        }

        $this->tutupModalHapus();
    }

    public function render()
    {
        // 1. Ringkasan Statistik
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        $totalTamu = Tamu::count();
        $totalTrainee = Tamu::where('kategori', 'trainee')->count();
        $totalUmum = Tamu::where('kategori', '!=', 'trainee')->orWhereNull('kategori')->count();

        $tamuAktifCount = Tamu::whereHas('reservasis', function ($q) use ($sixMonthsAgo) {
            $q->where('tanggal_checkin', '>=', $sixMonthsAgo->toDateString())
                ->orWhereIn('status', ['checked_in', 'approved']);
        })->count();

        $tamuInaktifCount = $totalTamu - $tamuAktifCount;

        // 2. Query Tamu
        $query = Tamu::with(['latestReservasi.kamar'])
            ->withCount('reservasis');

        // Filter Pencarian
        if (! empty($this->search)) {
            $searchTerm = '%'.trim($this->search).'%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', $searchTerm)
                    ->orWhere('no_hp', 'like', $searchTerm)
                    ->orWhere('perusahaan', 'like', $searchTerm)
                    ->orWhere('jabatan', 'like', $searchTerm);
            });
        }

        // Filter Kategori
        if ($this->filterKategori === 'trainee') {
            $query->where('kategori', 'trainee');
        } elseif ($this->filterKategori === 'tamu_umum') {
            $query->where(function ($q) {
                $q->where('kategori', 'tamu_umum')->orWhereNull('kategori');
            });
        }

        // Filter Status Keaktifan
        if ($this->filterStatus === 'active') {
            $query->whereHas('reservasis', function ($q) use ($sixMonthsAgo) {
                $q->where('tanggal_checkin', '>=', $sixMonthsAgo->toDateString())
                    ->orWhereIn('status', ['checked_in', 'approved']);
            });
        } elseif ($this->filterStatus === 'inactive') {
            $query->whereDoesntHave('reservasis', function ($q) use ($sixMonthsAgo) {
                $q->where('tanggal_checkin', '>=', $sixMonthsAgo->toDateString())
                    ->orWhereIn('status', ['checked_in', 'approved']);
            })->whereHas('reservasis'); // pernah menginap tapi > 6 bulan lalu
        } elseif ($this->filterStatus === 'never') {
            $query->doesntHave('reservasis'); // belum pernah menginap sama sekali
        }

        $tamus = $query->orderBy('nama', 'asc')->paginate($this->perPage);

        return view('livewire.admin.tamu.index', [
            'tamus' => $tamus,
            'totalTamu' => $totalTamu,
            'totalTrainee' => $totalTrainee,
            'totalUmum' => $totalUmum,
            'tamuAktifCount' => $tamuAktifCount,
            'tamuInaktifCount' => $tamuInaktifCount,
        ]);
    }
}
