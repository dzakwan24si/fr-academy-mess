<div class="p-6">
    <!-- Header & Filter -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Reservasi</h1>
            <p class="text-gray-500 text-sm">Kelola pengajuan booking dan proses check-in/out tamu.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama tamu..." class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <select wire:model.live="filterStatus" class="w-full sm:w-48 bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="checked_in">Checked-in</option>
                <option value="completed">Completed</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    <!-- Floating Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">No RSV / Tgl</th>
                        <th class="px-6 py-4">Data Tamu</th>
                        <th class="px-6 py-4">Kamar</th>
                        <th class="px-6 py-4">Durasi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
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
                                    {{ $rsv->tamu->perusahaan ?? 'Personal' }} <br>
                                    <span class="italic max-w-[200px] truncate block" title="{{ $rsv->keperluan_menginap }}">"{{ $rsv->keperluan_menginap }}"</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($rsv->kamar)
                                    <div class="font-bold text-gray-800">{{ $rsv->kamar->nomor_kamar }}</div>
                                    <div class="text-xs text-gray-500">{{ $rsv->kamar->tipe_kamar }}</div>
                                @else
                                    <span class="text-gray-400 italic">Kamar Dihapus</span>
                                @endif
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
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @if($rsv->status == 'pending')
                                        <!-- Approval Buttons -->
                                        <button wire:click="setujuiBooking({{ $rsv->id }})" class="p-2 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition-colors" title="Setujui">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                        <button wire:click="bukaModalTolak({{ $rsv->id }})" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Tolak">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    @elseif($rsv->status == 'approved')
                                        <!-- Check-in Button -->
                                        <button wire:click="prosesCheckIn({{ $rsv->id }})" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition-colors text-xs shadow-sm">
                                            Proses Check-In
                                        </button>
                                    @elseif($rsv->status == 'checked_in')
                                        <!-- Check-out Button -->
                                        <button wire:click="prosesCheckOut({{ $rsv->id }})" class="px-4 py-2 rounded-lg bg-emerald-500 text-white font-bold hover:bg-emerald-600 transition-colors text-xs shadow-sm">
                                            Proses Check-Out
                                        </button>
                                    @else
                                        <!-- View Button -->
                                        <button class="p-2 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
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
</div>
