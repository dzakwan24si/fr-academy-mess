<div class="p-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Laporan Distribusi Aset</h2>
            <p class="text-gray-500 text-sm mt-1">Pantau lokasi dan kondisi seluruh aset di Mess FR Academy.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <button wire:click="exportData" class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span >Export Excel/PDF</span>
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row gap-4 z-20 relative">
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Pilih Kamar / Lokasi</label>
            <select wire:model.live="filterKamar" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <option value="">Semua Lokasi</option>
                @foreach($semuaKamar as $k)
                    <option value="{{ $k->id }}">{{ $k->nomor_kamar }} ({{ $k->tipe_kamar }})</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kondisi Aset</label>
            <select wire:model.live="filterKondisi" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <option value="">Semua Kondisi</option>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
                <option value="Hilang">Hilang</option>
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cari Barang</label>
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Ketik nama barang..." class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-semibold">
                        <th class="px-6 py-4 rounded-tl-2xl">Lokasi / Kamar</th>
                        <th class="px-6 py-4">Nama Aset</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4">Kondisi</th>
                        <th class="px-6 py-4 rounded-tr-2xl">Catatan / Maint.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                    @forelse($laporanData as $row)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">{{ $row['kamar_nama'] }}</span>
                            <div class="text-xs text-gray-500 mt-0.5">
                                {{ $row['kamar_lokasi'] ?: '-' }} &bull; {{ $row['kamar_tipe'] }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-800">{{ $row['aset_nama'] }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $row['aset_kategori'] }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            {{ $row['jumlah'] }} unit
                        </td>
                        <td class="px-6 py-4">
                            @if($row['kondisi'] == 'Baik')
                                <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-semibold tracking-wide">BAIK</span>
                            @elseif($row['kondisi'] == 'Rusak Ringan')
                                <span class="px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-semibold tracking-wide">RUSAK RINGAN</span>
                            @elseif($row['kondisi'] == 'Rusak Berat')
                                <span class="px-2.5 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-semibold tracking-wide">RUSAK BERAT</span>
                            @else
                                <span class="px-2.5 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-semibold tracking-wide">HILANG</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-600 truncate max-w-[200px]" title="{{ $row['keterangan'] }}">
                                {{ $row['keterangan'] ?: '' }}
                            </div>
                            @if(!empty($row['catatan_perbaikan']) || !empty($row['foto_perbaikan']))
                                <button wire:click="bukaModalRiwayat({{ $row['pivot_id'] }})" class="mt-1 text-blue-600 hover:text-blue-800 font-semibold text-xs flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> 
                                    Lihat Riwayat
                                </button>
                            @elseif(empty($row['keterangan']))
                                <div class="text-gray-400 font-medium">-</div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <p class="text-gray-500 font-medium">Data laporan aset tidak ditemukan</p>
                            <p class="text-gray-400 text-xs mt-1">Coba sesuaikan filter pencarian di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $laporanData->links() }}
        </div>
    </div>

    <!-- Modal Riwayat Perbaikan -->
    @if($isModalRiwayatOpen && $detailRiwayat)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl transform transition-all flex flex-col max-h-[90vh]" @click.away="$wire.tutupModalRiwayat()">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 shrink-0 rounded-t-3xl">
                <h3 class="text-xl font-bold text-gray-900">Riwayat Maintenance Aset</h3>
                <button wire:click="tutupModalRiwayat" class="text-gray-400 hover:text-gray-700 bg-white hover:bg-gray-100 p-2 rounded-full transition-colors shadow-sm border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-6">
                <!-- Informasi Aset -->
                <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm">{{ $detailRiwayat['nama_aset'] }}</p>
                            <p class="text-xs font-semibold text-gray-500">Kamar {{ $detailRiwayat['nomor_kamar'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Perbaikan -->
                <div class="bg-blue-50/30 border border-blue-100 rounded-2xl p-4">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Detail Perbaikan</h4>
                    
                    <div class="space-y-4 text-sm">
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 text-blue-500 mt-0.5">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">Dikerjakan Oleh</p>
                                <p class="font-semibold text-gray-900">{{ $detailRiwayat['teknisi'] }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 text-blue-500 mt-0.5">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">Waktu Selesai</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $detailRiwayat['tanggal_maintenance'] ? \Carbon\Carbon::parse($detailRiwayat['tanggal_maintenance'])->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 text-blue-500 mt-0.5">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-500 text-xs">Catatan Teknisi</p>
                                <div class="font-medium text-gray-800 bg-white p-3 rounded-xl border border-blue-100/50 mt-1 whitespace-pre-wrap">
                                    {{ $detailRiwayat['catatan_perbaikan'] ?: 'Tidak ada catatan.' }}
                                </div>
                            </div>
                        </div>

                        @if($detailRiwayat['foto_perbaikan'])
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 text-blue-500 mt-0.5">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs mb-1.5">Foto Bukti</p>
                                <a href="{{ Storage::url($detailRiwayat['foto_perbaikan']) }}" target="_blank" class="block w-24 h-24 rounded-lg overflow-hidden border border-gray-200 hover:opacity-80 transition-opacity">
                                    <img src="{{ Storage::url($detailRiwayat['foto_perbaikan']) }}" class="w-full h-full object-cover" alt="Foto Perbaikan Aset">
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 rounded-b-3xl flex justify-end">
                <button wire:click="tutupModalRiwayat" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

