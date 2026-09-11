<div class="p-4 sm:p-6 pb-24">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Tugas Kebersihan</h1>
        <p class="text-gray-500 text-sm mt-1">Daftar kamar kotor yang perlu segera dibersihkan.</p>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($kamars as $kamar)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="absolute top-0 right-0 p-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                        Kosong Kotor
                    </span>
                </div>
                
                <h3 class="text-2xl font-black text-gray-800 mb-1">{{ $kamar->nomor_kamar }}</h3>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-6 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $kamar->lokasi ?: 'Lokasi Tidak Ditentukan' }}
                </div>
                
                <div class="mt-auto pt-4 border-t border-gray-100">
                    <button wire:click="bukaModalSelesai({{ $kamar->id }}, '{{ $kamar->nomor_kamar }}')" class="w-full bg-[#59A338] hover:bg-[#4d8c2f] text-white font-bold py-3 px-4 rounded-xl shadow-sm hover:shadow transition-all flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tandai Bersih
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 bg-white rounded-2xl p-8 border border-gray-100 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-green-50 text-[#59A338] rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Semua Kamar Bersih!</h3>
                <p class="text-sm text-gray-500">Tidak ada kamar kotor yang perlu dibersihkan saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Konfirmasi Selesai & Upload Foto -->
    @if($isModalSelesaiOpen)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 pb-0">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="tutupModalSelesai"></div>
            
            <div class="relative bg-white w-full sm:w-auto sm:min-w-[400px] sm:max-w-md rounded-t-3xl sm:rounded-3xl p-6 shadow-2xl z-10 slide-up sm:animate-none">
                <!-- Mobile Handle -->
                <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-6 sm:hidden"></div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 leading-tight">Selesaikan Pembersihan</h3>
                    <p class="text-sm text-gray-500 mt-1">Kamar <span class="font-bold text-gray-700">{{ $kamarNomorAktif }}</span> akan ditandai sebagai Kosong & Bersih.</p>
                </div>

                <form wire:submit.prevent="simpanPenyelesaian">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Pembersihan (Opsional)</label>
                        <textarea wire:model="catatanKebersihan" rows="2" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm resize-none" placeholder="Misal: Keset sudah diganti baru, atau ada kerusakan kran air..."></textarea>
                        @error('catatanKebersihan')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Foto Bukti (Opsional)</label>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-[#59A338] hover:bg-green-50/50 transition-colors relative cursor-pointer overflow-hidden" onclick="document.getElementById('fotoUpload').click()">
                            <div class="space-y-2 text-center {{ $fotoBukti ? 'hidden' : 'block' }}">
                                <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <div class="text-sm text-gray-600">
                                    <span class="font-semibold text-[#59A338]">Sentuh untuk upload</span> foto
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                            </div>
                            
                            @if($fotoBukti)
                                <div class="absolute inset-0 w-full h-full p-2">
                                    <img src="{{ $fotoBukti->temporaryUrl() }}" class="w-full h-full object-contain rounded-lg">
                                </div>
                            @endif
                        </div>
                        <input id="fotoUpload" type="file" wire:model="fotoBukti" class="hidden" accept="image/*" capture="environment">
                        
                        @error('fotoBukti')
                            <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row gap-3 mt-8">
                        <button type="button" wire:click="tutupModalSelesai" class="w-full px-5 py-3.5 sm:py-2.5 rounded-xl border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="w-full px-5 py-3.5 sm:py-2.5 rounded-xl bg-[#59A338] text-white font-bold hover:bg-[#4d8c2f] transition-colors shadow-sm">
                            <span wire:loading.remove wire:target="simpanPenyelesaian, fotoBukti">Simpan & Selesai</span>
                            <span wire:loading wire:target="simpanPenyelesaian">Menyimpan...</span>
                            <span wire:loading wire:target="fotoBukti">Mengunggah...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <style>
            @keyframes slideUp {
                from { transform: translateY(100%); }
                to { transform: translateY(0); }
            }
            .slide-up { animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        </style>
    @endif
</div>
