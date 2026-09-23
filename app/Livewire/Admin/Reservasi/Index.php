<?php

namespace App\Livewire\Admin\Reservasi;

use App\Models\Reservasi;
use App\Models\Kamar;
use App\Models\User;
use App\Models\Tamu;
use App\Notifications\StatusReservasiNotification;
use App\Notifications\KebersihanKamarNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('MANAJEMEN RESERVASI')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';
    public $filterStatus = '';
    public $filterKategori = '';
    public $filterTanggal = '';
    
    public $isModalTolakOpen = false;
    public $alasanTolak = '';
    public $selectedReservasiId = null;

    // Detail Modal
    public $isModalDetailOpen = false;
    public $detailReservasi = null;


    // Form Walk-in Reservation
    public $isModalBuatOpen = false;
    public $form_nama = '';
    public $form_no_hp = '';
    public $form_perusahaan = '';
    public $form_jabatan = '';
    public $form_kategori = 'tamu_umum';
    public $form_tgl_checkin = '';
    public $form_jam_checkin = '';
    public $form_tgl_checkout = '';
    public $form_kamar_id = '';
    public $form_keperluan = '';

    // Off Sementara Modal
    public $isModalOffOpen = false;
    public $selectedOffReservasiId = null;
    public $tanggalKembali = '';
    public $tanggalCheckoutBaru = '';

    // Edit Modal
    public $isModalEditOpen = false;
    public $edit_reservasi_id = null;
    public $edit_tamu_id = null;
    public $edit_nama = '';
    public $edit_no_hp = '';
    public $edit_perusahaan = '';
    public $edit_jabatan = '';
    public $edit_kategori = '';
    public $edit_tgl_checkin = '';
    public $edit_jam_checkin = '';
    public $edit_tgl_checkout = '';
    public $edit_kamar_id = '';
    public $edit_keperluan = '';

    // Delete Modal
    public $isModalHapusOpen = false;
    public $delete_reservasi_id = null;

    protected $queryString = ['search', 'filterStatus', 'filterKategori', 'filterTanggal'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function setujuiBooking($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status' => 'approved']);

        if ($reservasi->tamu) {
            $reservasi->tamu->notify(new StatusReservasiNotification($reservasi));
        }
    }

    public function bukaModalTolak($id)
    {
        $this->selectedReservasiId = $id;
        $this->alasanTolak = '';
        $this->isModalTolakOpen = true;
    }
    
    public function tutupModalTolak()
    {
        $this->isModalTolakOpen = false;
        $this->selectedReservasiId = null;
        $this->alasanTolak = '';
    }

    public function bukaModalDetail($id)
    {
        $this->detailReservasi = Reservasi::with(['tamu', 'kamar'])->findOrFail($id);
        $this->isModalDetailOpen = true;
    }

    public function tutupModalDetail()
    {
        $this->isModalDetailOpen = false;
        $this->detailReservasi = null;
    }


    public function tolakBooking()
    {
        $this->validate([
            'alasanTolak' => 'required|string|min:5'
        ]);

        $reservasi = Reservasi::findOrFail($this->selectedReservasiId);
        $reservasi->update([
            'status' => 'rejected',
            'alasan_penolakan' => $this->alasanTolak
        ]);

        if ($reservasi->tamu) {
            $reservasi->tamu->notify(new StatusReservasiNotification($reservasi));
        }

        $this->tutupModalTolak();
    }

    public function bukaModalBuat()
    {
        $this->reset([
            'form_nama', 'form_no_hp', 'form_perusahaan', 'form_jabatan', 'form_kategori',
            'form_tgl_checkin', 'form_jam_checkin', 'form_tgl_checkout', 'form_kamar_id', 'form_keperluan'
        ]);
        $this->form_tgl_checkin = \Carbon\Carbon::today()->format('Y-m-d');
        $this->isModalBuatOpen = true;
    }

    public function tutupModalBuat()
    {
        $this->isModalBuatOpen = false;
    }

    public function simpanWalkIn()
    {
        $this->validate([
            'form_nama' => 'required|string|max:255',
            'form_no_hp' => 'required|string|max:20',
            'form_perusahaan' => 'required|string|max:255',
            'form_jabatan' => 'required|string|max:255',
            'form_kategori' => 'required|in:tamu_umum,trainee',
            'form_tgl_checkin' => 'required|date',
            'form_jam_checkin' => 'required',
            'form_tgl_checkout' => 'required|date|after_or_equal:form_tgl_checkin',
            'form_keperluan' => 'required|string',
            'form_kamar_id' => 'nullable|exists:kamars,id'
        ]);

        // Cari Tamu berdasarkan No HP, atau buat baru
        $tamu = \App\Models\Tamu::firstOrCreate(
            ['no_hp' => $this->form_no_hp],
            [
                'nama' => $this->form_nama,
                'perusahaan' => $this->form_perusahaan,
                'jabatan' => $this->form_jabatan,
                'kategori' => $this->form_kategori
            ]
        );

        // Buat Reservasi dengan status 'approved'
        Reservasi::create([
            'tamu_id' => $tamu->id,
            'kamar_id' => $this->form_kamar_id ?: null,
            'tanggal_checkin' => $this->form_tgl_checkin,
            'perkiraan_jam_checkin' => $this->form_jam_checkin ?: null,
            'tanggal_checkout' => $this->form_tgl_checkout,
            'keperluan_menginap' => $this->form_keperluan,
            'status' => 'approved'
        ]);

        $this->tutupModalBuat();
    }

    public function bukaModalEdit($id)
    {
        $reservasi = Reservasi::with('tamu')->findOrFail($id);
        
        $this->edit_reservasi_id = $reservasi->id;
        $this->edit_tamu_id = $reservasi->tamu_id;
        
        if ($reservasi->tamu) {
            $this->edit_nama = $reservasi->tamu->nama;
            $this->edit_no_hp = $reservasi->tamu->no_hp;
            $this->edit_perusahaan = $reservasi->tamu->perusahaan;
            $this->edit_jabatan = $reservasi->tamu->jabatan;
            $this->edit_kategori = $reservasi->tamu->kategori;
        }

        $this->edit_tgl_checkin = $reservasi->tanggal_checkin;
        $this->edit_jam_checkin = $reservasi->perkiraan_jam_checkin;
        $this->edit_tgl_checkout = $reservasi->tanggal_checkout;
        $this->edit_kamar_id = $reservasi->kamar_id;
        $this->edit_keperluan = $reservasi->keperluan_menginap;

        $this->isModalEditOpen = true;
    }

    public function tutupModalEdit()
    {
        $this->isModalEditOpen = false;
        $this->reset([
            'edit_reservasi_id', 'edit_tamu_id', 'edit_nama', 'edit_no_hp',
            'edit_perusahaan', 'edit_jabatan', 'edit_kategori', 'edit_tgl_checkin',
            'edit_jam_checkin', 'edit_tgl_checkout', 'edit_kamar_id', 'edit_keperluan'
        ]);
    }

    public function simpanEdit()
    {
        $this->validate([
            'edit_nama' => 'required|string|max:255',
            'edit_no_hp' => 'required|string|max:20',
            'edit_perusahaan' => 'required|string|max:255',
            'edit_jabatan' => 'required|string|max:255',
            'edit_kategori' => 'required|in:tamu_umum,trainee',
            'edit_tgl_checkin' => 'required|date',
            'edit_tgl_checkout' => 'required|date|after_or_equal:edit_tgl_checkin',
            'edit_keperluan' => 'required|string',
            'edit_kamar_id' => 'nullable|exists:kamars,id'
        ]);

        $reservasi = Reservasi::findOrFail($this->edit_reservasi_id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($reservasi) {
            // Check jika pindah kamar
            $oldKamarId = $reservasi->kamar_id;
            
            // Update Data Reservasi
            $reservasi->update([
                'kamar_id' => $this->edit_kamar_id ?: null,
                'tanggal_checkin' => $this->edit_tgl_checkin,
                'perkiraan_jam_checkin' => $this->edit_jam_checkin ?: null,
                'tanggal_checkout' => $this->edit_tgl_checkout,
                'keperluan_menginap' => $this->edit_keperluan,
            ]);

            // Update Data Tamu
            if ($reservasi->tamu) {
                // Pastikan no hp tidak bentrok dengan tamu lain
                $existingTamu = \App\Models\Tamu::where('no_hp', $this->edit_no_hp)
                    ->where('id', '!=', $reservasi->tamu_id)
                    ->first();
                    
                $reservasi->tamu->update([
                    'nama' => $this->edit_nama,
                    'no_hp' => $existingTamu ? $this->edit_no_hp . '-1' : $this->edit_no_hp,
                    'perusahaan' => $this->edit_perusahaan,
                    'jabatan' => $this->edit_jabatan,
                    'kategori' => $this->edit_kategori
                ]);
            }

            // Update status kamar lama jika ditinggalkan dan kosong
            if ($oldKamarId && $oldKamarId != $this->edit_kamar_id) {
                $oldKamar = \App\Models\Kamar::find($oldKamarId);
                if ($oldKamar) {
                    $activeGuests = Reservasi::where('kamar_id', $oldKamarId)
                        ->whereIn('status', ['approved', 'checked_in'])
                        ->count();
                    if ($activeGuests == 0) {
                        $oldKamar->update(['status' => 'kosong_kotor']); // atau kosong bersih tergantung logic, default kosong kotor
                    }
                }
            }

            // Update status kamar baru jika terisi
            if ($this->edit_kamar_id) {
                $newKamar = \App\Models\Kamar::find($this->edit_kamar_id);
                if ($newKamar && $reservasi->status == 'checked_in' && $newKamar->status != 'terisi') {
                    $newKamar->update(['status' => 'terisi']);
                }
            }
        });

        $this->tutupModalEdit();
    }

    public function konfirmasiHapus($id)
    {
        $this->delete_reservasi_id = $id;
        $this->isModalHapusOpen = true;
    }

    public function tutupModalHapus()
    {
        $this->isModalHapusOpen = false;
        $this->delete_reservasi_id = null;
    }

    public function hapusReservasi()
    {
        $reservasi = Reservasi::findOrFail($this->delete_reservasi_id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($reservasi) {
            $kamarId = $reservasi->kamar_id;
            
            $reservasi->forceDelete();
            
            // Cek apakah kamar menjadi kosong setelah dihapus
            if ($kamarId) {
                $kamar = \App\Models\Kamar::find($kamarId);
                if ($kamar) {
                    $activeGuests = Reservasi::where('kamar_id', $kamarId)
                        ->whereIn('status', ['approved', 'checked_in'])
                        ->count();
                    if ($activeGuests == 0 && $kamar->status == 'terisi') {
                        $kamar->update(['status' => 'kosong_bersih']); 
                    }
                }
            }
        });

        $this->tutupModalHapus();
    }

    public function prosesCheckIn($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($reservasi) {
            $reservasi->update(['status' => 'checked_in']);
            
            if ($reservasi->kamar) {
                $reservasi->kamar->update(['status' => 'terisi']);
            }
        });
    }

    public function prosesCheckOut($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($reservasi) {
            $reservasi->update(['status' => 'completed']);
            
            if ($reservasi->kamar) {
                // Check remaining active guests in the room
                $activeGuests = Reservasi::where('kamar_id', $reservasi->kamar_id)
                    ->whereIn('status', ['approved', 'checked_in'])
                    ->count();

                if ($activeGuests == 0) {
                    $reservasi->kamar->update(['status' => 'kosong_kotor']);

                    // Notify about dirty room
                    $admins = User::role(['Superadmin', 'Koordinator Mess', 'Staf Kebersihan'])->get();
                    if ($admins->count() > 0) {
                        Notification::send($admins, new KebersihanKamarNotification($reservasi->kamar, 'kotor'));
                    }
                } else {
                    // Notify about partial dirty room
                    $admins = User::role(['Superadmin', 'Koordinator Mess', 'Staf Kebersihan'])->get();
                    if ($admins->count() > 0) {
                        Notification::send($admins, new KebersihanKamarNotification($reservasi->kamar, 'kotor_sebagian'));
                    }
                }
            }
        });
    }

    public function bukaModalOff($id)
    {
        $this->selectedOffReservasiId = $id;
        $reservasi = Reservasi::findOrFail($id);
        $this->tanggalKembali = \Carbon\Carbon::today()->addDays(1)->format('Y-m-d');
        
        // Default tanggal checkout baru adalah tanggal checkout lama
        // Kecuali jika tanggal checkout lama ternyata lebih awal dari tanggal kembali,
        // maka atur defaultnya ke tanggal kembali + 1 hari.
        if (\Carbon\Carbon::parse($reservasi->tanggal_checkout)->isBefore($this->tanggalKembali)) {
            $this->tanggalCheckoutBaru = \Carbon\Carbon::parse($this->tanggalKembali)->addDays(1)->format('Y-m-d');
        } else {
            $this->tanggalCheckoutBaru = $reservasi->tanggal_checkout;
        }

        $this->isModalOffOpen = true;
    }

    public function updatedTanggalKembali($value)
    {
        if ($this->selectedOffReservasiId) {
            $reservasi = Reservasi::find($this->selectedOffReservasiId);
            if ($reservasi) {
                if (\Carbon\Carbon::parse($reservasi->tanggal_checkout)->isBefore($value)) {
                    $this->tanggalCheckoutBaru = \Carbon\Carbon::parse($value)->addDays(1)->format('Y-m-d');
                } else {
                    $this->tanggalCheckoutBaru = $reservasi->tanggal_checkout;
                }
            }
        }
    }

    public function tutupModalOff()
    {
        $this->isModalOffOpen = false;
        $this->selectedOffReservasiId = null;
        $this->tanggalKembali = '';
        $this->tanggalCheckoutBaru = '';
    }

    public function simpanOffSementara()
    {
        $this->validate([
            'tanggalKembali' => 'required|date|after_or_equal:today',
            'tanggalCheckoutBaru' => 'required|date|after_or_equal:tanggalKembali'
        ]);

        $reservasi = Reservasi::findOrFail($this->selectedOffReservasiId);

        \Illuminate\Support\Facades\DB::transaction(function () use ($reservasi) {
            // Selesaikan reservasi yang sekarang
            $reservasi->update(['status' => 'completed', 'tanggal_checkout' => \Carbon\Carbon::today()->format('Y-m-d')]);

            if ($reservasi->kamar) {
                // Check remaining active guests in the room
                $activeGuests = Reservasi::where('kamar_id', $reservasi->kamar_id)
                    ->whereIn('status', ['approved', 'checked_in'])
                    ->count();

                if ($activeGuests == 0) {
                    $reservasi->kamar->update(['status' => 'kosong_kotor']);
                    // Beri notifikasi ke petugas kebersihan
                    $admins = User::role(['Superadmin', 'Koordinator Mess', 'Staf Kebersihan'])->get();
                    if ($admins->count() > 0) {
                        Notification::send($admins, new KebersihanKamarNotification($reservasi->kamar, 'kotor'));
                    }
                } else {
                    // Notify about partial dirty room
                    $admins = User::role(['Superadmin', 'Koordinator Mess', 'Staf Kebersihan'])->get();
                    if ($admins->count() > 0) {
                        Notification::send($admins, new KebersihanKamarNotification($reservasi->kamar, 'kotor_sebagian'));
                    }
                }
            }

            // Buat reservasi baru untuk kembalinya trainee
            Reservasi::create([
                'tamu_id' => $reservasi->tamu_id,
                'kamar_id' => $reservasi->kamar_id,
                'tanggal_checkin' => $this->tanggalKembali,
                'perkiraan_jam_checkin' => $reservasi->perkiraan_jam_checkin,
                'tanggal_checkout' => $this->tanggalCheckoutBaru,
                'keperluan_menginap' => $reservasi->keperluan_menginap,
                'status' => 'approved'
            ]);
        });

        $this->tutupModalOff();
    }

    public function render()
    {
        $query = Reservasi::with(['tamu', 'kamar'])
            ->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->whereHas('tamu', function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        if (!empty($this->filterKategori)) {
            $query->whereHas('tamu', function ($q) {
                $q->where('kategori', $this->filterKategori);
            });
        }

        if (!empty($this->filterTanggal)) {
            $query->whereDate('tanggal_checkin', $this->filterTanggal);
        }

        $availableRooms = Kamar::whereIn('status', ['kosong_bersih', 'terisi'])
            ->where('tipe_kamar', '!=', 'Fasilitas Umum')
            ->where('nomor_kamar', 'not like', 'Lorong%')
            ->withCount(['reservasis as active_guests_count' => function ($query) {
                $query->whereIn('status', ['approved', 'checked_in']);
            }])
            ->get()
            ->filter(function ($kamar) {
                return $kamar->active_guests_count < $kamar->kapasitas;
            });

        return view('livewire.admin.reservasi.index', [
            'reservasis' => $query->paginate($this->perPage),
            'availableRooms' => $availableRooms
        ]);
    }
}
