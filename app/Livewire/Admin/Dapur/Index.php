<?php

namespace App\Livewire\Admin\Dapur;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\BahanBaku;
use App\Models\Menu;
use App\Models\RencanaMenuHarian;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('DAPUR & MENU')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $activeTab = 'stok'; // stok, master, rencana

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $bahanBakus = BahanBaku::latest()->paginate($this->perPage, ['*'], 'stokPage');
        $menus = Menu::withCount('bahanBakus')->latest()->paginate($this->perPage, ['*'], 'menuPage');
        $rencanaHarians = RencanaMenuHarian::with(['menu', 'feedbackMasakans'])->latest()->paginate($this->perPage, ['*'], 'rencanaPage');

        return view('livewire.admin.dapur.index', compact('bahanBakus', 'menus', 'rencanaHarians'));
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
            'keterangan_volume' => 'nullable|string|max:50'
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
            'jumlah_dibutuhkan' => $this->jumlahPerPorsi
        ]);

        // Refresh state
        $this->resepBahanList = $menu->bahanBakus()->get();
        $this->reset(['selectedBahanId', 'jumlahPerPorsi']);
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

    public function bukaModalRencana()
    {
        $this->reset(['rencana_tanggal', 'rencana_waktu', 'rencana_menu_id', 'rencana_target_porsi']);
        $this->rencana_tanggal = date('Y-m-d');
        $this->rencana_waktu = 'Pagi';
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
        ]);

        RencanaMenuHarian::create([
            'tanggal' => $this->rencana_tanggal,
            'waktu' => $this->rencana_waktu,
            'menu_id' => $this->rencana_menu_id,
            'status' => 'menunggu',
            'target_porsi' => $this->rencana_target_porsi,
        ]);

        $this->tutupModalRencana();
        session()->flash('success', 'Rencana masak harian berhasil dibuat.');
    }

    public function mulaiMasak($id)
    {
        // 1. Validasi Awal
        $rencanaMenu = RencanaMenuHarian::with('menu.bahanBakus')->find($id);

        if (!$rencanaMenu) {
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
            \Illuminate\Support\Facades\DB::transaction(function () use ($rencanaMenu) {
                // 3. Logika Kalkulasi & Pemotongan
                $menu = $rencanaMenu->menu;
                
                // Gunakan target_porsi dari DB jika ada, jika belum gunakan default fallback (contoh: 100)
                // (Catatan: kolom target_porsi belum ada di schema rencana_menu_harians)
                $targetPorsi = $rencanaMenu->target_porsi ?? 100;

                if ($menu && $menu->bahanBakus) {
                    foreach ($menu->bahanBakus as $bahanBaku) {
                        // Kolom di pivot table adalah jumlah_dibutuhkan
                        $jumlahPerPorsi = $bahanBaku->pivot->jumlah_dibutuhkan;
                        $jumlahDipotong = $jumlahPerPorsi * $targetPorsi;

                        // Validasi stok (kolom aktual: 'stok')
                        if ($bahanBaku->stok < $jumlahDipotong) {
                            // Lempar exception agar transaksi DB dibatalkan secara otomatis
                            throw new \Exception("Stok {$bahanBaku->nama_bahan} tidak mencukupi. (Butuh: {$jumlahDipotong}, Tersedia: {$bahanBaku->stok})");
                        }

                        // Lakukan pengurangan
                        $bahanBaku->decrement('stok', $jumlahDipotong);

                        // 4. Pencatatan Log
                        \App\Models\PemotonganStok::create([
                            'rencana_menu_harian_id' => $rencanaMenu->id,
                            'bahan_baku_id' => $bahanBaku->id,
                            'jumlah_dipotong' => $jumlahDipotong
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

        if (!$rencanaMenu || $rencanaMenu->status !== 'sedang_masak') {
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

    public function bukaModalCetak()
    {
        $this->reset(['cetak_start_date', 'cetak_end_date', 'cetak_nama_pelatihan', 'cetak_jumlah_peserta']);
        $this->cetak_start_date = date('Y-m-d');
        $this->cetak_end_date = date('Y-m-d', strtotime('+7 days'));
        $this->isModalCetakOpen = true;
    }

    public function tutupModalCetak()
    {
        $this->isModalCetakOpen = false;
    }

    public function prosesCetakBelanja()
    {
        $this->validate([
            'cetak_start_date' => 'required|date',
            'cetak_end_date' => 'required|date|after_or_equal:cetak_start_date',
            'cetak_nama_pelatihan' => 'required|string|max:255',
            'cetak_jumlah_peserta' => 'required|integer|min:1',
        ]);

        $this->tutupModalCetak();

        // Redirect to print route with query parameters
        return redirect()->route('admin.dapur.print', [
            'start' => $this->cetak_start_date,
            'end' => $this->cetak_end_date,
            'pelatihan' => $this->cetak_nama_pelatihan,
            'peserta' => $this->cetak_jumlah_peserta,
            'tanggal_teks' => \Carbon\Carbon::parse($this->cetak_start_date)->translatedFormat('j F') . ' - ' . \Carbon\Carbon::parse($this->cetak_end_date)->translatedFormat('j F Y'),
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
                    $butuh = $bahanBaku->pivot->jumlah_dibutuhkan * $targetPorsi;
                    if (!isset($bahanKebutuhan[$bahanBaku->id])) {
                        $bahanKebutuhan[$bahanBaku->id] = 0;
                    }
                    $bahanKebutuhan[$bahanBaku->id] += $butuh;
                }
            }
        }

        $allBahan = \App\Models\BahanBaku::whereIn('id', array_keys($bahanKebutuhan))->get();
        
        foreach ($allBahan as $bahan) {
            $kebutuhan = $bahanKebutuhan[$bahan->id];
            if ($bahan->stok < $kebutuhan) {
                $kekurangan = $kebutuhan - $bahan->stok;
                $this->belanjaItems[] = [
                    'bahan_baku_id' => $bahan->id,
                    'nama_bahan' => $bahan->nama_bahan,
                    'satuan' => $bahan->satuan,
                    'kekurangan' => $kekurangan,
                    'kuantitas_dibeli' => $kekurangan,
                    'total_harga_beli' => 0
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

        \Illuminate\Support\Facades\DB::transaction(function () {
            foreach ($this->belanjaItems as $item) {
                if ($item['kuantitas_dibeli'] > 0) {
                    $bahan = \App\Models\BahanBaku::find($item['bahan_baku_id']);
                    
                    // Update stok
                    $bahan->stok += $item['kuantitas_dibeli'];
                    
                    // Update harga satuan sesuai harga pasar terbaru
                    $hargaSatuanAktual = 0;
                    if ($item['total_harga_beli'] > 0) {
                        $hargaSatuanAktual = $item['total_harga_beli'] / $item['kuantitas_dibeli'];
                        $bahan->harga_satuan = $hargaSatuanAktual;
                    }
                    
                    $bahan->save();

                    // Insert Log Belanja
                    \App\Models\RiwayatBelanjaDapur::create([
                        'bahan_baku_id' => $bahan->id,
                        'kuantitas_dibeli' => $item['kuantitas_dibeli'],
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

    // --- State & Methods untuk Set Jus Trainer ---
    public $isModalJusOpen = false;
    public $jus_tanggal;
    public $jus_trainer_name;

    public function bukaModalJus($tanggal)
    {
        $this->jus_tanggal = $tanggal;
        $info = \App\Models\InformasiHarianDapur::where('tanggal', $tanggal)->first();
        $this->jus_trainer_name = $info ? $info->jus_trainer : '';
        $this->isModalJusOpen = true;
    }

    public function tutupModalJus()
    {
        $this->isModalJusOpen = false;
    }

    public function simpanJus()
    {
        $this->validate([
            'jus_tanggal' => 'required|date',
            'jus_trainer_name' => 'nullable|string|max:255',
        ]);

        \App\Models\InformasiHarianDapur::updateOrCreate(
            ['tanggal' => $this->jus_tanggal],
            ['jus_trainer' => $this->jus_trainer_name]
        );

        $this->tutupModalJus();
        session()->flash('success', 'Jus trainer berhasil disimpan.');
    }
}
