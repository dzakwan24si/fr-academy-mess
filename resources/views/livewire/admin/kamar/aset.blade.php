<div class="p-6">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Inventaris Kamar {{ $kamar->nomor_kamar }}</h2>
            <p class="text-gray-500 text-sm mt-1">Tipe: {{ $kamar->tipe_kamar }} | Kapasitas: {{ $kamar->kapasitas }} Orang</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.kamar') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                &larr; Kembali
            </a>
            <button wire:click="bukaModal" class="px-4 py-2 bg-[#59A338] hover:bg-[#4d8f2f] text-white rounded-xl text-sm font-semibold transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Aset ke Kamar
            </button>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-semibold">
                        <th class="px-6 py-4 rounded-tl-2xl">Nama Barang</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4">Kondisi</th>
                        <th class="px-6 py-4">Tgl. Maintenance</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-right rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                    @forelse($kamar->asets as $aset)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $aset->nama_aset }}
                            <div class="text-xs text-gray-500 font-normal mt-0.5">{{ $aset->kategori }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $aset->pivot->jumlah }}
                        </td>
                        <td class="px-6 py-4">
                            @if($aset->pivot->kondisi == 'Baik')
                                <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-semibold tracking-wide">BAIK</span>
                            @elseif($aset->pivot->kondisi == 'Rusak Ringan')
                                <span class="px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-semibold tracking-wide">RUSAK RINGAN</span>
                            @else
                                <span class="px-2.5 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-semibold tracking-wide">RUSAK BERAT</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $aset->pivot->tanggal_maintenance ? \Carbon\Carbon::parse($aset->pivot->tanggal_maintenance)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600 truncate max-w-[200px]" title="{{ $aset->pivot->keterangan }}">
                            {{ $aset->pivot->keterangan ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="bukaModal({{ $aset->pivot->id }})" class="p-2 text-gray-400 hover:text-[#59A338] hover:bg-green-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button onclick="confirm('Keluarkan barang ini dari kamar?') || event.stopImmediatePropagation()" wire:click="hapus({{ $aset->pivot->id }}, {{ $aset->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada aset terdaftar di kamar ini</p>
                            <p class="text-gray-400 text-xs mt-1">Silakan tambahkan aset menggunakan tombol di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($asetLorong) && count($asetLorong) > 0)
    <div class="mt-8 mb-4 flex items-center justify-between relative z-10">
        <h2 class="text-xl font-bold text-gray-800">Akumulasi Aset di Dalam Kamar Lorong Ini</h2>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10 mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-semibold">
                        <th class="px-6 py-4 rounded-tl-2xl">Nama Barang</th>
                        <th class="px-6 py-4">Total Jumlah</th>
                        <th class="px-6 py-4 rounded-tr-2xl">Kondisi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                    @foreach($asetLorong as $aset)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $aset['nama_aset'] }}
                            <div class="text-xs text-gray-500 font-normal mt-0.5">{{ $aset['kategori'] }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-bold">
                            {{ $aset['jumlah'] }}
                        </td>
                        <td class="px-6 py-4">
                            @if($aset['kondisi'] == 'Baik')
                                <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-semibold tracking-wide">BAIK</span>
                            @elseif($aset['kondisi'] == 'Rusak Ringan')
                                <span class="px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs font-semibold tracking-wide">RUSAK RINGAN</span>
                            @else
                                <span class="px-2.5 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-semibold tracking-wide">RUSAK BERAT</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Modal Form -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="tutupModal"></div>
            
            <div class="relative bg-white rounded-2xl w-full max-w-md p-6 shadow-xl z-10">
                <div class="flex justify-between items-center mb-5 pb-3 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">{{ $isEdit ? 'Edit Aset Kamar' : 'Tambah Aset ke Kamar' }}</h3>
                    <button wire:click="tutupModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                    <form wire:submit.prevent="simpan" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Master Aset</label>
                            <select wire:model="aset_mess_id" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-[#59A338] focus:border-[#59A338]" {{ $isEdit ? 'disabled' : '' }}>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($masterAset as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_aset }} ({{ $item->kategori }})</option>
                                @endforeach
                            </select>
                            @error('aset_mess_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                <input wire:model="jumlah" type="number" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-[#59A338] focus:border-[#59A338]">
                                @error('jumlah') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kondisi <span class="text-red-500">*</span></label>
                                <select wire:model="kondisi" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm" required>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                    <option value="Hilang">Hilang</option>
                                </select>
                                @error('kondisi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tgl. Maintenance Selanjutnya</label>
                            <input wire:model="tanggal_maintenance" type="date" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-[#59A338] focus:border-[#59A338]">
                            @error('tanggal_maintenance') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                            <textarea wire:model="keterangan" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-[#59A338] focus:border-[#59A338]"></textarea>
                            @error('keterangan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
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
</div>
