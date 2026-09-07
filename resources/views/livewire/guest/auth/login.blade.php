<div>
    @if(!$isRegistering)
        <form wire:submit.prevent="cekNomor" class="bg-white/10 backdrop-blur-md rounded-full shadow-2xl p-2 border border-white/20 flex flex-col md:flex-row items-center gap-2">
            <div class="flex-1 w-full flex items-center px-6 bg-white rounded-full py-3 h-full">
                <svg class="w-6 h-6 text-[#59A338] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <input wire:model="no_hp" type="number" placeholder="Masukkan Nomor HP (Tamu)..." class="w-full bg-transparent border-none outline-none focus:outline-none focus:border-transparent focus:ring-0 text-gray-800 placeholder-gray-500 font-semibold text-base" style="outline: none !important; box-shadow: none !important; border-color: transparent !important; background: transparent !important;" required>
            </div>
            <button type="submit" class="w-full md:w-auto px-8 py-3 md:py-3.5 rounded-full text-white font-bold bg-[#59A338] hover:bg-[#4d8c2f] transition-colors shadow-lg flex-shrink-0 flex items-center justify-center gap-2 text-base">
                <span wire:loading.remove wire:target="cekNomor">Jelajahi Portal</span>
                <span wire:loading wire:target="cekNomor">Memproses...</span>
            </button>
        </form>
        @error('no_hp') <span class="text-red-300 text-sm font-semibold mt-2 block drop-shadow-md">{{ $message }}</span> @enderror
    @else
        <form wire:submit.prevent="daftarTamu" class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-6 md:p-8 border border-white/20 text-left mx-auto max-w-2xl">
            <h3 class="text-2xl font-bold text-[#114045] mb-2 text-center">Registrasi Tamu Baru</h3>
            <p class="text-gray-500 text-sm text-center mb-8">Nomor HP Anda belum terdaftar. Silakan lengkapi data berikut.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Nomor HP</label>
                    <input wire:model="no_hp" type="text" class="w-full bg-gray-100 border-gray-200 rounded-xl px-4 py-3 text-gray-500 cursor-not-allowed focus:ring-0 shadow-inner" readonly>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input wire:model="nama" type="text" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow" placeholder="Masukkan nama Anda" required>
                    @error('nama') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Perusahaan / Instansi</label>
                    <input wire:model="perusahaan" type="text" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow" placeholder="Opsional">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Jabatan</label>
                    <input wire:model="jabatan" type="text" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow" placeholder="Opsional">
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <button type="button" wire:click="batalDaftar" class="w-full md:w-1/3 py-3.5 rounded-xl border-2 border-gray-200 text-gray-600 font-bold hover:bg-gray-50 hover:border-gray-300 transition-colors">
                    Batal
                </button>
                <button type="submit" class="w-full md:w-2/3 py-3.5 rounded-xl bg-[#59A338] text-white font-bold hover:bg-[#4d8c2f] transition-colors shadow-lg">
                    <span wire:loading.remove wire:target="daftarTamu">Daftar & Masuk</span>
                    <span wire:loading wire:target="daftarTamu">Menyimpan...</span>
                </button>
            </div>
        </form>
    @endif
</div>
