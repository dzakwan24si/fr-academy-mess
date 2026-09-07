<div class="p-6 h-full flex flex-col">
    <!-- Header & Tabs -->
    <div class="flex flex-col gap-6 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Manajemen Dapur & Menu</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola stok bahan baku, resep masakan, dan rencana menu harian Mess.</p>
        </div>

        @if(session()->has('success'))
            <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-200">
            <button wire:click="setTab('stok')" class="px-6 py-3 text-sm font-semibold border-b-2 transition-colors {{ $activeTab === 'stok' ? 'border-[#2E7D32] text-[#2E7D32]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Stok Bahan Baku
            </button>
            <button wire:click="setTab('master')" class="px-6 py-3 text-sm font-semibold border-b-2 transition-colors {{ $activeTab === 'master' ? 'border-[#2E7D32] text-[#2E7D32]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Master Menu & Resep
            </button>
            <button wire:click="setTab('rencana')" class="px-6 py-3 text-sm font-semibold border-b-2 transition-colors {{ $activeTab === 'rencana' ? 'border-[#2E7D32] text-[#2E7D32]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Rencana Harian & Masak
            </button>
        </div>
    </div>

    <!-- Content Area -->
    <div class="flex-1 flex flex-col min-h-0">
        
        {{-- TAB 1: STOK BAHAN BAKU --}}
        @if($activeTab === 'stok')
            <div class="flex-1 flex flex-col overflow-hidden">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Stok Saat Ini</h2>
                    <div class="flex gap-3">
                        <button wire:click="bukaModalBelanja" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Input Belanja
                        </button>
                        <button wire:click="bukaModal" class="px-4 py-2 bg-[#59A338] hover:bg-[#4d8c2f] text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah Bahan
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-auto rounded-xl border border-gray-100 bg-white">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50/50 sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100 w-16">No</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Nama Bahan</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Kategori</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Stok Saat Ini</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Harga Satuan</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Satuan</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($bahanBakus as $index => $bahan)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-gray-500 font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $bahan->nama_bahan }}</td>
                                <td class="px-6 py-4 font-medium">
                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded text-xs font-semibold {{ $bahan->kategori_bahan == 'Basah' ? 'bg-blue-50 text-blue-600 border border-blue-200' : 'bg-orange-50 text-orange-600 border border-orange-200' }}">
                                        {{ $bahan->kategori_bahan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold {{ $bahan->stok < 10 ? 'text-red-500' : 'text-green-600' }}">{{ (float) $bahan->stok }}</td>
                                <td class="px-6 py-4 text-gray-500">Rp {{ number_format($bahan->harga_satuan, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $bahan->satuan }} {{ $bahan->keterangan_volume ? '('.$bahan->keterangan_volume.')' : '' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-2">
                                        <button wire:click="editBahan({{ $bahan->id }})" class="p-1.5 rounded-full text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button wire:click="hapusBahan({{ $bahan->id }})" onclick="confirm('Yakin ingin menghapus bahan baku ini?') || event.stopImmediatePropagation()" class="p-1.5 rounded-full text-red-600 bg-red-50 hover:bg-red-100 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada data stok bahan baku.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- TAB 2: MASTER MENU & RESEP --}}
        @elseif($activeTab === 'master')
            <div class="flex-1 flex flex-col overflow-hidden">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Master Menu</h2>
                    <button wire:click="bukaModalMenu" class="px-4 py-2 bg-[#59A338] hover:bg-[#4d8c2f] text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Menu
                    </button>
                </div>

                <div class="flex-1 overflow-auto rounded-xl border border-gray-100 bg-white">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50/50 sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100 w-16">No</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-500 text-[11px] uppercase tracking-wider">Nama Menu</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-500 text-[11px] uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-500 text-[11px] uppercase tracking-wider">Waktu</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-500 text-[11px] uppercase tracking-wider">Deskripsi</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-500 text-[11px] uppercase tracking-wider text-center">Jumlah Bahan</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-500 text-[11px] uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($menus as $index => $menu)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-gray-500 font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $menu->nama_menu }}</td>
                                <td class="px-6 py-4 text-gray-500">
                                    <span class="inline-flex items-center justify-center px-2 py-1 bg-blue-50 text-blue-600 border border-blue-200 rounded text-xs font-semibold">
                                        {{ $menu->kategori ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    <span class="inline-flex items-center justify-center px-2 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded text-xs font-semibold">
                                        {{ $menu->waktu_penyajian ?? 'Universal' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 truncate max-w-xs">{{ $menu->deskripsi ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center justify-center px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-bold">
                                        {{ $menu->bahan_bakus_count ?? 0 }} Item
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-2">
                                        <button wire:click="bukaModalResep({{ $menu->id }})" class="px-3 py-1.5 rounded-lg text-emerald-700 bg-emerald-50 hover:bg-emerald-100 font-semibold text-xs border border-emerald-200 transition-colors">
                                            Atur Resep
                                        </button>
                                        <button wire:click="editMenu({{ $menu->id }})" class="p-1.5 rounded-full text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button wire:click="hapusMenu({{ $menu->id }})" wire:confirm="Yakin ingin menghapus menu ini?" class="p-1.5 rounded-full text-red-600 bg-red-50 hover:bg-red-100 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada data menu.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- TAB 3: RENCANA HARIAN --}}
        @elseif($activeTab === 'rencana')
            <div class="flex-1 flex flex-col overflow-hidden">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Rencana Masak Hari Ini</h2>
                    <div class="flex gap-3">
                        <!-- Date Filter Placeholder -->
                        <input type="date" class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 bg-gray-50 focus:bg-white transition-colors" value="{{ date('Y-m-d') }}">
                        
                        <button wire:click="bukaModalCetak" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Daftar Belanja
                        </button>
                        
                        <button wire:click="bukaModalJadwal" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Cetak Jadwal Menu
                        </button>

                        <button wire:click="bukaModalRencana" class="px-4 py-2 bg-[#2E7D32] hover:bg-green-700 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Buat Rencana
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-auto rounded-xl border border-gray-100 bg-white">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50/50 sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Tanggal</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Nama Menu</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Waktu</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Target Porsi</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Estimasi Anggaran</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Status Masak</th>
                                <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($rencanaHarians as $rencana)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-gray-600 font-medium">
                                    {{ \Carbon\Carbon::parse($rencana->tanggal)->format('d M Y') }}
                                    <button wire:click="bukaModalJus('{{ $rencana->tanggal }}')" class="ml-2 px-2 py-0.5 text-[10px] font-bold bg-orange-100 text-orange-700 hover:bg-orange-200 rounded border border-orange-200 transition-colors">SET JUS</button>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $rencana->menu->nama_menu ?? 'Menu Terhapus' }}</td>
                                <td class="px-6 py-4 text-gray-600 font-medium">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ ucfirst($rencana->waktu) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $rencana->target_porsi }} Porsi
                                </td>
                                <td class="px-6 py-4 text-gray-500 font-medium">
                                    @php
                                        $hargaPorsi = $rencana->menu->estimasi_harga_porsi > 0 
                                            ? $rencana->menu->estimasi_harga_porsi 
                                            : ($rencana->menu->bahanBakus ? $rencana->menu->bahanBakus->sum(function($b) { return $b->pivot->jumlah_dibutuhkan * $b->harga_satuan; }) : 0);
                                        $totalAnggaran = $hargaPorsi * $rencana->target_porsi;
                                    @endphp
                                    Rp {{ number_format($totalAnggaran, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($rencana->status == 'selesai')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Selesai
                                        </span>
                                    @elseif($rencana->status == 'sedang_masak')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Sedang Masak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Belum Mulai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-2">
                                        @if($rencana->status == 'sedang_masak')
                                        <button wire:click="selesaiMasak({{ $rencana->id }})" class="px-3 py-1.5 rounded-lg text-emerald-700 bg-emerald-50 hover:bg-emerald-100 font-semibold text-xs border border-emerald-200 transition-colors">
                                            Selesai Masak
                                        </button>
                                        @elseif($rencana->status == 'menunggu')
                                        <button wire:click="mulaiMasak({{ $rencana->id }})" class="px-3 py-1.5 rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 font-semibold text-xs border border-blue-200 transition-colors">
                                            Mulai Masak
                                        </button>
                                        @elseif($rencana->status == 'selesai')
                                            @php
                                                $avgRating = $rencana->feedbackMasakans->avg('rating');
                                                $countRating = $rencana->feedbackMasakans->count();
                                            @endphp
                                            @if($countRating > 0)
                                                <div class="flex flex-col items-center">
                                                    <div class="flex items-center text-orange-400">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                        <span class="font-bold text-gray-700">{{ number_format($avgRating, 1) }}</span>
                                                    </div>
                                                    <span class="text-[10px] text-gray-500">({{ $countRating }} ulasan)</span>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Belum ada ulasan</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada rencana masak.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>

    <!-- MODAL TAMBAH BAHAN BAKU -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-gray-100">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Tambah Bahan Baku Baru</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Lengkapi data bahan untuk keperluan dapur</p>
                </div>
                <button wire:click="tutupModal" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Bahan <span class="text-red-500">*</span></label>
                    <input wire:model="nama_bahan" type="text" placeholder="Contoh: Beras Premium" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors">
                    @error('nama_bahan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stok Awal <span class="text-red-500">*</span></label>
                        <input wire:model="stok_saat_ini" type="number" step="0.01" min="0" placeholder="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors">
                        @error('stok_saat_ini') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Satuan <span class="text-red-500">*</span></label>
                        <select wire:model="satuan" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors bg-white">
                            <option value="">-- Pilih --</option>
                            <option value="kg">Kilogram (kg)</option>
                            <option value="gram">Gram (g)</option>
                            <option value="liter">Liter (L)</option>
                            <option value="ml">Mililiter (ml)</option>
                            <option value="butir">Butir</option>
                            <option value="pcs">Pcs / Buah</option>
                            <option value="pak">Pak / Bks</option>
                            <option value="botol">Botol (btl)</option>
                        </select>
                        @error('satuan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                        <select wire:model="kategori_bahan" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors bg-white">
                            <option value="Kering">Bahan Kering</option>
                            <option value="Basah">Bahan Basah</option>
                        </select>
                        @error('kategori_bahan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                        <input wire:model="harga_satuan" type="number" min="0" placeholder="Contoh: 15000" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors">
                        @error('harga_satuan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan/Vol (Opsional)</label>
                        <input wire:model="keterangan_volume" type="text" placeholder="Contoh: 120 ptg" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors">
                        @error('keterangan_volume') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                <button wire:click="tutupModal" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </button>
                <button wire:click="simpanBahan" class="px-4 py-2 text-sm font-semibold text-white bg-[#59A338] hover:bg-[#4d8c2f] rounded-lg shadow-sm flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Data
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL TAMBAH MENU -->
    @if($isModalMenuOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl overflow-hidden border border-gray-100 flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 shrink-0">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $editMenuId ? 'Edit Master Menu' : 'Tambah Master Menu' }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Lengkapi data masakan ke daftar menu</p>
                </div>
                <button wire:click="tutupModalMenu" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto flex-1 space-y-6">
                <!-- SEKSI 1: DATA UTAMA -->
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-[#59A338] border-b border-gray-100 pb-2">1. DATA UTAMA</h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Menu <span class="text-red-500">*</span></label>
                        <input wire:model="nama_menu" type="text" placeholder="Contoh: Ayam Penyet" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors">
                        @error('nama_menu') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea wire:model="deskripsi" rows="3" placeholder="Deskripsi atau keterangan masakan..." class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors"></textarea>
                        @error('deskripsi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- SEKSI 2: DATA OPERASIONAL -->
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-[#59A338] border-b border-gray-100 pb-2">2. DATA OPERASIONAL</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori Menu <span class="text-red-500">*</span></label>
                            <select wire:model="kategori" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors bg-white">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Umum">Umum</option>
                                <option value="Sarapan">Sarapan</option>
                                <option value="Coffee Break">Coffee Break</option>
                                <option value="Makan Siang">Makan Siang</option>
                                <option value="Makan Malam">Makan Malam</option>
                            </select>
                            @error('kategori') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Waktu Penyajian <span class="text-red-500">*</span></label>
                            <select wire:model="waktu_penyajian" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors bg-white">
                                <option value="">-- Pilih Waktu --</option>
                                <option value="Pagi">Pagi</option>
                                <option value="Siang">Siang</option>
                                <option value="Malam">Malam</option>
                                <option value="Universal">Universal</option>
                            </select>
                            @error('waktu_penyajian') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Estimasi Harga/Porsi <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm">Rp</span>
                                <input wire:model="estimasi_harga_porsi" type="number" min="0" placeholder="0" class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors">
                            </div>
                            @error('estimasi_harga_porsi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Menu <span class="text-red-500">*</span></label>
                            <select wire:model="is_active" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors bg-white">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                            @error('is_active') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 shrink-0">
                <button wire:click="tutupModalMenu" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </button>
                <button wire:click="simpanMenu" class="px-4 py-2 text-sm font-semibold text-white bg-[#59A338] hover:bg-[#4d8c2f] rounded-lg shadow-sm flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    {{ $editMenuId ? 'Simpan Perubahan' : 'Simpan Menu' }}
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL BUAT RENCANA HARIAN -->
    @if($isModalRencanaOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Buat Rencana Masak</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Atur jadwal memasak harian untuk Mess</p>
                </div>
                <button wire:click="tutupModalRencana" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                        <input wire:model="rencana_tanggal" type="date" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors">
                        @error('rencana_tanggal') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Waktu <span class="text-red-500">*</span></label>
                        <select wire:model="rencana_waktu" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors bg-white">
                            <option value="Pagi">Pagi</option>
                            <option value="Siang">Siang</option>
                            <option value="Malam">Malam</option>
                        </select>
                        @error('rencana_waktu') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Pilih Menu Masakan <span class="text-red-500">*</span></label>
                        <select wire:model="rencana_menu_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors bg-white">
                            <option value="">-- Pilih Menu --</option>
                            @foreach($menus as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_menu }}</option>
                            @endforeach
                        </select>
                        @error('rencana_menu_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Target Porsi <span class="text-red-500">*</span></label>
                        <input wire:model="rencana_target_porsi" type="number" min="1" placeholder="Contoh: 100" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors">
                        @error('rencana_target_porsi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                <button wire:click="tutupModalRencana" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </button>
                <button wire:click="simpanRencana" class="px-4 py-2 text-sm font-semibold text-white bg-[#2E7D32] hover:bg-green-700 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Rencana
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL ATUR RESEP -->
    @if($isModalResepOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden border border-gray-100 flex flex-col max-h-[90vh]">
            <!-- Header Modal -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 shrink-0">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Resep: {{ $activeMenuName }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Tentukan takaran bahan baku per 1 porsi</p>
                </div>
                <button wire:click="tutupModalResep" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto flex-1">
                @if(session()->has('error_resep'))
                    <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        {{ session('error_resep') }}
                    </div>
                @endif
                @if(session()->has('success_resep'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success_resep') }}
                    </div>
                @endif

                <!-- Form Tambah Bahan ke Resep -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-6">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Tambah Bahan Baku</h4>
                    <div class="flex flex-col sm:flex-row gap-3 items-end">
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pilih Bahan Baku <span class="text-red-500">*</span></label>
                            <select wire:model="selectedBahanId" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors bg-white">
                                <option value="">-- Pilih Bahan --</option>
                                @foreach($bahanBakus as $b)
                                    <option value="{{ $b->id }}">{{ $b->nama_bahan }} ({{ $b->satuan }})</option>
                                @endforeach
                            </select>
                            @error('selectedBahanId') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full sm:w-32">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Takaran / Porsi <span class="text-red-500">*</span></label>
                            <input wire:model="jumlahPerPorsi" type="number" step="0.01" min="0.01" placeholder="Misal: 0.25" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338] transition-colors">
                            @error('jumlahPerPorsi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <button wire:click="tambahBahanKeResep" class="w-full sm:w-auto px-4 py-2 text-sm font-semibold text-white bg-[#59A338] hover:bg-[#4d8c2f] rounded-lg shadow-sm flex items-center justify-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah ke Resep
                        </button>
                    </div>
                </div>

                <!-- Tabel Resep Saat Ini -->
                <div class="border border-gray-100 rounded-xl overflow-hidden">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3 font-bold text-gray-500 text-[11px] uppercase tracking-wider w-12">No</th>
                                <th scope="col" class="px-4 py-3 font-bold text-gray-500 text-[11px] uppercase tracking-wider">Nama Bahan</th>
                                <th scope="col" class="px-4 py-3 font-bold text-gray-500 text-[11px] uppercase tracking-wider">Takaran</th>
                                <th scope="col" class="px-4 py-3 font-bold text-gray-500 text-[11px] uppercase tracking-wider">Satuan</th>
                                <th scope="col" class="px-4 py-3 font-bold text-gray-500 text-[11px] uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @forelse($resepBahanList as $index => $bahan)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $bahan->nama_bahan }}</td>
                                <td class="px-4 py-3 font-bold text-[#2E7D32]">{{ $bahan->pivot->jumlah_dibutuhkan }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $bahan->satuan }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center items-center">
                                        <button wire:click="hapusBahanDariResep({{ $bahan->id }})" class="p-1.5 rounded-full text-red-600 bg-red-50 hover:bg-red-100 transition-colors" title="Hapus dari resep">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada bahan baku dalam resep ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end shrink-0">
                <button wire:click="tutupModalResep" class="px-5 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    Selesai / Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL CETAK BELANJA -->
    @if($isModalCetakOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-blue-50/50">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Cetak Daftar Belanja</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Atur detail pelatihan dan rentang waktu rencana masak</p>
                </div>
                <button wire:click="tutupModalCetak" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Dari Tanggal <span class="text-red-500">*</span></label>
                        <input wire:model="cetak_start_date" type="date" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        @error('cetak_start_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Sampai Tanggal <span class="text-red-500">*</span></label>
                        <input wire:model="cetak_end_date" type="date" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        @error('cetak_end_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Pelatihan <span class="text-red-500">*</span></label>
                    <input wire:model="cetak_nama_pelatihan" type="text" placeholder="Contoh: FAT I, MAT I, TAT I 2027" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                    @error('cetak_nama_pelatihan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Peserta <span class="text-red-500">*</span></label>
                    <input wire:model="cetak_jumlah_peserta" type="number" min="1" placeholder="Contoh: 55" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                    @error('cetak_jumlah_peserta') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                <button wire:click="tutupModalCetak" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </button>
                <button wire:click="prosesCetakBelanja" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Proses & Cetak
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Input Kedatangan Belanja -->
    @if($isModalBelanjaOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="tutupModalBelanja"></div>
            
            <div class="relative bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] flex flex-col shadow-xl z-10">
                <div class="flex justify-between items-center p-6 pb-4 border-b border-gray-100 shrink-0">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Input Kedatangan Belanja</h3>
                        <p class="text-sm text-gray-500 mt-1">Isi kuantitas dan total harga beli berdasarkan nota belanja pasar.</p>
                    </div>
                    <button wire:click="tutupModalBelanja" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto">
                    @if(count($belanjaItems) > 0)
                        <div class="overflow-x-auto rounded-xl border border-gray-200">
                            <table class="min-w-full text-left text-sm whitespace-nowrap">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-600">Bahan Baku</th>
                                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Kekurangan (Estimasi)</th>
                                        <th class="px-4 py-3 font-semibold text-gray-600">Kuantitas Dibeli</th>
                                        <th class="px-4 py-3 font-semibold text-gray-600">Total Harga Beli (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($belanjaItems as $index => $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 font-medium text-gray-800">
                                            {{ $item['nama_bahan'] }}
                                        </td>
                                        <td class="px-4 py-3 text-center text-red-600 font-bold bg-red-50/50">
                                            {{ $item['kekurangan'] }} {{ $item['satuan'] }}
                                        </td>
                                        <td class="px-4 py-3 w-40">
                                            <div class="flex items-center gap-2">
                                                <input type="number" step="0.01" min="0" wire:model="belanjaItems.{{ $index }}.kuantitas_dibeli" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500 text-right font-medium">
                                                <span class="text-xs text-gray-500 w-8">{{ $item['satuan'] }}</span>
                                            </div>
                                            @error('belanjaItems.'.$index.'.kuantitas_dibeli') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="px-4 py-3 w-48">
                                            <input type="number" step="1" min="0" wire:model="belanjaItems.{{ $index }}.total_harga_beli" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500 text-right font-medium" placeholder="Cth: 50000">
                                            @error('belanjaItems.'.$index.'.total_harga_beli') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 mb-4">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Stok Aman!</h4>
                            <p class="text-gray-500">Tidak ada bahan baku yang minus untuk rencana masak saat ini.</p>
                        </div>
                    @endif
                </div>

                <div class="p-6 pt-4 border-t border-gray-100 flex justify-end gap-3 shrink-0 bg-gray-50 rounded-b-2xl">
                    <button type="button" wire:click="tutupModalBelanja" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                        Batal
                    </button>
                    @if(count($belanjaItems) > 0)
                    <button type="button" wire:click="simpanBelanja" class="px-6 py-2.5 text-sm font-semibold text-white bg-orange-600 hover:bg-orange-700 rounded-xl shadow-sm flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan & Update Stok
                    </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL CETAK JADWAL MENU -->
    @if($isModalJadwalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Cetak Jadwal Menu</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Cetak FORM/TA/04.a (Daftar Menu Learning & Development)</p>
                </div>
                <button wire:click="tutupModalJadwal" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Mulai Tanggal <span class="text-red-500">*</span></label>
                        <input wire:model="jadwal_start_date" type="date" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338]">
                        @error('jadwal_start_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Sampai Tanggal <span class="text-red-500">*</span></label>
                        <input wire:model="jadwal_end_date" type="date" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338]">
                        @error('jadwal_end_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Pelatihan <span class="text-red-500">*</span></label>
                    <input wire:model="jadwal_nama_pelatihan" type="text" placeholder="Contoh: FAT I, MAT I, TAT I 2027" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338]">
                    @error('jadwal_nama_pelatihan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Peserta (Total) <span class="text-red-500">*</span></label>
                    <input wire:model="jadwal_jumlah_peserta" type="number" min="1" placeholder="Contoh: 55" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338]">
                    <p class="text-[10px] text-gray-500 mt-1">Misal: 55 Orang (di PDF otomatis tertulis "55+3")</p>
                    @error('jadwal_jumlah_peserta') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
                <button wire:click="tutupModalJadwal" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button wire:click="prosesCetakJadwal" class="px-4 py-2 text-sm font-semibold text-white bg-purple-600 hover:bg-purple-700 rounded-lg flex items-center gap-2">
                    Cetak PDF
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL SET JUS TRAINER -->
    @if($isModalJusOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Set Jus Trainer</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($jus_tanggal)->format('d F Y') }}</p>
                </div>
                <button wire:click="tutupModalJus" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Jus</label>
                <input wire:model="jus_trainer_name" type="text" placeholder="Cth: Alpukat, Mangga, Naga" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#59A338] focus:ring-1 focus:ring-[#59A338]">
                @error('jus_trainer_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
                <button wire:click="tutupModalJus" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button wire:click="simpanJus" class="px-4 py-2 text-sm font-semibold text-white bg-orange-600 hover:bg-orange-700 rounded-lg">
                    Simpan Jus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
