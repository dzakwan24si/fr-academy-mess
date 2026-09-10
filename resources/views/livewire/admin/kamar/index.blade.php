<div class="p-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Manajemen Kamar</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola data kamar, kapasitas, dan pantau status kebersihan.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <button wire:click="bukaModal" class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-[#59A338] hover:bg-[#4d8f2f] text-white rounded-xl text-sm font-semibold transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span class="hidden sm:inline">Tambah Kamar</span>
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row gap-4 z-20 relative">
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Status Kamar</label>
            <select wire:model.live="filterStatus" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <option value="">Semua Status</option>
                <option value="kosong_bersih">Kosong Bersih</option>
                <option value="kosong_kotor">Kosong Kotor</option>
                <option value="terisi">Terisi</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cari Kamar</label>
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Ketik nomor kamar..." class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
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
                        <th class="px-6 py-4 rounded-tl-2xl">Kamar</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4">Tipe & Kapasitas</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($kamars as $kamar)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800 text-lg">{{ $kamar->nomor_kamar }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 font-medium">{{ $kamar->lokasi ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $kamar->tipe_kamar }}</div>
                                <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    Maks. {{ $kamar->kapasitas }} Orang
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($kamar->status == 'kosong_bersih')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">Kosong & Bersih</span>
                                @elseif($kamar->status == 'kosong_kotor')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">Kosong (Kotor)</span>
                                @elseif($kamar->status == 'terisi')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">Terisi</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">Maintenance</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.kamar.aset', $kamar->id) }}" class="px-3 py-1.5 bg-[#E8F5E9] text-[#59A338] hover:bg-[#59A338] hover:text-white rounded-lg text-xs font-semibold transition-colors flex items-center gap-1" title="Lihat Aset Kamar">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        Aset
                                    </a>
                                    <button wire:click="bukaModal({{ $kamar->id }})" class="p-2 text-gray-400 hover:text-[#59A338] hover:bg-green-50 rounded-lg transition-colors" title="Edit Kamar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:confirm="Apakah Anda yakin ingin menghapus kamar ini? Data yang terkait mungkin akan hilang." wire:click="hapus({{ $kamar->id }})" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Hapus Kamar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <p class="text-base font-medium">Tidak ada data kamar ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kamars->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                {{ $kamars->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Form Kamar -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="tutupModal"></div>
            
            <div class="relative bg-white rounded-2xl w-full max-w-md p-6 shadow-xl z-10">
                <div class="flex justify-between items-center mb-5 pb-3 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">{{ $isEdit ? 'Edit Kamar' : 'Tambah Kamar Baru' }}</h3>
                    <button wire:click="tutupModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form wire:submit.prevent="simpan">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Kamar <span class="text-red-500">*</span></label>
                            <input wire:model="nomor_kamar" type="text" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" placeholder="Contoh: Kamar 101, VIP-01" required>
                            @error('nomor_kamar') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi Kamar</label>
                            <input wire:model="lokasi" type="text" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" placeholder="Contoh: Lorong 1, Gedung Utama">
                            @error('lokasi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Kamar <span class="text-red-500">*</span></label>
                            <select wire:model="tipe_kamar" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                <option value="Reguler Twin Bed">Reguler Twin Bed</option>
                                <option value="Reguler Single Bed">Reguler Single Bed</option>
                                <option value="Executive Twin Bed">Executive Twin Bed</option>
                                <option value="Executive Single Bed">Executive Single Bed</option>
                            </select>
                            @error('tipe_kamar') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kapasitas Orang <span class="text-red-500">*</span></label>
                            <input wire:model="kapasitas" type="number" min="1" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                            @error('kapasitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Status Kamar <span class="text-red-500">*</span></label>
                            <select wire:model="status" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                <option value="kosong_bersih">Kosong & Bersih (Tersedia)</option>
                                <option value="kosong_kotor">Kosong (Kotor)</option>
                                <option value="terisi">Terisi (Sedang Dipakai)</option>
                                <option value="maintenance">Maintenance / Perbaikan</option>
                            </select>
                            @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" wire:click="tutupModal" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#59A338] text-white font-semibold hover:bg-[#4d8c2f] transition-colors shadow-sm">
                            <span wire:loading.remove wire:target="simpan">Simpan Data</span>
                            <span wire:loading wire:target="simpan">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
