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
                <span class="hidden sm:inline">Export Excel/PDF</span>
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
                                {{ $row['keterangan'] ?: '-' }}
                            </div>
                            @if($row['tanggal_maintenance'])
                            <div class="text-xs text-gray-400 mt-1">
                                Maint: {{ \Carbon\Carbon::parse($row['tanggal_maintenance'])->format('d M Y') }}
                            </div>
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
</div>
