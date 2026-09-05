<div class="min-h-screen bg-gray-50 font-sans pb-24 lg:pb-8 relative">
    <!-- Mobile Bottom Navigation (Hidden on Desktop) -->
    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-50 lg:hidden pb-safe">
        <a href="{{ route('guest.dashboard') }}" wire:navigate class="flex flex-col items-center gap-1 text-[#59A338] focus:outline-none">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3l8 6v12h-5v-7H9v7H4V9l8-6z"/></svg>
            <span class="text-[10px] font-bold">Home</span>
        </a>
        <a href="{{ route('guest.riwayat') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>
        <a href="{{ route('guest.profil') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </nav>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <!-- Header (Mobile: Simple, Desktop: Richer) -->
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-[#114045] text-white flex items-center justify-center font-bold text-xl shadow-sm">
                    {{ substr($tamu->nama, 0, 1) }}
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">
                        @if($reservasi && $reservasi->kamar)
                            Kamar {{ $reservasi->kamar->nomor_kamar }}
                        @else
                            Belum Ada Kamar
                        @endif
                    </p>
                    <h1 class="text-xl md:text-2xl font-bold text-[#114045]">Halo, {{ explode(' ', $tamu->nama)[0] }}!</h1>
                </div>
            </div>
            
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit" class="w-12 h-12 rounded-full bg-white border border-red-100 text-red-500 flex items-center justify-center hover:bg-red-50 transition-colors shadow-sm" title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </header>

        <!-- CSS Grid for Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
            
            <!-- Kolom Kiri: Status & Sidebar (lg:col-span-4) -->
            <div class="lg:col-span-4 space-y-6 lg:space-y-8">
                
                <!-- Kartu Status Reservasi -->
                <div class="bg-gradient-to-br from-[#114045] to-[#59A338] rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden">
                    <!-- Decorative Pattern -->
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 opacity-10">
                        <svg width="150" height="150" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 22h20L12 2z"></path></svg>
                    </div>
                    
                    <div class="relative z-10">
                        @if($reservasi)
                            <div class="flex items-center gap-2 mb-6">
                                <span class="relative flex h-3 w-3">
                                    @if($reservasi->status == 'checked_in')
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                                    @else
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-300"></span>
                                    @endif
                                </span>
                                <p class="text-sm font-semibold text-white/90">
                                    {{ $reservasi->status == 'pending' ? 'Menunggu Konfirmasi Admin' : ($reservasi->status == 'approved' ? 'Telah Disetujui, Silakan Check-in di Resepsionis' : 'Sedang Menginap') }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div>
                                    <p class="text-white/70 text-xs mb-1 uppercase tracking-wider font-semibold">Check-in</p>
                                    <p class="font-bold text-base md:text-lg">{{ \Carbon\Carbon::parse($reservasi->tanggal_checkin)->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-white/70 text-xs mb-1 uppercase tracking-wider font-semibold">Check-out</p>
                                    <p class="font-bold text-base md:text-lg">{{ \Carbon\Carbon::parse($reservasi->tanggal_checkout)->format('d M Y') }}</p>
                                </div>
                            </div>

                            @if($reservasi->status == 'checked_in')
                                <button class="w-full bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-md text-white font-bold py-3.5 rounded-xl transition-all shadow-sm">
                                    Ajukan Check-out
                                </button>
                            @else
                                <div class="w-full bg-black/20 backdrop-blur-sm text-white/80 font-semibold py-3 rounded-xl text-center text-sm border border-black/10">
                                    Silakan tunggu validasi admin
                                </div>
                            @endif
                        @elseif($lastReservasi && $lastReservasi->status == 'rejected')
                            <div class="text-center py-4">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-500/20 text-red-100 mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-white mb-2">Reservasi Ditolak</h3>
                                <div class="bg-black/20 p-4 rounded-xl border border-red-400/30 text-sm text-white/90 mb-6 text-left">
                                    <span class="font-bold text-red-200 block mb-1">Alasan Penolakan:</span>
                                    "{{ $lastReservasi->alasan_penolakan ?? 'Tidak ada keterangan.' }}"
                                </div>
                                <a href="{{ route('guest.booking') }}" class="inline-block w-full bg-white text-red-600 font-bold py-3.5 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                                    Ajukan Booking Ulang
                                </a>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <svg class="w-12 h-12 mx-auto text-white/50 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <p class="text-sm text-white/80 font-medium mb-4">Tidak ada reservasi aktif</p>
                                <a href="{{ route('guest.booking') }}" class="inline-block bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-md text-white font-bold py-2 px-6 rounded-xl transition-all shadow-sm">
                                    Booking Kamar
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Desktop Sidebar Menu (Hidden on Mobile) -->
                <div class="hidden lg:block bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Menu Navigasi</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('guest.dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#59A338]/10 text-[#59A338] font-bold transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3l8 6v12h-5v-7H9v7H4V9l8-6z"/></svg>
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
                            <a href="{{ route('guest.profil') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 font-medium transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>
                        </li>
                    </ul>
                </div>
                
            </div>

            <!-- Kolom Kanan: Menu Layanan (lg:col-span-8) -->
            <div class="lg:col-span-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg md:text-xl font-bold text-gray-800">Layanan Kamar</h2>
                    @if($reservasi && in_array($reservasi->status, ['pending', 'approved']))
                        <span class="text-xs font-semibold text-orange-500 bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                            Tersedia setelah check-in
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
                    @php
                        $isDisabled = !$reservasi || in_array($reservasi->status, ['pending', 'approved']);
                        $cardClass = "bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-4 group transition-all duration-300";
                        if ($isDisabled) {
                            $cardClass .= " opacity-50 pointer-events-none grayscale-[30%]";
                        } else {
                            $cardClass .= " hover:shadow-lg hover:-translate-y-1 cursor-pointer";
                        }
                    @endphp

                    <!-- Menu 1: Laundry -->
                    <a href="{{ $isDisabled ? '#' : route('guest.laundry') }}" wire:navigate class="{{ $cardClass }}" {{ $isDisabled ? 'style="pointer-events:none;"' : '' }}>
                        <div class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner border border-teal-100">
                            <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="4" y="2" width="16" height="20" rx="2" stroke-width="2"/>
                                <circle cx="12" cy="14" r="4" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-width="2" d="M8 6h8"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 text-center">Request Laundry</span>
                    </a>

                    <!-- Menu 2: Komplain -->
                    <a href="{{ $isDisabled ? '#' : route('guest.komplain') }}" wire:navigate class="{{ $cardClass }}" {{ $isDisabled ? 'style="pointer-events:none;"' : '' }}>
                        <div class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner border border-orange-100">
                            <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 text-center">Lapor Kerusakan</span>
                    </a>

                    <!-- Menu 3: Nilai Makanan -->
                    <a href="{{ $isDisabled ? '#' : route('guest.dapur') }}" wire:navigate class="{{ $cardClass }}" {{ $isDisabled ? 'style="pointer-events:none;"' : '' }}>
                        <div class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner border border-purple-100">
                            <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 text-center">Nilai Makanan</span>
                    </a>

                    <!-- Menu 4: Status Kebersihan -->
                    <button class="{{ $cardClass }}" {{ $isDisabled ? 'disabled' : '' }}>
                        <div class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner border border-blue-100">
                            <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 text-center">Status Kebersihan</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
