<div class="p-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Manajemen Laundry</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola permintaan cuci pakaian dari tamu mess.</p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row gap-4 z-20 relative">
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Status Laundry</label>
            <select wire:model.live="filterStatus" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <option value="">Semua Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="diproses">Sedang Diproses</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cari Tamu / Kamar</label>
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Ketik nama atau kamar..." class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-semibold">
                        <th class="px-6 py-4 rounded-tl-2xl">Tamu & Kamar</th>
                        <th class="px-6 py-4">Waktu Request</th>
                        <th class="px-6 py-4">Total Item</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($laundries as $laundry)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $laundry->reservasi->tamu->nama }}</div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-1 font-semibold">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    Kamar {{ $laundry->reservasi->kamar->nomor_kamar ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($laundry->tanggal_request)->format('d M Y') }}<br>
                                <span class="text-xs text-gray-400">{{ $laundry->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-teal-50 text-teal-700 font-bold border border-teal-100">
                                    {{ $laundry->detailLaundries->sum('jumlah') }} pcs
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($laundry->status == 'menunggu')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold shadow-sm">Menunggu</span>
                                @elseif($laundry->status == 'diproses')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold shadow-sm">Diproses</span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold shadow-sm">Selesai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="bukaModalProses({{ $laundry->id }})" class="p-2 text-teal-600 hover:bg-teal-50 rounded-xl transition-colors tooltip" data-tip="Lihat & Proses">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <button wire:click="hapus({{ $laundry->id }})" wire:confirm="Hapus data request laundry ini?" class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition-colors tooltip" data-tip="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2" stroke-width="2"/><circle cx="12" cy="14" r="4" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M8 6h8"/></svg>
                                <p class="text-base font-medium text-gray-600">Tidak ada request laundry ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($laundries->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $laundries->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Proses Tindak Lanjut -->
    @if($isModalOpen && $laundryDetail)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl transform transition-all overflow-hidden" @click.away="$wire.tutupModal()">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-900">Detail Request Laundry</h3>
                <button wire:click="tutupModal" class="text-gray-400 hover:text-gray-700 bg-white hover:bg-gray-100 p-2 rounded-full transition-colors shadow-sm border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <!-- Info Tamu & Item -->
                <div class="bg-teal-50/50 border border-teal-100 rounded-2xl p-4 mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center font-bold text-lg">
                            {{ substr($laundryDetail->reservasi->tamu->nama, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $laundryDetail->reservasi->tamu->nama }}</p>
                            <p class="text-xs font-semibold text-gray-500">Kamar {{ $laundryDetail->reservasi->kamar->nomor_kamar }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl border border-teal-100 overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-teal-50 text-teal-700 text-xs uppercase font-bold">
                                <tr>
                                    <th class="px-4 py-2 text-left">Pakaian</th>
                                    <th class="px-4 py-2 text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-teal-50">
                                @foreach($laundryDetail->detailLaundries as $detail)
                                    <tr>
                                        <td class="px-4 py-2 text-gray-700 font-medium">{{ $detail->item_pakaian }}</td>
                                        <td class="px-4 py-2 text-right font-bold text-gray-900">{{ $detail->jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 border-t border-teal-100 font-bold">
                                <tr>
                                    <td class="px-4 py-2 text-left text-gray-600">Total Keseluruhan</td>
                                    <td class="px-4 py-2 text-right text-teal-600 text-base">{{ $laundryDetail->detailLaundries->sum('jumlah') }} pcs</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <form wire:submit.prevent="simpanProses" class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Update Status Laundry <span class="text-red-500">*</span></label>
                        <select wire:model="status" class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-[#2E7D32] focus:ring-2 focus:ring-[#2E7D32]/20 rounded-xl px-4 py-3 text-sm transition-shadow cursor-pointer" required>
                            <option value="menunggu">Menunggu Dijemput / Diproses</option>
                            <option value="diproses">Sedang Dicuci (Diproses)</option>
                            <option value="selesai">Selesai (Siap Diantar)</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#2E7D32] hover:bg-[#1b5e20] focus:outline-none focus:ring-4 focus:ring-[#2E7D32]/30 transition-all">
                            <span wire:loading.remove wire:target="simpanProses">Simpan Perubahan</span>
                            <span wire:loading wire:target="simpanProses" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
