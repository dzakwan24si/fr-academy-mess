<?php

namespace App\Livewire\Admin\Aset;

use App\Models\Kamar;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

#[Layout('layouts.admin')]
#[Title('LAPORAN DISTRIBUSI ASET')]
class Laporan extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';
    public $filterKamar = '';
    public $filterKondisi = '';

    public $isModalRiwayatOpen = false;
    public $detailRiwayat = [];

    public function bukaModalRiwayat($pivot_id)
    {
        $pivotRow = \Illuminate\Support\Facades\DB::table('aset_kamar')
            ->join('aset_messes', 'aset_kamar.aset_mess_id', '=', 'aset_messes.id')
            ->join('kamars', 'aset_kamar.kamar_id', '=', 'kamars.id')
            ->select('aset_messes.nama_aset', 'kamars.nomor_kamar', 'aset_kamar.catatan_perbaikan', 'aset_kamar.foto_perbaikan', 'aset_kamar.tanggal_maintenance')
            ->where('aset_kamar.id', $pivot_id)
            ->first();

        if ($pivotRow) {
            $this->detailRiwayat = [
                'nama_aset' => $pivotRow->nama_aset,
                'nomor_kamar' => $pivotRow->nomor_kamar,
                'teknisi' => 'Teknisi Internal', // Since we don't have teknisi_id on aset_kamar
                'tanggal_maintenance' => $pivotRow->tanggal_maintenance,
                'catatan_perbaikan' => $pivotRow->catatan_perbaikan,
                'foto_perbaikan' => $pivotRow->foto_perbaikan,
            ];
            $this->isModalRiwayatOpen = true;
        }
    }

    public function tutupModalRiwayat()
    {
        $this->isModalRiwayatOpen = false;
        $this->detailRiwayat = [];
    }

    public function render()
    {
        // Ambil data kamar beserta relasi asetnya
        $query = Kamar::whereHas('asets');

        if (!empty($this->filterKamar)) {
            $query->where('id', $this->filterKamar);
        }

        // Ambil data (Eager Load) dengan filter kondisi pada Pivot jika ada
        $kamars = $query->with(['asets' => function ($q) {
            if (!empty($this->search)) {
                $q->where('nama_aset', 'like', '%' . $this->search . '%');
            }
            if (!empty($this->filterKondisi)) {
                $q->wherePivot('kondisi', $this->filterKondisi);
            }
        }])->get();

        // Format data untuk view
        $laporanData = collect();

        foreach ($kamars as $kamar) {
            foreach ($kamar->asets as $aset) {
                $laporanData->push([
                    'pivot_id' => $aset->pivot->id,
                    'kamar_nama' => $kamar->nomor_kamar,
                    'kamar_lokasi' => $kamar->lokasi,
                    'kamar_tipe' => $kamar->tipe_kamar,
                    'aset_nama' => $aset->nama_aset,
                    'aset_kategori' => $aset->kategori,
                    'jumlah' => $aset->pivot->jumlah,
                    'kondisi' => $aset->pivot->kondisi,
                    'keterangan' => $aset->pivot->keterangan,
                    'tanggal_maintenance' => $aset->pivot->tanggal_maintenance,
                    'catatan_perbaikan' => $aset->pivot->catatan_perbaikan,
                    'foto_perbaikan' => $aset->pivot->foto_perbaikan,
                    'hilang' => $aset->pivot->kondisi === 'Hilang',
                ]);
            }
        }

        // Sorting manual karena collection flatten
        $laporanData = $laporanData->sortBy('kamar_nama');

        $page = $this->getPage();
        $offset = ($page - 1) * $this->perPage;
        
        $paginator = new LengthAwarePaginator(
            $laporanData->slice($offset, $this->perPage)->values(),
            $laporanData->count(),
            $this->perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'pageName' => 'page']
        );

        $semuaKamar = Kamar::orderBy('nomor_kamar')->get();

        return view('livewire.admin.aset.laporan', [
            'laporanData' => $paginator,
            'semuaKamar' => $semuaKamar
        ]);
    }

    public function exportData()
    {
        // TODO: Implementasi export sungguhan pakai Maatwebsite/Excel
        // Saat ini hanya alert/notification UI
        $this->js("alert('Fitur Export Excel/PDF akan segera tersedia!');");
    }
}
