<div class="p-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Manajemen Reservasi</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola pengajuan booking dan proses check-in/out tamu.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <button wire:click="bukaModalBuat" class="flex-shrink-0 flex items-center justify-center gap-2 px-4 py-2 bg-[#59A338] hover:bg-[#4d8f2f] text-white rounded-xl text-sm font-semibold transition-colors shadow-sm w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span >Buat Reservasi</span>
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row gap-4 z-20 relative">
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Status Reservasi</label>
            <select wire:model.live="filterStatus" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="checked_in">Checked-in</option>
                <option value="completed">Completed</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tgl Check-in</label>
            <input wire:model.live="filterTanggal" type="date" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow text-gray-600">
        </div>
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kategori Tamu</label>
            <select wire:model.live="filterKategori" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <option value="">Semua Kategori</option>
                <option value="tamu_umum">Tamu Umum</option>
                <option value="trainee">Trainee</option>
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cari Tamu</label>
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Ketik nama atau no HP..." class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Floating Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-semibold">
                        <th class="px-6 py-4 rounded-tl-2xl">No RSV / Tgl</th>
                        <th class="px-6 py-4">Data Tamu</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Kamar</th>
                        <th class="px-6 py-4">Jam Tiba</th>
                        <th class="px-6 py-4">Durasi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($reservasis as $rsv)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">RSV-{{ str_pad($rsv->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-xs text-gray-500">{{ $rsv->created_at->format('d M Y, H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $rsv->tamu->nama ?? '-' }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    <span class="font-medium text-gray-700">{{ $rsv->tamu->no_hp ?? '-' }}</span><br>
                                    {{ $rsv->tamu->perusahaan ?? 'Personal' }} ({{ $rsv->tamu->jabatan ?? '-' }})<br>
                                    <span class="italic max-w-[200px] truncate block" title="{{ $rsv->keperluan_menginap }}">"{{ $rsv->keperluan_menginap }}"</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if(isset($rsv->tamu->kategori))
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full {{ $rsv->tamu->kategori == 'trainee' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $rsv->tamu->kategori == 'trainee' ? 'Trainee' : 'Tamu Umum' }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($rsv->kamar)
                                    <div class="font-bold text-gray-800">{{ $rsv->kamar->nomor_kamar }}</div>
                                    <div class="text-xs text-gray-500">{{ $rsv->kamar->tipe_kamar }}</div>
                                @else
                                    <span class="text-gray-400 italic">Kamar Dihapus</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 border border-gray-200">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="font-medium text-gray-700 text-xs">{{ $rsv->perkiraan_jam_checkin ? \Carbon\Carbon::parse($rsv->perkiraan_jam_checkin)->format('H:i') : '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($rsv->tanggal_checkin)->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">s/d {{ \Carbon\Carbon::parse($rsv->tanggal_checkout)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($rsv->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($rsv->status == 'approved')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Approved</span>
                                @elseif($rsv->status == 'checked_in')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Checked-in</span>
                                @elseif($rsv->status == 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Completed</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right relative">
                                <div class="flex justify-end items-center" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="p-2 rounded-lg bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100 hover:text-[#59A338] transition-colors" title="Aksi">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-100" 
                                         x-transition:enter-start="transform opacity-0 scale-95" 
                                         x-transition:enter-end="transform opacity-100 scale-100" 
                                         x-transition:leave="transition ease-in duration-75" 
                                         x-transition:leave-start="transform opacity-100 scale-100" 
                                         x-transition:leave-end="transform opacity-0 scale-95" 
                                         class="absolute right-6 top-10 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden" 
                                         style="display: none;">
                                        
                                        <button wire:click="bukaModalDetail({{ $rsv->id }})" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2 border-b border-gray-50">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Lihat Detail
                                        </button>
                                        
                                        @if($rsv->status == 'pending')
                                            <button wire:click="setujuiBooking({{ $rsv->id }})" class="w-full text-left px-4 py-3 text-sm text-green-700 hover:bg-green-50 flex items-center gap-2 border-b border-gray-50">
                                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Setujui Reservasi
                                            </button>
                                            <button wire:click="bukaModalTolak({{ $rsv->id }})" class="w-full text-left px-4 py-3 text-sm text-orange-700 hover:bg-orange-50 flex items-center gap-2 border-b border-gray-50">
                                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Tolak Reservasi
                                            </button>
                                        @elseif($rsv->status == 'approved')
                                            <button wire:click="prosesCheckIn({{ $rsv->id }})" class="w-full text-left px-4 py-3 text-sm text-blue-700 hover:bg-blue-50 flex items-center gap-2 border-b border-gray-50">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                                Proses Check-In
                                            </button>
                                        @elseif($rsv->status == 'checked_in')
                                            <button wire:click="bukaModalOff({{ $rsv->id }})" class="w-full text-left px-4 py-3 text-sm text-yellow-700 hover:bg-yellow-50 flex items-center gap-2 border-b border-gray-50">
                                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Off Sementara
                                            </button>
                                            <button wire:click="prosesCheckOut({{ $rsv->id }})" class="w-full text-left px-4 py-3 text-sm text-emerald-700 hover:bg-emerald-50 flex items-center gap-2 border-b border-gray-50">
                                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                                Proses Check-Out
                                            </button>
                                        @endif

                                        <button wire:click="bukaModalEdit({{ $rsv->id }})" class="w-full text-left px-4 py-3 text-sm text-blue-600 hover:bg-blue-50 flex items-center gap-2 border-b border-gray-50">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Edit Data
                                        </button>
                                        
                                        <button wire:click="konfirmasiHapus({{ $rsv->id }})" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus Reservasi
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-base font-medium">Tidak ada data reservasi ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reservasis->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                {{ $reservasis->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Detail Reservasi -->
    @if($isModalDetailOpen && $detailReservasi)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="tutupModalDetail"></div>
            
            <div class="relative bg-white rounded-2xl w-full max-w-lg shadow-xl z-10 flex flex-col max-h-[90vh]">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                    <h3 class="text-lg font-bold text-gray-900">Detail Reservasi (RSV-{{ str_pad($detailReservasi->id, 4, '0', STR_PAD_LEFT) }})</h3>
                    <button wire:click="tutupModalDetail" class="text-gray-400 hover:text-gray-600 p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 overflow-y-auto">
                    <!-- Data Tamu -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Informasi Tamu</h4>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Nama Lengkap</p>
                                    <p class="font-semibold text-gray-800">{{ $detailReservasi->tamu->nama ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Nomor Handphone</p>
                                    <p class="font-semibold text-gray-800">{{ $detailReservasi->tamu->no_hp ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Perusahaan</p>
                                    <p class="font-semibold text-gray-800">{{ $detailReservasi->tamu->perusahaan ?? 'Personal' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Jabatan</p>
                                    <p class="font-semibold text-gray-800">{{ $detailReservasi->tamu->jabatan ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Kategori Tamu</p>
                                    <p class="font-semibold text-gray-800">{{ isset($detailReservasi->tamu->kategori) ? ($detailReservasi->tamu->kategori == 'trainee' ? 'Trainee' : 'Tamu Umum') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Reservasi -->
                    <div>
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Detail Menginap</h4>
                        <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-xs text-blue-600/80">Check-In</p>
                                    <p class="font-semibold text-blue-900">{{ \Carbon\Carbon::parse($detailReservasi->tanggal_checkin)->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-600/80">Check-Out</p>
                                    <p class="font-semibold text-blue-900">{{ \Carbon\Carbon::parse($detailReservasi->tanggal_checkout)->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-600/80">Kamar</p>
                                    <p class="font-semibold text-blue-900">{{ $detailReservasi->kamar->nomor_kamar ?? 'Belum Ditentukan' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-600/80">Jam Tiba</p>
                                    <p class="font-semibold text-blue-900">{{ $detailReservasi->perkiraan_jam_checkin ? \Carbon\Carbon::parse($detailReservasi->perkiraan_jam_checkin)->format('H:i') . ' WIB' : '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-600/80">Status</p>
                                    <p class="font-semibold text-blue-900 capitalize">{{ str_replace('_', ' ', $detailReservasi->status) }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-blue-600/80">Keperluan Menginap</p>
                                <p class="font-medium text-blue-900">{{ $detailReservasi->keperluan_menginap }}</p>
                            </div>
                            
                            @if($detailReservasi->status == 'rejected' && $detailReservasi->alasan_penolakan)
                                <div class="mt-4 pt-4 border-t border-red-200">
                                    <p class="text-xs text-red-600/80 font-bold">Alasan Penolakan</p>
                                    <p class="font-medium text-red-900">{{ $detailReservasi->alasan_penolakan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Modal Tolak Reservasi -->
    @if($isModalTolakOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="tutupModalTolak"></div>
            
            <div class="relative bg-white rounded-2xl w-full max-w-md p-6 shadow-xl z-10">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Tolak Reservasi</h3>
                
                <form wire:submit.prevent="tolakBooking">
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan</label>
                        <textarea wire:model="alasanTolak" rows="4" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm resize-none" placeholder="Tulis alasan kenapa reservasi ini ditolak..." required></textarea>
                        @error('alasanTolak') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="tutupModalTolak" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors shadow-sm">
                            <span wire:loading.remove wire:target="tolakBooking">Konfirmasi Tolak</span>
                            <span wire:loading wire:target="tolakBooking">Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Walk-in Reservation -->
    @if($isModalBuatOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="tutupModalBuat"></div>
            
            <div class="relative bg-white rounded-2xl w-full max-w-4xl shadow-xl z-10 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Walk-in Reservation</h3>
                        <p class="text-xs text-gray-500 mt-1">Pemesanan kamar manual oleh Admin.</p>
                    </div>
                    <button wire:click="tutupModalBuat" class="text-gray-400 hover:text-gray-600 p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <form wire:submit.prevent="simpanWalkIn" class="flex flex-col flex-1 overflow-hidden">
                    <div class="p-6 overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- Kolom Kiri: Data Tamu -->
                            <div class="flex flex-col gap-5">
                                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                                    <div class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                                    <h4 class="font-semibold text-gray-800">Informasi Tamu</h4>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="form_nama" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" placeholder="Nama sesuai identitas" required>
                                    @error('form_nama') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Handphone <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="form_no_hp" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" placeholder="Contoh: 081234567890" required>
                                    <p class="text-[11px] text-gray-400 mt-1">Sistem akan menautkan ke tamu lama jika no HP cocok.</p>
                                    @error('form_no_hp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Perusahaan / Instansi <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="form_perusahaan" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" placeholder="Nama PT / Instansi" required>
                                    @error('form_perusahaan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="form_jabatan" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" placeholder="Jabatan Tamu" required>
                                        @error('form_jabatan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                        <select wire:model="form_kategori" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                            <option value="tamu_umum">Tamu Umum</option>
                                            <option value="trainee">Trainee</option>
                                        </select>
                                        @error('form_kategori') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Data Reservasi -->
                            <div class="flex flex-col gap-5">
                                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                                    <div class="w-6 h-6 rounded bg-green-100 text-green-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                                    <h4 class="font-semibold text-gray-800">Detail Pemesanan</h4>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Check-in <span class="text-red-500">*</span></label>
                                        <input type="date" wire:model="form_tgl_checkin" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                        @error('form_tgl_checkin') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Tiba <span class="text-red-500">*</span></label>
                                        <input type="time" wire:model="form_jam_checkin" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                        @error('form_jam_checkin') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Check-out <span class="text-red-500">*</span></label>
                                    <input type="date" wire:model="form_tgl_checkout" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                    @error('form_tgl_checkout') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Kamar (Opsional)</label>
                                    <select wire:model="form_kamar_id" id="form_kamar_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm bg-gray-50">
                                        <option value="">-- Alokasikan Nanti --</option>
                                        @foreach($availableRooms as $kamar)
                                            <option value="{{ $kamar->id }}">
                                                {{ $kamar->nomor_kamar }} ({{ str_replace([' Twin Bed', ' Single Bed'], '', $kamar->tipe_kamar) }}) - Tersedia ({{ $kamar->active_guests_count ?? 0 }}/{{ $kamar->kapasitas }} terisi)
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-[11px] text-gray-400 mt-1">Hanya menampilkan kamar yang masih memiliki sisa kapasitas.</p>
                                    @error('form_kamar_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Keperluan Menginap <span class="text-red-500">*</span></label>
                                    <textarea wire:model="form_keperluan" rows="3" class="w-full h-24 border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm resize-none" placeholder="Contoh: Kunjungan VIP, Pelatihan Khusus..." required></textarea>
                                    @error('form_keperluan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
                        <button type="button" wire:click="tutupModalBuat" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-white transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#2E7D32] text-white font-semibold hover:bg-green-700 transition-colors shadow-sm flex items-center gap-2">
                            <span wire:loading.remove wire:target="simpanWalkIn">Simpan Reservasi</span>
                            <span wire:loading wire:target="simpanWalkIn">Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Off Sementara -->
    @if($isModalOffOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="tutupModalOff"></div>
            
            <div class="relative bg-white rounded-2xl w-full max-w-md p-6 shadow-xl z-10">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Pindah Status: Off Sementara</h3>
                <p class="text-sm text-gray-500 mb-4">Reservasi saat ini akan diselesaikan, dan kamar akan ditandai kotor. Sistem akan otomatis membooking ulang kamar ini untuk tanggal kembali trainee.</p>
                
                <form wire:submit.prevent="simpanOffSementara">
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kembali (Check-in Ulang)</label>
                        <input type="date" wire:model.live="tanggalKembali" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-sm" required>
                        @error('tanggalKembali') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai (Check-out Akhir)</label>
                        <input type="date" wire:model="tanggalCheckoutBaru" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-500 focus:border-transparent text-sm" required>
                        @error('tanggalCheckoutBaru') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        <p class="text-xs text-gray-500 mt-1">Otomatis mengikuti check-out lama kecuali sudah terlewat.</p>
                    </div>
                    
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="tutupModalOff" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-yellow-500 text-white font-semibold hover:bg-yellow-600 transition-colors shadow-sm">
                            <span wire:loading.remove wire:target="simpanOffSementara">Konfirmasi Off</span>
                            <span wire:loading wire:target="simpanOffSementara">Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    @endif

    <!-- Modal Edit Reservasi -->
    @if($isModalEditOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="tutupModalEdit"></div>
            
            <div class="relative bg-white rounded-2xl w-full max-w-4xl shadow-xl z-10 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Edit Data Reservasi</h3>
                        <p class="text-xs text-gray-500 mt-1">Perbarui informasi tamu atau detail reservasi.</p>
                    </div>
                    <button wire:click="tutupModalEdit" class="text-gray-400 hover:text-gray-600 p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <form wire:submit.prevent="simpanEdit" class="flex flex-col flex-1 overflow-hidden">
                    <div class="p-6 overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- Kolom Kiri: Data Tamu -->
                            <div class="flex flex-col gap-5">
                                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                                    <div class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                                    <h4 class="font-semibold text-gray-800">Informasi Tamu</h4>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="edit_nama" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                    @error('edit_nama') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Handphone <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="edit_no_hp" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                    @error('edit_no_hp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Perusahaan / Instansi <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="edit_perusahaan" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                    @error('edit_perusahaan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="edit_jabatan" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                        @error('edit_jabatan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                        <select wire:model="edit_kategori" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                            <option value="tamu_umum">Tamu Umum</option>
                                            <option value="trainee">Trainee</option>
                                        </select>
                                        @error('edit_kategori') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Data Reservasi -->
                            <div class="flex flex-col gap-5">
                                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                                    <div class="w-6 h-6 rounded bg-green-100 text-green-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                                    <h4 class="font-semibold text-gray-800">Detail Pemesanan</h4>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Check-in <span class="text-red-500">*</span></label>
                                        <input type="date" wire:model="edit_tgl_checkin" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                        @error('edit_tgl_checkin') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Tiba</label>
                                        <input type="time" wire:model="edit_jam_checkin" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm">
                                        @error('edit_jam_checkin') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Check-out <span class="text-red-500">*</span></label>
                                    <input type="date" wire:model="edit_tgl_checkout" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                    @error('edit_tgl_checkout') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Kamar (Opsional)</label>
                                    <select wire:model="edit_kamar_id" id="edit_kamar_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm bg-gray-50">
                                        <option value="">-- Alokasikan Nanti --</option>
                                        <!-- Include currently assigned room even if it's full, just to show it's selected -->
                                        @foreach(\App\Models\Kamar::where('tipe_kamar', '!=', 'Fasilitas Umum')->where('nomor_kamar', 'not like', 'Lorong%')->get() as $kamar)
                                            @php
                                                $activeGuests = \App\Models\Reservasi::where('kamar_id', $kamar->id)
                                                    ->whereIn('status', ['approved', 'checked_in'])
                                                    ->where('id', '!=', $edit_reservasi_id)
                                                    ->count();
                                                $isAvailable = $activeGuests < $kamar->kapasitas;
                                            @endphp
                                            @if($isAvailable || $kamar->id == $edit_kamar_id)
                                                <option value="{{ $kamar->id }}">
                                                    {{ $kamar->nomor_kamar }} ({{ str_replace([' Twin Bed', ' Single Bed'], '', $kamar->tipe_kamar) }}) - ({{ $activeGuests }}/{{ $kamar->kapasitas }} terisi)
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('edit_kamar_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Keperluan Menginap <span class="text-red-500">*</span></label>
                                    <textarea wire:model="edit_keperluan" rows="3" class="w-full h-24 border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm resize-none" required></textarea>
                                    @error('edit_keperluan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
                        <button type="button" wire:click="tutupModalEdit" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-white transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                            <span wire:loading.remove wire:target="simpanEdit">Simpan Perubahan</span>
                            <span wire:loading wire:target="simpanEdit">Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    @if($isModalHapusOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="tutupModalHapus"></div>
            
            <div class="relative bg-white rounded-2xl w-full max-w-sm p-6 shadow-xl z-10 text-center">
                <div class="w-16 h-16 rounded-full bg-red-100 text-red-500 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Reservasi?</h3>
                <p class="text-sm text-gray-500 mb-6">Tindakan ini tidak dapat dibatalkan. Reservasi akan dihapus secara permanen dari sistem.</p>
                
                <div class="flex justify-center gap-3">
                    <button type="button" wire:click="tutupModalHapus" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="button" wire:click="hapusReservasi" class="px-5 py-2.5 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors shadow-sm">
                        <span wire:loading.remove wire:target="hapusReservasi">Ya, Hapus!</span>
                        <span wire:loading wire:target="hapusReservasi">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

