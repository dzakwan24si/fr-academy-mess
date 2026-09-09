<div class="p-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tugas Perbaikan (Work Order)</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar tugas maintenance dari komplain tamu dan kerusakan aset.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex items-start gap-3 relative overflow-hidden group" x-data="{ show: true }" x-show="show" x-transition>
            <div class="absolute inset-y-0 left-0 w-1 bg-green-500"></div>
            <div class="p-1.5 bg-green-100 rounded-lg shrink-0 text-green-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="flex-1 pt-1 text-sm font-medium text-green-800">
                {{ session('success') }}
            </div>
            <button @click="show = false" class="text-green-600 hover:text-green-800 transition-colors p-1 rounded-lg hover:bg-green-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <h2 class="text-xl font-bold text-gray-800 mb-4">Komplain Tamu</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- KOMPLAIN TAMU (URGENT) -->
        @forelse($komplains as $komplain)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow relative">
                <!-- Red priority indicator line -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-red-500"></div>
                
                <div class="p-5 flex-1 flex flex-col gap-4">
                    <div class="flex justify-between items-start gap-2">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700 mb-2">
                                URGENT (Komplain)
                            </span>
                            <h3 class="font-bold text-gray-800 text-lg leading-tight">
                                {{ $komplain->reservasi->kamar->nomor_kamar ?? 'Unknown Kamar' }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $komplain->reservasi->tamu->nama ?? 'Tamu Unknown' }}
                            </p>
                        </div>
                        <div class="text-xs text-gray-400 whitespace-nowrap text-right">
                            {{ \Carbon\Carbon::parse($komplain->created_at)->diffForHumans() }}
                        </div>
                    </div>
                    
                    <div class="bg-red-50/50 p-3 rounded-xl border border-red-50 flex-1">
                        <p class="text-sm text-gray-700 whitespace-pre-wrap break-words">{{ $komplain->deskripsi }}</p>
                    </div>
                </div>
                
                <div class="p-4 border-t border-gray-100 bg-gray-50/50 flex justify-end shrink-0">
                    <button wire:click="bukaModalSelesai({{ $komplain->id }}, 'komplain')" 
                            class="px-5 py-2.5 w-full bg-[#59A338] hover:bg-[#4a8a2e] text-white text-sm font-bold rounded-xl transition-all shadow-sm hover:shadow active:scale-[0.98] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Tandai Selesai
                    </button>
                </div>
            </div>
        @empty
            <!-- Empty state for Komplain -->
        @endforelse
    </div>
    
    <div class="mt-4">
        {{ $komplains->links() }}
    </div>

    <!-- ASET RUSAK (ROUTINE) -->
    <h2 class="text-xl font-bold text-gray-800 mt-8 mb-4">Aset Rusak</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($asetRusak as $aset)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow relative">
                <!-- Yellow priority indicator line -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-yellow-400"></div>
                
                <div class="p-5 flex-1 flex flex-col gap-4">
                    <div class="flex justify-between items-start gap-2">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 mb-2">
                                ROUTINE (Aset)
                            </span>
                            <h3 class="font-bold text-gray-800 text-lg leading-tight">
                                {{ $aset->nomor_kamar ?? 'Unknown Kamar' }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                {{ $aset->nama_aset }}
                            </p>
                        </div>
                        <div class="text-xs text-gray-400 whitespace-nowrap text-right">
                            {{ $aset->kondisi }}
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50/50 p-3 rounded-xl border border-yellow-50 flex-1">
                        <p class="text-sm text-gray-700 whitespace-pre-wrap break-words">
                            {{ $aset->keterangan ?: 'Kerusakan rutin, perlu pengecekan.' }}
                        </p>
                    </div>
                </div>
                
                <div class="p-4 border-t border-gray-100 bg-gray-50/50 flex justify-end shrink-0">
                    <button wire:click="bukaModalSelesai({{ $aset->aset_id }}, 'aset', {{ $aset->kamar_id }})" 
                            class="px-5 py-2.5 w-full bg-[#59A338] hover:bg-[#4a8a2e] text-white text-sm font-bold rounded-xl transition-all shadow-sm hover:shadow active:scale-[0.98] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Tandai Selesai
                    </button>
                </div>
            </div>
        @empty
            <!-- Empty state for Aset -->
        @endforelse
    </div>
    
    <div class="mt-4">
        {{ $asetRusak->links() }}
    </div>
    
    @if(count($komplains) == 0 && count($asetRusak) == 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center flex flex-col items-center justify-center relative overflow-hidden group">
            <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-10 h-10 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Semua Beres!</h3>
            <p class="text-gray-500 max-w-sm">Tidak ada komplain atau aset rusak saat ini. Pak Tepung bisa bersantai sejenak.</p>
        </div>
    @endif

    <!-- MODAL PROOF OF WORK -->
    @if($isModalSelesaiOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/50 backdrop-blur-sm p-4">
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl flex flex-col max-h-full">
            
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-gray-50/50 rounded-t-2xl shrink-0">
                <h3 class="text-xl font-bold text-gray-800">
                    Konfirmasi Penyelesaian Tugas
                </h3>
                <button wire:click="tutupModalSelesai" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-xl text-sm w-8 h-8 inline-flex justify-center items-center transition-colors">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="p-5 space-y-4 overflow-y-auto">
                <div class="bg-blue-50 text-blue-800 p-4 rounded-xl text-sm border border-blue-100 flex items-start gap-3">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p>Mohon lampirkan catatan perbaikan sebagai <strong>Proof of Work (Bukti Kerja)</strong> untuk akuntabilitas operasional.</p>
                </div>

                <form wire:submit.prevent="simpanPenyelesaian" class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-800">Catatan Tindakan / Perbaikan <span class="text-red-500">*</span></label>
                        <textarea wire:model="catatanTeknisi" rows="4" 
                                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-[#59A338] focus:border-[#59A338] block w-full p-3 shadow-sm placeholder-gray-400" 
                                  placeholder="Contoh: Mengganti kapasitor AC yang terbakar..." required></textarea>
                        @error('catatanTeknisi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-800">Unggah Foto Bukti <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors relative overflow-hidden group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    @if ($fotoBukti)
                                        <img src="{{ $fotoBukti->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover opacity-60">
                                        <svg class="w-8 h-8 text-[#59A338] mb-2 relative z-10 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-sm font-bold text-[#59A338] relative z-10 drop-shadow-md">Foto Terpilih</p>
                                    @else
                                        <svg class="w-8 h-8 text-gray-400 mb-3 group-hover:text-[#59A338] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        <p class="mb-1 text-sm text-gray-500"><span class="font-bold">Klik untuk unggah</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-400">PNG, JPG, JPEG (Max. 2MB)</p>
                                    @endif
                                </div>
                                <input type="file" wire:model="fotoBukti" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        <!-- Loading State for Image Upload -->
                        <div wire:loading wire:target="fotoBukti" class="text-sm text-blue-600 mt-2 flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Mengunggah foto...
                        </div>
                        @error('fotoBukti') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            
            <!-- Modal footer -->
            <div class="flex items-center justify-end p-5 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl shrink-0 gap-3">
                <button wire:click="tutupModalSelesai" type="button" class="px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-4 focus:ring-gray-100">
                    Batal
                </button>
                <button wire:click="simpanPenyelesaian" type="button" class="px-5 py-2.5 text-sm font-bold text-white bg-[#59A338] hover:bg-[#4a8a2e] rounded-xl transition-all shadow-sm hover:shadow active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-green-100 flex items-center gap-2" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="simpanPenyelesaian">
                        <svg class="w-4 h-4 inline-block -mt-0.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan & Selesaikan
                    </span>
                    <span wire:loading wire:target="simpanPenyelesaian">
                        <svg class="animate-spin w-4 h-4 inline-block -mt-0.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
