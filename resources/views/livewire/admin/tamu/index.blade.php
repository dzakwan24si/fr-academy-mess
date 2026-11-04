<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Data & Direktori Tamu</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola database akun tamu, pantau riwayat menginap, dan bersihkan nomor tidak aktif.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            @unless(auth()->user()->isReadOnly())
                <button wire:click="bukaModalTambah" class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-[#2E7D32] hover:bg-green-800 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Daftarkan Tamu Manual</span>
                </button>
            @endunless
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Akun Tamu</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-0.5">{{ number_format($totalTamu) }}</h3>
                <span class="text-[11px] text-gray-500 font-medium">Terdaftar di sistem</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Tamu Aktif</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-0.5">{{ number_format($tamuAktifCount) }}</h3>
                <span class="text-[11px] text-emerald-600 font-medium">Inap &le; 6 bulan terakhir</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Lama Inaktif</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-0.5">{{ number_format($tamuInaktifCount) }}</h3>
                <span class="text-[11px] text-amber-600 font-medium">> 6 bulan / belum inap</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 border border-purple-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Kategori</p>
                <h3 class="text-xl font-bold text-gray-800 mt-0.5">{{ number_format($totalTrainee) }} <span class="text-xs font-normal text-gray-500">Trainee</span></h3>
                <span class="text-[11px] text-gray-500 font-medium">{{ number_format($totalUmum) }} Tamu Umum</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Pencarian Tamu</label>
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Ketik Nama, Nomor HP, atau Pelatihan (FAT/MAT)..." class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-shadow">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <div class="w-full md:w-52">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kategori</label>
            <select wire:model.live="filterKategori" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-shadow font-medium">
                <option value="all">Semua Kategori</option>
                <option value="trainee">Trainee (Peserta Pelatihan)</option>
                <option value="tamu_umum">Tamu Umum</option>
            </select>
        </div>

        <div class="w-full md:w-60">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Keaktifan Menginap</label>
            <select wire:model.live="filterStatus" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-shadow font-medium">
                <option value="all">Semua Status Keaktifan</option>
                <option value="active">Aktif (Menginap &le; 6 Bulan)</option>
                <option value="inactive">Lama Tidak Inap (> 6 Bulan)</option>
                <option value="never">Belum Pernah Reservasi</option>
            </select>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left text-sm">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-semibold">
                        <th class="px-6 py-4 rounded-tl-2xl">Nama Tamu</th>
                        <th class="px-6 py-4">Nomor HP</th>
                        <th class="px-6 py-4">Perusahaan / Jabatan</th>
                        <th class="px-6 py-4">Terakhir Menginap</th>
                        <th class="px-6 py-4 text-center">Total Inap</th>
                        <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tamus as $tamu)
                        @php
                            $latestRes = $tamu->latestReservasi;
                            $hasRecentStay = $latestRes && (\Carbon\Carbon::parse($latestRes->tanggal_checkin)->gte(now()->subMonths(6)) || in_array($latestRes->status, ['checked_in', 'approved']));
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800 text-base">{{ $tamu->nama }}</div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    @if($tamu->kategori === 'trainee')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                            Trainee
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                            Tamu Umum
                                        </span>
                                    @endif
                                    <span class="text-xs text-gray-400">Terdaftar {{ $tamu->created_at ? $tamu->created_at->format('d/m/Y') : '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono font-medium text-gray-700">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span>{{ $tamu->no_hp }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $tamu->perusahaan ?: 'FR Academy' }}</div>
                                <div class="text-xs text-gray-500 font-medium">{{ $tamu->jabatan ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($latestRes)
                                    @php
                                        $namaKamar = $latestRes->kamar->nomor_kamar ?? '';
                                        $displayKamar = str_starts_with(strtolower($namaKamar), 'kamar') ? $namaKamar : 'Kamar ' . $namaKamar;
                                    @endphp
                                    <div class="font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($latestRes->tanggal_checkin)->format('d M Y') }}
                                        @if($namaKamar)
                                            <span class="text-xs text-gray-500 font-normal">({{ $displayKamar }})</span>
                                        @endif
                                    </div>
                                    <div class="mt-1">
                                        @if($latestRes->status === 'checked_in')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Sedang Inap
                                            </span>
                                        @elseif($latestRes->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                Disetujui
                                            </span>
                                        @elseif($latestRes->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                Selesai ({{ \Carbon\Carbon::parse($latestRes->tanggal_checkout ?? $latestRes->tanggal_checkin)->diffForHumans() }})
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-gray-500 border border-gray-200">
                                                {{ ucfirst($latestRes->status) }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-gray-400 bg-gray-50 border border-gray-200">
                                        Belum Ada Inap
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($tamu->reservasis_count > 1)
                                    <button type="button" wire:click="bukaModalRiwayat({{ $tamu->id }})" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 transition-colors cursor-pointer" title="Klik untuk lihat semua {{ $tamu->reservasis_count }} riwayat kamar">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>{{ $tamu->reservasis_count }}x Inap</span>
                                    </button>
                                @elseif($tamu->reservasis_count == 1)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                        1x Inap
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs text-gray-400 bg-gray-50 border border-gray-200">
                                        0x
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    @unless(auth()->user()->isReadOnly())
                                        <button wire:click="bukaModalEdit({{ $tamu->id }})" class="p-2 rounded-xl text-emerald-600 bg-emerald-50 hover:bg-emerald-100 transition-colors border border-emerald-100" title="Edit Data Tamu / Nomor HP">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button wire:click="konfirmasiHapus({{ $tamu->id }})" class="p-2 rounded-xl text-red-600 bg-red-50 hover:bg-red-100 transition-colors border border-red-100" title="Hapus / Bebaskan Nomor HP">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Read Only</span>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p class="font-medium">Tidak ada data tamu yang cocok dengan pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $tamus->links() }}
        </div>
    </div>

    <!-- MODAL EDIT / TAMBAH TAMU -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $isEdit ? 'Edit Data Tamu' : 'Daftarkan Tamu Baru' }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $isEdit ? 'Perbaiki nomor HP atau detail akun tamu' : 'Tambahkan akun tamu baru ke direktori' }}</p>
                </div>
                <button wire:click="tutupModal" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="simpan">
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input wire:model="nama" type="text" placeholder="Contoh: Budi Santoso" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32]">
                        @error('nama') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP (WhatsApp) <span class="text-red-500">*</span></label>
                            <input wire:model="no_hp" type="text" placeholder="Contoh: 081234567890" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32]">
                            <p class="text-[11px] text-gray-400 mt-1">Digunakan untuk login tamu.</p>
                            @error('no_hp') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Tamu <span class="text-red-500">*</span></label>
                            <select wire:model="kategori" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32] bg-white">
                                <option value="trainee">Trainee (Peserta Pelatihan)</option>
                                <option value="tamu_umum">Tamu Umum</option>
                            </select>
                            @error('kategori') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Perusahaan / PT</label>
                            <input wire:model="perusahaan" type="text" placeholder="Contoh: FR Academy" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32]">
                            @error('perusahaan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan / Batch Pelatihan</label>
                            <input wire:model="jabatan" type="text" placeholder="Contoh: FAT I 2027" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#2E7D32] focus:ring-1 focus:ring-[#2E7D32]">
                            @error('jabatan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button type="button" wire:click="tutupModal" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-[#2E7D32] hover:bg-green-800 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>{{ $isEdit ? 'Simpan Perubahan' : 'Daftarkan Tamu' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- MODAL RIWAYAT MENGINAP -->
    @if($isRiwayatModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl border border-gray-100 overflow-hidden flex flex-col max-h-[85vh]">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Riwayat Menginap</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Tamu: <strong class="text-gray-800">{{ $selectedTamu->nama }}</strong> ({{ $selectedTamu->no_hp }})</p>
                </div>
                <button wire:click="tutupModalRiwayat" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 overflow-y-auto flex-1">
                @if(count($riwayatReservasis) > 0)
                    <div class="space-y-3">
                        @foreach($riwayatReservasis as $res)
                            @php
                                $resKamar = $res->kamar->nomor_kamar ?? 'Kamar Tidak Diketahui';
                                $displayResKamar = str_starts_with(strtolower($resKamar), 'kamar') ? $resKamar : 'Kamar ' . $resKamar;
                            @endphp
                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-gray-800">{{ $displayResKamar }}</span>
                                        <span class="text-xs text-gray-500">({{ $res->kamar->tipe_kamar ?? '-' }})</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                        <span>Check-in: <strong>{{ \Carbon\Carbon::parse($res->tanggal_checkin)->format('d M Y') }}</strong></span>
                                        <span>&bull;</span>
                                        <span>Check-out: <strong>{{ $res->tanggal_checkout ? \Carbon\Carbon::parse($res->tanggal_checkout)->format('d M Y') : 'Sekarang' }}</strong></span>
                                    </div>
                                </div>
                                <div>
                                    @if($res->status === 'checked_in')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">Sedang Menginap</span>
                                    @elseif($res->status === 'completed')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">Selesai</span>
                                    @elseif($res->status === 'approved')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">Disetujui</span>
                                    @elseif($res->status === 'rejected')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">Ditolak</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">{{ ucfirst($res->status) }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 text-gray-400">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <p class="text-sm font-medium">Tamu ini belum memiliki riwayat reservasi kamar.</p>
                    </div>
                @endif
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                <button type="button" wire:click="tutupModalRiwayat" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL KONFIRMASI HAPUS (BEBASKAN NO HP) -->
    @if($isDeleteModalOpen && $tamuToDelete)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md border border-gray-100 overflow-hidden">
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Akun Tamu?</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Apakah Anda yakin ingin menghapus akun tamu <strong>{{ $tamuToDelete->nama }}</strong> ({{ $tamuToDelete->no_hp }})?
                </p>
                <div class="bg-amber-50 p-3 rounded-xl border border-amber-200 text-left text-xs text-amber-800 mb-4 leading-relaxed">
                    <p class="font-bold flex items-center gap-1 mb-1">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Informasi Pembersihan Database:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5 text-amber-700">
                        <li>Nomor HP ini akan <strong>dibebaskan</strong> sehingga dapat didaftarkan kembali jika dipakai pengguna baru.</li>
                        <li>Tamu yang dihapus tidak akan bisa login lagi ke sistem.</li>
                        <li>Riwayat pembukuan dan okupansi masa lalu <strong>tetap aman dan tidak hilang</strong>.</li>
                    </ul>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                <button type="button" wire:click="tutupModalHapus" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </button>
                <button type="button" wire:click="hapusTamu" class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    <span>Ya, Hapus &amp; Bebaskan Nomor</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
