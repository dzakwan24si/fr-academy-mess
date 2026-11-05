<?php

namespace App\Livewire\Admin\Dapur;

use App\Models\BahanBaku;
use App\Models\Menu;
use App\Models\PemotonganStok;
use App\Models\RencanaMenuHarian;
use App\Models\RiwayatBelanjaDapur;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('DAPUR & MENU')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $activeTab = 'stok'; // stok, master, rencana

    // Filter & Search states
    public $searchStok = '';

    public $filterKategoriStok = '';

    public $searchMenu = '';

    public $filterKategoriMenu = '';

    public $filterWaktuMenu = '';

    public $searchRencana = '';

    public $filterStatusRencana = '';

    public $filterWaktuRencana = '';

    public $filterTanggalRencana = '';

    public function updatingSearchStok()
    {
        $this->resetPage('stokPage');
    }

    public function updatingFilterKategoriStok()
    {
        $this->resetPage('stokPage');
    }

    public function updatingSearchMenu()
    {
        $this->resetPage('menuPage');
    }

    public function updatingFilterKategoriMenu()
    {
        $this->resetPage('menuPage');
    }

    public function updatingFilterWaktuMenu()
    {
        $this->resetPage('menuPage');
    }

    public function updatingSearchRencana()
    {
        $this->resetPage('rencanaPage');
    }

    public function updatingFilterStatusRencana()
    {
        $this->resetPage('rencanaPage');
    }

    public function updatingFilterWaktuRencana()
    {
        $this->resetPage('rencanaPage');
    }

    public function updatingFilterTanggalRencana()
    {
        $this->resetPage('rencanaPage');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $queryStok = BahanBaku::query();
        if (! empty($this->searchStok)) {
            $queryStok->where('nama_bahan', 'like', '%'.$this->searchStok.'%');
        }
        if (! empty($this->filterKategoriStok)) {
            $queryStok->where('kategori_bahan', $this->filterKategoriStok);
        }
        $bahanBakus = $queryStok->latest()->paginate($this->perPage, ['*'], 'stokPage');

        $queryMenu = Menu::withCount('bahanBakus');
        if (! empty($this->searchMenu)) {
            $queryMenu->where('nama_menu', 'like', '%'.$this->searchMenu.'%');
        }
        if (! empty($this->filterKategoriMenu)) {
            $queryMenu->where('kategori', $this->filterKategoriMenu);
        }
        if (! empty($this->filterWaktuMenu)) {
            $queryMenu->where('waktu_penyajian', $this->filterWaktuMenu);
        }
        $menus = $queryMenu->latest()->paginate($this->perPage, ['*'], 'menuPage');

        $queryRencana = RencanaMenuHarian::with(['menu', 'feedbackMasakans']);
        if (! empty($this->searchRencana)) {
            $queryRencana->whereHas('menu', function ($q) {
                $q->where('nama_menu', 'like', '%'.$this->searchRencana.'%');
            });
        }
        if (! empty($this->filterStatusRencana)) {
            $queryRencana->where('status', $this->filterStatusRencana);
        }
        if (! empty($this->filterWaktuRencana)) {
            $queryRencana->where('waktu', $this->filterWaktuRencana);
        }
        if (! empty($this->filterTanggalRencana)) {
            $queryRencana->whereDate('tanggal', $this->filterTanggalRencana);
        }
        $rencanaHarians = $queryRencana->latest()->paginate($this->perPage, ['*'], 'rencanaPage');

        $allMenus = Menu::orderBy('nama_menu')->get();
        $allBahanBakus = BahanBaku::orderBy('nama_bahan')->get();

        return view('livewire.admin.dapur.index', compact('bahanBakus', 'menus', 'rencanaHarians', 'allMenus', 'allBahanBakus'));
    }

    public function formOpname() {}

    // --- State & Methods untuk Modal Bahan Baku ---
    public $isModalOpen = false;

    public $editBahanId = null;

    public $nama_bahan;

    public $stok_saat_ini;

    public $satuan;

    public $kategori_bahan = 'Kering';

    public $harga_satuan = 0;

    public $keterangan_volume;

    public function bukaModal()
    {
        $this->reset(['editBahanId', 'nama_bahan', 'stok_saat_ini', 'satuan', 'kategori_bahan', 'harga_satuan', 'keterangan_volume']);
        $this->kategori_bahan = 'Kering';
        $this->harga_satuan = 0;
        $this->isModalOpen = true;
    }

    public function editBahan($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $this->editBahanId = $bahan->id;
        $this->nama_bahan = $bahan->nama_bahan;
        $this->stok_saat_ini = $bahan->stok;
        $this->satuan = $bahan->satuan;
        $this->kategori_bahan = $bahan->kategori_bahan;
        $this->harga_satuan = $bahan->harga_satuan;
        $this->keterangan_volume = $bahan->keterangan_volume;

        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
    }

    public function simpanBahan()
    {
        $this->validate([
            'nama_bahan' => 'required|string|max:255',
            'stok_saat_ini' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'kategori_bahan' => 'required|in:Kering,Basah',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan_volume' => 'nullable|string|max:50',
        ]);

        $data = [
            'nama_bahan' => $this->nama_bahan,
            'stok' => $this->stok_saat_ini,
            'satuan' => $this->satuan,
            'kategori_bahan' => $this->kategori_bahan,
            'harga_satuan' => $this->harga_satuan,
            'keterangan_volume' => $this->keterangan_volume,
        ];

        if ($this->editBahanId) {
            BahanBaku::findOrFail($this->editBahanId)->update($data);
            session()->flash('success', 'Bahan baku berhasil diperbarui.');
        } else {
            BahanBaku::create($data);
            session()->flash('success', 'Bahan baku baru berhasil ditambahkan.');
        }

        $this->tutupModal();
    }

    public function hapusBahan($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $bahan->delete();
        session()->flash('success', 'Bahan baku berhasil dihapus.');
    }

    // --- State & Methods untuk Modal Menu ---
    public $isModalMenuOpen = false;

    public $editMenuId = null;

    public $nama_menu;

    public $deskripsi;

    public $kategori = 'Sarapan';

    public $waktu_penyajian = 'Universal';

    public $estimasi_harga_porsi = 0;

    public $is_active = true;

    public function bukaModalMenu()
    {
        $this->reset(['editMenuId', 'nama_menu', 'deskripsi', 'kategori', 'waktu_penyajian', 'estimasi_harga_porsi', 'is_active']);
        $this->kategori = 'Sarapan';
        $this->waktu_penyajian = 'Universal';
        $this->estimasi_harga_porsi = 0;
        $this->is_active = true;
        $this->isModalMenuOpen = true;
    }

    public function editMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $this->editMenuId = $menu->id;
        $this->nama_menu = $menu->nama_menu;
        $this->deskripsi = $menu->deskripsi;
        $this->kategori = $menu->kategori;
        $this->waktu_penyajian = $menu->waktu_penyajian;
        $this->estimasi_harga_porsi = $menu->estimasi_harga_porsi;
        $this->is_active = $menu->is_active;
        $this->isModalMenuOpen = true;
    }

    public function tutupModalMenu()
    {
        $this->isModalMenuOpen = false;
    }

    public function simpanMenu()
    {
        $this->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'kategori' => 'required|string',
            'waktu_penyajian' => 'required|string',
            'estimasi_harga_porsi' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $data = [
            'nama_menu' => $this->nama_menu,
            'deskripsi' => $this->deskripsi,
            'kategori' => $this->kategori,
            'waktu_penyajian' => $this->waktu_penyajian,
            'estimasi_harga_porsi' => $this->estimasi_harga_porsi,
            'is_active' => $this->is_active,
        ];

        if ($this->editMenuId) {
            Menu::findOrFail($this->editMenuId)->update($data);
            session()->flash('success', 'Menu berhasil diperbarui.');
        } else {
            Menu::create($data);
            session()->flash('success', 'Menu baru berhasil ditambahkan.');
        }

        $this->tutupModalMenu();
    }

    public function hapusMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        session()->flash('success', 'Menu berhasil dihapus.');
    }

    // --- State & Methods untuk Modal Resep ---
    public $isModalResepOpen = false;

    public $activeMenuId = null;

    public $activeMenuName = '';

    public $selectedBahanId = '';

    public $jumlahPerPorsi = '';

    public $resepBahanList = [];

    public function bukaModalResep($menuId)
    {
        $this->reset(['selectedBahanId', 'jumlahPerPorsi', 'resepBahanList']);

        $menu = Menu::with('bahanBakus')->findOrFail($menuId);
        $this->activeMenuId = $menu->id;
        $this->activeMenuName = $menu->nama_menu;
        $this->resepBahanList = $menu->bahanBakus; // Load existing

        $this->isModalResepOpen = true;
    }

    public function tutupModalResep()
    {
        $this->reset(['activeMenuId', 'activeMenuName', 'selectedBahanId', 'jumlahPerPorsi', 'resepBahanList']);
        $this->isModalResepOpen = false;
    }

    public function tambahBahanKeResep()
    {
        $this->validate([
            'selectedBahanId' => 'required|exists:bahan_bakus,id',
            'jumlahPerPorsi' => 'required|numeric|min:0.01',
        ]);

        $menu = Menu::findOrFail($this->activeMenuId);

        // Validasi duplicate
        if ($menu->bahanBakus()->where('bahan_baku_id', $this->selectedBahanId)->exists()) {
            session()->flash('error_resep', 'Bahan baku ini sudah ada di dalam resep.');

            return;
        }

        // Attach ke pivot
        $menu->bahanBakus()->attach($this->selectedBahanId, [
            'jumlah_dibutuhkan' => $this->jumlahPerPorsi,
        ]);

        // Refresh state
        $this->resepBahanList = $menu->bahanBakus()->get();
        $this->reset(['selectedBahanId', 'jumlahPerPorsi']);
        $this->dispatch('reset-select-bahan');
        session()->flash('success_resep', 'Bahan baku berhasil ditambahkan ke resep.');
    }

    public function hapusBahanDariResep($bahanId)
    {
        $menu = Menu::findOrFail($this->activeMenuId);
        $menu->bahanBakus()->detach($bahanId);

        // Refresh state
        $this->resepBahanList = $menu->bahanBakus()->get();
    }

    // --- State & Methods untuk Modal Rencana Harian ---
    public $isModalRencanaOpen = false;

    public $rencana_tanggal;

    public $rencana_waktu = 'Pagi'; // Default

    public $rencana_menu_id;

    public $rencana_target_porsi;

    public $rencana_peruntukan = 'reguler'; // 'reguler' (Tamu Mess), 'tamu_luar' (Tamu Luar / Acara), 'trainer' (Trainer)

    public function updatedRencanaWaktu($value)
    {
        if (strtolower($value) === 'jus_trainer') {
            $this->rencana_peruntukan = 'trainer';
        }
    }

    public function bukaModalRencana()
    {
        $this->reset(['rencana_tanggal', 'rencana_waktu', 'rencana_menu_id', 'rencana_target_porsi', 'rencana_peruntukan']);
        $this->rencana_tanggal = date('Y-m-d');
        $this->rencana_waktu = 'Pagi';
        $this->rencana_peruntukan = 'reguler';
        $this->isModalRencanaOpen = true;
    }

    public function tutupModalRencana()
    {
        $this->isModalRencanaOpen = false;
    }

    public function simpanRencana()
    {
        $this->validate([
            'rencana_tanggal' => 'required|date',
            'rencana_waktu' => 'required|string',
            'rencana_menu_id' => 'required|exists:menus,id',
            'rencana_target_porsi' => 'required|numeric|min:1',
            'rencana_peruntukan' => 'required|in:reguler,tamu_luar,trainer',
        ]);

        $peruntukan = $this->rencana_peruntukan;
        if (strtolower($this->rencana_waktu) === 'jus_trainer') {
            $peruntukan = 'trainer';
        }

        RencanaMenuHarian::create([
            'tanggal' => $this->rencana_tanggal,
            'waktu' => $this->rencana_waktu,
            'menu_id' => $this->rencana_menu_id,
            'status' => 'menunggu',
            'target_porsi' => $this->rencana_target_porsi,
            'peruntukan' => $peruntukan,
        ]);

        $this->tutupModalRencana();
        session()->flash('success', 'Rencana masak harian berhasil dibuat.');
    }

    public function hapusRencana($id)
    {
        $rencanaMenu = RencanaMenuHarian::find($id);

        if (! $rencanaMenu) {
            session()->flash('error', 'Data Rencana Menu tidak ditemukan.');

            return;
        }

        if ($rencanaMenu->status !== 'menunggu') {
            session()->flash('error', 'Hanya rencana yang belum dimulai yang dapat dihapus.');

            return;
        }

        $rencanaMenu->delete();
        session()->flash('success', 'Rencana masak berhasil dihapus.');
    }

    public function mulaiMasak($id)
    {
        // 1. Validasi Awal
        $rencanaMenu = RencanaMenuHarian::with('menu.bahanBakus')->find($id);

        if (! $rencanaMenu) {
            session()->flash('error', 'Data Rencana Menu tidak ditemukan.');

            return;
        }

        // Cek status masak (kolom aktual: 'status')
        if ($rencanaMenu->status !== 'menunggu') {
            session()->flash('error', 'Status rencana harian ini tidak valid untuk mulai memasak (sudah sedang masak atau selesai).');

            return;
        }

        // 2. Gunakan DB::transaction
        try {
            DB::transaction(function () use ($rencanaMenu) {
                // 3. Logika Kalkulasi & Pemotongan
                $menu = $rencanaMenu->menu;

                // Gunakan target_porsi dari DB jika ada, jika belum gunakan default fallback (contoh: 100)
                // (Catatan: kolom target_porsi belum ada di schema rencana_menu_harians)
                $targetPorsi = $rencanaMenu->target_porsi ?? 100;

                if ($menu && $menu->bahanBakus) {
                    foreach ($menu->bahanBakus as $bahanBaku) {
                        // Kolom di pivot table adalah jumlah_dibutuhkan
                        $jumlahPerPorsi = (float) $bahanBaku->pivot->jumlah_dibutuhkan;
                        $jumlahDipotong = round($jumlahPerPorsi * $targetPorsi, 3);
                        $stokTersedia = round((float) $bahanBaku->stok, 3);

                        // Validasi stok (kolom aktual: 'stok') dengan pembulatan 3 desimal agar terhindar dari floating point precision bug
                        if ($stokTersedia < $jumlahDipotong) {
                            // Lempar exception agar transaksi DB dibatalkan secara otomatis
                            throw new \Exception("Stok {$bahanBaku->nama_bahan} tidak mencukupi. (Butuh: {$jumlahDipotong}, Tersedia: {$stokTersedia})");
                        }

                        // Lakukan pengurangan
                        $bahanBaku->decrement('stok', $jumlahDipotong);

                        // 4. Pencatatan Log
                        PemotonganStok::create([
                            'rencana_menu_harian_id' => $rencanaMenu->id,
                            'bahan_baku_id' => $bahanBaku->id,
                            'jumlah_dipotong' => $jumlahDipotong,
                        ]);
                    }
                }

                // 5. Update Status
                $rencanaMenu->update(['status' => 'sedang_masak']);
            });

            // Notifikasi Sukses
            session()->flash('success', 'Proses memasak dimulai. Stok bahan baku telah dipotong otomatis.');

        } catch (\Exception $e) {
            // Notifikasi Error dari Exception
            session()->flash('error', $e->getMessage());
        }
    }

    public function selesaiMasak($id)
    {
        $rencanaMenu = RencanaMenuHarian::find($id);

        if (! $rencanaMenu || $rencanaMenu->status !== 'sedang_masak') {
            session()->flash('error', 'Status rencana harian ini tidak valid untuk diselesaikan.');

            return;
        }

        $rencanaMenu->update(['status' => 'selesai']);
        session()->flash('success', 'Masakan telah selesai dan siap dihidangkan!');
    }

    // --- State & Methods untuk Modal Ulasan ---
    public $isModalUlasanOpen = false;

    public $ulasanList = [];

    public $ulasanMenuName = '';

    public function bukaModalUlasan($id)
    {
        $rencanaMenu = RencanaMenuHarian::with(['menu', 'feedbackMasakans.tamu'])->find($id);
        if ($rencanaMenu) {
            $this->ulasanMenuName = $rencanaMenu->menu->nama_menu ?? 'Menu Tidak Diketahui';
            $this->ulasanList = $rencanaMenu->feedbackMasakans;
            $this->isModalUlasanOpen = true;
        }
    }

    public function tutupModalUlasan()
    {
        $this->isModalUlasanOpen = false;
    }

    // --- State & Methods untuk Cetak Daftar Belanja ---
    public $isModalCetakOpen = false;

    public $cetak_start_date;

    public $cetak_end_date;

    public $cetak_nama_pelatihan;

    public $cetak_jumlah_peserta;

    public $cetak_nomor_surat = '';

    public static function getNomorSuratBerikutnya(): string
    {
        $filePath = storage_path('app/dapur_nomor_surat.txt');
        if (file_exists($filePath)) {
            $val = trim((string) file_get_contents($filePath));
            if ($val !== '' && is_numeric($val)) {
                return (string) $val;
            }
        }

        $cached = Cache::get('dapur_last_nomor_surat');
        if ($cached !== null && is_numeric($cached)) {
            return (string) $cached;
        }

        return '11';
    }

    public static function simpanNomorSuratBerikutnya(int $nextNumber): void
    {
        Cache::forever('dapur_last_nomor_surat', (string) $nextNumber);
        $filePath = storage_path('app/dapur_nomor_surat.txt');
        @file_put_contents($filePath, (string) $nextNumber);
    }

    public function bukaModalCetak()
    {
        $this->reset(['cetak_start_date', 'cetak_end_date', 'cetak_nama_pelatihan', 'cetak_jumlah_peserta']);
        $this->resetValidation();
        $this->cetak_start_date = date('Y-m-d');
        $this->cetak_end_date = date('Y-m-d', strtotime('+7 days'));
        // Ambil nomor urut surat tersimpan (selalu dipastikan string agar validasi tidak error)
        $this->cetak_nomor_surat = (string) self::getNomorSuratBerikutnya();
        $this->isModalCetakOpen = true;
    }

    public function tutupModalCetak()
    {
        $this->isModalCetakOpen = false;
    }

    public function prosesCetakBelanja()
    {
        $this->cetak_nomor_surat = (string) ($this->cetak_nomor_surat ?? '');

        $this->validate([
            'cetak_start_date' => 'required|date',
            'cetak_end_date' => 'required|date|after_or_equal:cetak_start_date',
            'cetak_nama_pelatihan' => 'required|string|max:255',
            'cetak_jumlah_peserta' => 'required|integer|min:1',
            'cetak_nomor_surat' => 'nullable|max:50',
        ], [
            'cetak_start_date.required' => 'Dari tanggal wajib diisi.',
            'cetak_end_date.required' => 'Sampai tanggal wajib diisi.',
            'cetak_nama_pelatihan.required' => 'Nama pelatihan wajib diisi.',
            'cetak_jumlah_peserta.required' => 'Jumlah peserta wajib diisi.',
        ]);

        $noInput = trim($this->cetak_nomor_surat);
        $currentSeq = (int) self::getNomorSuratBerikutnya();

        if ($noInput === '') {
            $noSuratFinal = (string) $currentSeq;
            self::simpanNomorSuratBerikutnya($currentSeq + 1);
        } elseif (is_numeric($noInput)) {
            $noSuratFinal = $noInput;
            self::simpanNomorSuratBerikutnya(((int) $noInput) + 1);
        } else {
            $noSuratFinal = $noInput;
        }

        $this->tutupModalCetak();

        // Redirect to print route with query parameters
        return redirect()->route('admin.dapur.print', [
            'start' => $this->cetak_start_date,
            'end' => $this->cetak_end_date,
            'pelatihan' => $this->cetak_nama_pelatihan,
            'peserta' => $this->cetak_jumlah_peserta,
            'no_surat' => $noSuratFinal,
            'tanggal_teks' => Carbon::parse($this->cetak_start_date)->translatedFormat('j F').' - '.Carbon::parse($this->cetak_end_date)->translatedFormat('j F Y'),
        ]);
    }

    // --- State & Methods untuk Modal Kedatangan Belanja ---
    public $isModalBelanjaOpen = false;

    public $belanjaItems = [];

    public function bukaModalBelanja()
    {
        $this->belanjaItems = [];

        $bahanKebutuhan = [];
        $rencanaMenunggu = RencanaMenuHarian::with('menu.bahanBakus')->where('status', 'menunggu')->get();

        foreach ($rencanaMenunggu as $rencana) {
            $targetPorsi = $rencana->target_porsi ?? 100;
            if ($rencana->menu && $rencana->menu->bahanBakus) {
                foreach ($rencana->menu->bahanBakus as $bahanBaku) {
                    $butuh = round(((float) $bahanBaku->pivot->jumlah_dibutuhkan) * $targetPorsi, 3);
                    if (! isset($bahanKebutuhan[$bahanBaku->id])) {
                        $bahanKebutuhan[$bahanBaku->id] = 0;
                    }
                    $bahanKebutuhan[$bahanBaku->id] = round($bahanKebutuhan[$bahanBaku->id] + $butuh, 3);
                }
            }
        }

        $allBahan = BahanBaku::whereIn('id', array_keys($bahanKebutuhan))->get();

        foreach ($allBahan as $bahan) {
            $kebutuhan = round($bahanKebutuhan[$bahan->id], 3);
            $stokTersedia = round((float) $bahan->stok, 3);
            if ($stokTersedia < $kebutuhan) {
                $kekurangan = round($kebutuhan - $stokTersedia, 3);
                $this->belanjaItems[] = [
                    'bahan_baku_id' => $bahan->id,
                    'nama_bahan' => $bahan->nama_bahan,
                    'satuan' => $bahan->satuan,
                    'kekurangan' => $kekurangan,
                    'kuantitas_dibeli' => $kekurangan,
                    'total_harga_beli' => 0,
                ];
            }
        }

        $this->isModalBelanjaOpen = true;
    }

    public function tutupModalBelanja()
    {
        $this->isModalBelanjaOpen = false;
    }

    public function simpanBelanja()
    {
        $this->validate([
            'belanjaItems.*.kuantitas_dibeli' => 'required|numeric|min:0',
            'belanjaItems.*.total_harga_beli' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () {
            foreach ($this->belanjaItems as $item) {
                $qty = round((float) $item['kuantitas_dibeli'], 3);
                if ($qty > 0) {
                    $bahan = BahanBaku::find($item['bahan_baku_id']);

                    // Update stok dengan pembulatan 3 desimal
                    $bahan->stok = round((float) $bahan->stok + $qty, 3);

                    // Update harga satuan sesuai harga pasar terbaru
                    $hargaSatuanAktual = 0;
                    if ($item['total_harga_beli'] > 0) {
                        $hargaSatuanAktual = round($item['total_harga_beli'] / $qty, 2);
                        $bahan->harga_satuan = $hargaSatuanAktual;
                    }

                    $bahan->save();

                    // Insert Log Belanja
                    RiwayatBelanjaDapur::create([
                        'bahan_baku_id' => $bahan->id,
                        'kuantitas_dibeli' => $qty,
                        'total_harga_beli' => $item['total_harga_beli'],
                        'harga_satuan_aktual' => $hargaSatuanAktual,
                        'tanggal_belanja' => now(),
                    ]);
                }
            }
        });

        $this->tutupModalBelanja();
        session()->flash('success', 'Kedatangan barang berhasil diinput dan stok telah ditambahkan. Silakan klik Mulai Masak.');
    }

    // --- State & Methods untuk Cetak Jadwal Menu ---
    public $isModalJadwalOpen = false;

    public $jadwal_start_date;

    public $jadwal_end_date;

    public $jadwal_nama_pelatihan;

    public $jadwal_jumlah_peserta;

    public function bukaModalJadwal()
    {
        $this->reset(['jadwal_start_date', 'jadwal_end_date', 'jadwal_nama_pelatihan', 'jadwal_jumlah_peserta']);
        $this->jadwal_start_date = date('Y-m-d');
        $this->jadwal_end_date = date('Y-m-d', strtotime('+6 days'));
        $this->isModalJadwalOpen = true;
    }

    public function tutupModalJadwal()
    {
        $this->isModalJadwalOpen = false;
    }

    public function prosesCetakJadwal()
    {
        $this->validate([
            'jadwal_start_date' => 'required|date',
            'jadwal_end_date' => 'required|date|after_or_equal:jadwal_start_date',
            'jadwal_nama_pelatihan' => 'required|string|max:255',
            'jadwal_jumlah_peserta' => 'required|integer|min:1',
        ]);

        $this->tutupModalJadwal();

        return redirect()->route('admin.dapur.print-jadwal', [
            'start' => $this->jadwal_start_date,
            'end' => $this->jadwal_end_date,
            'pelatihan' => $this->jadwal_nama_pelatihan,
            'peserta' => $this->jadwal_jumlah_peserta,
        ]);
    }
}
