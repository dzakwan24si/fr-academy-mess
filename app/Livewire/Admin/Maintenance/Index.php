<?php

namespace App\Livewire\Admin\Maintenance;

use App\Models\AsetMess;
use App\Models\Kamar;
use App\Models\KomplainKerusakan;
use App\Models\RiwayatAktivitas;
use App\Models\User;
use App\Notifications\KomplainSelesaiNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Tugas Perbaikan')]
class Index extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $isModalSelesaiOpen = false;

    public $tugasIdAktif = null;

    public $tugasTipeAktif = null;

    public $tugasKamarIdAktif = null;

    public $catatanTeknisi = '';

    public $fotoBukti;

    public function bukaModalSelesai($id, $tipe, $kamar_id = null)
    {
        $this->resetValidation();
        $this->tugasIdAktif = $id;
        $this->tugasTipeAktif = $tipe;
        $this->tugasKamarIdAktif = $kamar_id;
        $this->catatanTeknisi = '';
        $this->fotoBukti = null;
        $this->isModalSelesaiOpen = true;
    }

    public function tutupModalSelesai()
    {
        $this->isModalSelesaiOpen = false;
        $this->tugasIdAktif = null;
        $this->tugasTipeAktif = null;
        $this->tugasKamarIdAktif = null;
    }

    public function simpanPenyelesaian()
    {
        $this->validate([
            'catatanTeknisi' => 'required|string|min:5|max:500',
            'fotoBukti' => 'required|image|max:2048',
        ], [
            'catatanTeknisi.required' => 'Catatan tindakan perbaikan wajib diisi.',
            'catatanTeknisi.min' => 'Catatan tindakan perbaikan minimal 5 karakter.',
            'catatanTeknisi.max' => 'Catatan tindakan perbaikan maksimal 500 karakter.',
            'fotoBukti.required' => 'Foto bukti perbaikan wajib diunggah.',
            'fotoBukti.image' => 'Berkas bukti harus berupa gambar.',
            'fotoBukti.max' => 'Ukuran foto bukti maksimal 2MB.',
        ]);

        $pathFoto = null;
        if ($this->fotoBukti) {
            $pathFoto = $this->fotoBukti->store('bukti_perbaikan', 'public');
        }

        if ($this->tugasTipeAktif === 'komplain') {
            $komplain = KomplainKerusakan::find($this->tugasIdAktif);
            if ($komplain) {
                $komplain->update([
                    'status_perbaikan' => 'selesai',
                    'catatan_teknisi' => $this->catatanTeknisi,
                    'foto_perbaikan' => $pathFoto,
                ]);

                $admins = User::role(['Superadmin', 'Koordinator Mess'])->get();
                Notification::send($admins, new KomplainSelesaiNotification($komplain));

                if ($komplain->reservasi && $komplain->reservasi->kamar_id) {
                    RiwayatAktivitas::create([
                        'trackable_type' => Kamar::class,
                        'trackable_id' => $komplain->reservasi->kamar_id,
                        'user_id' => Auth::id(),
                        'aksi' => 'Perbaikan Komplain Selesai',
                        'keterangan' => 'Komplain ('.$komplain->judul_komplain.') telah diselesaikan. Catatan teknisi: '.$this->catatanTeknisi,
                    ]);
                }

                if ($komplain->reservasi && $komplain->reservasi->tamu) {
                    $komplain->reservasi->tamu->notify(new KomplainSelesaiNotification($komplain));
                }

                session()->flash('success', 'Komplain tamu berhasil diselesaikan dengan bukti perbaikan!');
            }
        } elseif ($this->tugasTipeAktif === 'aset') {
            if ($this->tugasIdAktif && $this->tugasKamarIdAktif) {
                DB::table('aset_kamar')
                    ->where('aset_mess_id', $this->tugasIdAktif)
                    ->where('kamar_id', $this->tugasKamarIdAktif)
                    ->update([
                        'kondisi' => 'Baik',
                        'tanggal_maintenance' => now(),
                        'catatan_perbaikan' => $this->catatanTeknisi,
                        'foto_perbaikan' => $pathFoto,
                    ]);

                $kamar = Kamar::find($this->tugasKamarIdAktif);

                RiwayatAktivitas::create([
                    'trackable_type' => AsetMess::class,
                    'trackable_id' => $this->tugasIdAktif,
                    'user_id' => Auth::id(),
                    'aksi' => 'Perbaikan Aset Selesai',
                    'keterangan' => 'Kondisi aset di '.($kamar ? $kamar->nomor_kamar : 'kamar').' telah diperbaiki menjadi Baik. Catatan: '.$this->catatanTeknisi,
                ]);

                session()->flash('success', 'Status aset berhasil dikembalikan menjadi Baik dengan bukti perbaikan!');
            }
        }

        $this->tutupModalSelesai();
    }

    public function render()
    {
        // 1. Get Komplain (Urgent) with pagination
        $komplains = KomplainKerusakan::with(['reservasi.kamar', 'reservasi.tamu'])
            ->whereIn('status_perbaikan', ['dilaporkan', 'diproses'])
            ->orderBy('created_at', 'asc')
            ->paginate(6, ['*'], 'komplainPage');

        // 2. Get Aset Rusak (Routine) with pagination
        // Kita join manual atau pakai eloquent untuk pivot
        $asetRusak = DB::table('aset_kamar')
            ->join('aset_messes', 'aset_kamar.aset_mess_id', '=', 'aset_messes.id')
            ->join('kamars', 'aset_kamar.kamar_id', '=', 'kamars.id')
            ->whereIn('aset_kamar.kondisi', ['Rusak Ringan', 'Rusak Berat'])
            ->select(
                'aset_messes.id as aset_id',
                'aset_messes.nama_aset',
                'kamars.id as kamar_id',
                'kamars.nomor_kamar',
                'aset_kamar.kondisi',
                'aset_kamar.keterangan',
                'aset_kamar.updated_at'
            )
            ->orderBy('aset_kamar.updated_at', 'asc')
            ->paginate(6, ['*'], 'asetPage');

        return view('livewire.admin.maintenance.index', [
            'komplains' => $komplains,
            'asetRusak' => $asetRusak,
        ]);
    }
}
