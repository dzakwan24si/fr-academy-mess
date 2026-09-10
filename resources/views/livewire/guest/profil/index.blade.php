<div class="min-h-screen bg-gray-50 font-sans pb-24 lg:pb-8 relative">
    <!-- Mobile Bottom Navigation (Hidden on Desktop) -->
    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-50 lg:hidden pb-safe">
        <a href="{{ route('guest.dashboard') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="{{ route('guest.riwayat') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>
        <a href="{{ route('guest.profil') }}" wire:navigate class="flex flex-col items-center gap-1 text-[#59A338] focus:outline-none">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </nav>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <!-- Header (Mobile: Simple, Desktop: Richer) -->
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-[#114045] text-white flex items-center justify-center font-bold text-xl shadow-sm">
                    {{ substr(Auth::guard('tamu')->user()->nama, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-[#114045]">Profil Saya</h1>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Pengaturan Akun Tamu</p>
                </div>
            </div>
            
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-12 h-12 rounded-full bg-white border border-red-100 text-red-500 flex items-center justify-center hover:bg-red-50 transition-colors shadow-sm" title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </header>

        <!-- CSS Grid for Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
            
            <!-- Kolom Kiri: Sidebar (lg:col-span-4) -->
            <div class="lg:col-span-4 space-y-6 lg:space-y-8">
                <!-- Desktop Sidebar Menu (Hidden on Mobile) -->
                <div class="hidden lg:block bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Menu Navigasi</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('guest.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 font-medium transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Dashboard Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('guest.riwayat') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 font-medium transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Riwayat Reservasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('guest.profil') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#59A338]/10 text-[#59A338] font-bold transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                Profil Saya
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Kolom Kanan: Edit Profil (lg:col-span-8) -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Ubah Data Diri</h2>
                    
                    @if (session()->has('success'))
                        <div class="mb-6 bg-green-50 text-green-700 border border-green-200 px-4 py-3 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form wire:submit.prevent="simpan" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input wire:model="nama" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm transition-shadow" required>
                                @error('nama') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor HP (WhatsApp) <span class="text-red-500">*</span></label>
                                <input wire:model="no_hp" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm transition-shadow bg-gray-50" readonly>
                                <span class="text-[10px] text-gray-400 mt-1 block">Nomor HP digunakan sebagai akses login.</span>
                                @error('no_hp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Perusahaan / Instansi <span class="text-red-500">*</span></label>
                                <input wire:model="perusahaan" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm transition-shadow" placeholder="Nama instansi Anda" required>
                                @error('perusahaan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                                <input wire:model="jabatan" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent text-sm transition-shadow" placeholder="Jabatan Anda" required>
                                @error('jabatan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex justify-end">
                            <button type="submit" class="w-full md:w-auto px-8 py-3.5 bg-[#59A338] text-white font-bold rounded-xl hover:bg-[#4d8c2f] transition-all shadow-sm focus:ring-4 focus:ring-green-100 flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="simpan">Simpan Perubahan</span>
                                <span wire:loading wire:target="simpan">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
