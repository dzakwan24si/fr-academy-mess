<div class="p-6 md:p-8 max-w-7xl mx-auto space-y-6 md:space-y-8 min-h-screen">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Komplain Fasilitas</h1>
            <p class="text-gray-500 mt-2 font-medium">Pantau dan kelola laporan kerusakan dari tamu</p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filters & Search -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col md:flex-row gap-4 justify-between items-center relative z-20">
        <div class="w-full md:w-1/3 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari Tamu atau Kamar..." class="pl-11 w-full bg-gray-50 border-transparent focus:bg-white focus:border-[#2E7D32] focus:ring-2 focus:ring-[#2E7D32]/20 rounded-xl py-2.5 text-sm transition-all">
        </div>
        
        <div class="w-full md:w-auto flex gap-3">
            <select wire:model.live="filterStatus" class="w-full md:w-48 bg-gray-50 border-transparent focus:bg-white focus:border-[#2E7D32] focus:ring-2 focus:ring-[#2E7D32]/20 rounded-xl py-2.5 px-4 text-sm font-medium text-gray-600 transition-all cursor-pointer">
                <option value="">Semua Status</option>
                <option value="dilaporkan">Dilaporkan</option>
                <option value="diproses">Sedang Diproses</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider font-bold">
                        <th class="px-6 py-4 rounded-tl-2xl">Waktu & Tamu</th>
                        <th class="px-6 py-4">Kamar</th>
                        <th class="px-6 py-4">Masalah</th>
                        <th class="px-6 py-4">Status & Teknisi</th>
                        <th class="px-6 py-4 text-right rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($komplains as $komplain)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $komplain->reservasi->tamu->nama }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $komplain->created_at->format('d M Y, H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 font-bold border border-gray-200">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $komplain->reservasi->kamar->nomor_kamar ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs truncate text-gray-700 font-medium" title="{{ $komplain->deskripsi }}">
                                    {{ Str::limit($komplain->deskripsi, 40) }}
                                </div>
                                @if($komplain->foto_bukti)
                                    <a href="{{ Storage::url($komplain->foto_bukti) }}" target="_blank" class="text-xs text-orange-500 font-bold hover:underline mt-1 inline-flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Lihat Foto
                                    </a>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1.5 items-start">
                                    @if($komplain->status_perbaikan == 'dilaporkan')
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold shadow-sm">Dilaporkan</span>
                                    @elseif($komplain->status_perbaikan == 'diproses')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold shadow-sm">Diproses</span>
                                    @else
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold shadow-sm">Selesai</span>
                                    @endif

                                    @if($komplain->teknisi_id)
                                        <span class="text-[11px] font-semibold text-gray-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            {{ explode(' ', $komplain->teknisi->name)[0] }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="bukaModalProses({{ $komplain->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition-colors tooltip" data-tip="Tindak Lanjut">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="hapus({{ $komplain->id }})" wire:confirm="Hapus data komplain ini?" class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition-colors tooltip" data-tip="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-base font-medium text-gray-600">Tidak ada komplain ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($komplains->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $komplains->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Proses Tindak Lanjut -->
    @if($isModalOpen && $komplainDetail)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl transform transition-all overflow-hidden" @click.away="$wire.tutupModal()">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-900">Tindak Lanjut Komplain</h3>
                <button wire:click="tutupModal" class="text-gray-400 hover:text-gray-700 bg-white hover:bg-gray-100 p-2 rounded-full transition-colors shadow-sm border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <!-- Info Tamu & Masalah -->
                <div class="bg-orange-50/50 border border-orange-100 rounded-2xl p-4 mb-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-lg">
                            {{ substr($komplainDetail->reservasi->tamu->nama, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $komplainDetail->reservasi->tamu->nama }}</p>
                            <p class="text-xs font-semibold text-gray-500">Kamar {{ $komplainDetail->reservasi->kamar->nomor_kamar }}</p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-700 bg-white p-3 rounded-xl border border-orange-100/50 font-medium">
                        "{{ $komplainDetail->deskripsi }}"
                    </div>
                </div>

                <form wire:submit.prevent="simpanProses" class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Ubah Status Perbaikan <span class="text-red-500">*</span></label>
                        <select wire:model="status_perbaikan" class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-[#2E7D32] focus:ring-2 focus:ring-[#2E7D32]/20 rounded-xl px-4 py-3 text-sm transition-shadow cursor-pointer" required>
                            <option value="dilaporkan">Dilaporkan (Menunggu)</option>
                            <option value="diproses">Sedang Diproses / Diperbaiki</option>
                            <option value="selesai">Selesai</option>
                        </select>
                        @error('status_perbaikan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Tugaskan Teknisi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <select wire:model="teknisi_id" class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-[#2E7D32] focus:ring-2 focus:ring-[#2E7D32]/20 rounded-xl px-4 py-3 text-sm transition-shadow cursor-pointer">
                            <option value="">-- Pilih Teknisi --</option>
                            @foreach($teknisis as $teknisi)
                                <option value="{{ $teknisi->id }}">{{ $teknisi->name }}</option>
                            @endforeach
                        </select>
                        @error('teknisi_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#2E7D32] hover:bg-[#1b5e20] focus:outline-none focus:ring-4 focus:ring-[#2E7D32]/30 transition-all">
                            <span wire:loading.remove wire:target="simpanProses">Simpan Tindak Lanjut</span>
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
