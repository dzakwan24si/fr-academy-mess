<div class="p-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Katalog Aset Mess</h2>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari aset..." 
                    class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-all shadow-sm">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <button wire:click="bukaModal" class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-[#59A338] hover:bg-[#4d8f2f] text-white rounded-xl text-sm font-semibold transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span class="hidden sm:inline">Tambah Aset</span>
            </button>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Barang/Aset</th>
                        <th class="px-6 py-4 text-center">Kondisi Baik</th>
                        <th class="px-6 py-4 text-center">Rusak</th>
                        <th class="px-6 py-4 text-center">Hilang</th>
                        <th class="px-6 py-4 text-center">Total</th>
                        <th class="px-6 py-4">Kategori Aset</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                    @forelse($asets as $aset)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            {{ $loop->iteration + $asets->firstItem() - 1 }}
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800 text-sm">
                            {{ $aset->nama_aset }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($aset->total_baik > 0)
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded font-semibold">{{ $aset->total_baik }}</span>
                            @else
                                <span class="text-gray-400">0</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($aset->total_rusak > 0)
                                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded font-semibold">{{ $aset->total_rusak }}</span>
                            @else
                                <span class="text-gray-400">0</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($aset->total_hilang > 0)
                                <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded font-semibold">{{ $aset->total_hilang }}</span>
                            @else
                                <span class="text-gray-400">0</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-gray-800">{{ $aset->total_distribusi }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                {{ $aset->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="showDetail({{ $aset->id }})" class="p-1.5 text-blue-500 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button wire:click="bukaModal({{ $aset->id }})" class="p-1.5 text-gray-400 hover:bg-orange-50 hover:text-orange-500 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button onclick="confirm('Yakin ingin menghapus aset ini?') || event.stopImmediatePropagation()" wire:click="hapus({{ $aset->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <p class="text-base font-medium">Tidak ada data aset ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($asets->hasPages())
        <div class="p-4 border-t border-gray-100 bg-gray-50/50">
            {{ $asets->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Form -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="tutupModal"></div>
            
            <div class="relative bg-white rounded-2xl w-full max-w-md p-6 shadow-xl z-10">
                <div class="flex justify-between items-center mb-5 pb-3 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">{{ $isEdit ? 'Edit Aset' : 'Tambah Aset' }}</h3>
                    <button wire:click="tutupModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                    <form wire:submit.prevent="simpan" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Aset</label>
                            <input wire:model="nama_aset" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-[#59A338] focus:border-[#59A338]" placeholder="Misal: AC Sharp 1/2 PK">
                            @error('nama_aset') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select wire:model="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-[#59A338] focus:border-[#59A338]">
                                <option value="Elektronik">Elektronik</option>
                                <option value="Furnitur">Furnitur</option>
                                <option value="Linen & Kamar Mandi">Linen & Kamar Mandi</option>
                                <option value="Peralatan">Peralatan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('kategori') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-8 flex justify-end gap-3">
                            <button type="button" wire:click="tutupModal" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#59A338] text-white font-semibold hover:bg-[#4d8c2f] transition-colors shadow-sm">
                                <span wire:loading.remove wire:target="simpan">Simpan</span>
                                <span wire:loading wire:target="simpan">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    @endif

    <!-- Modal Detail Aset -->
    @if($isDetailModalOpen && $selectedAset)
    <div class="fixed inset-0 z-[100] flex items-center justify-center overflow-hidden p-4 sm:p-6" wire:transition.opacity>
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" wire:click="closeDetailModal"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-full flex flex-col overflow-hidden z-10">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50 shrink-0">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Detail Distribusi: {{ $selectedAset->nama_aset }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Menampilkan seluruh lokasi ruangan yang menyimpan aset ini</p>
                </div>
                <button wire:click="closeDetailModal" class="text-gray-400 hover:text-red-500 transition-colors p-2 hover:bg-red-50 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto flex-1 p-6 bg-white">
                @if($selectedAset->kamars->count() > 0)
                    <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-3">Nama Ruangan</th>
                                    <th class="px-6 py-3">Lokasi (Lorong/Gedung)</th>
                                    <th class="px-6 py-3">Kondisi</th>
                                    <th class="px-6 py-3 text-center">Jumlah</th>
                                    <th class="px-6 py-3">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($selectedAset->kamars as $kamar)
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="px-6 py-3 font-semibold text-gray-800">{{ $kamar->nomor_kamar }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $kamar->lokasi ?: '-' }}</td>
                                        <td class="px-6 py-3">
                                            @if($kamar->pivot->kondisi == 'Baik')
                                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-semibold">Baik</span>
                                            @elseif(in_array($kamar->pivot->kondisi, ['Rusak Ringan', 'Rusak Berat']))
                                                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold">{{ $kamar->pivot->kondisi }}</span>
                                            @elseif($kamar->pivot->kondisi == 'Hilang')
                                                <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs font-semibold">Hilang</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 text-center font-bold text-gray-800">{{ $kamar->pivot->jumlah }}</td>
                                        <td class="px-6 py-3 text-gray-500 text-xs truncate max-w-[150px]" title="{{ $kamar->pivot->keterangan }}">{{ $kamar->pivot->keterangan ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Aset ini belum didistribusikan ke ruangan mana pun.</p>
                    </div>
                @endif
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end shrink-0">
                <button wire:click="closeDetailModal" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl font-medium transition-colors text-sm shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
