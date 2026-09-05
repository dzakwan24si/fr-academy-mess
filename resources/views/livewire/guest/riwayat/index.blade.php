<div class="min-h-screen bg-gray-50 font-sans pb-24 lg:pb-8 relative">
    <!-- Mobile Bottom Navigation (Hidden on Desktop) -->
    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-50 lg:hidden pb-safe">
        <a href="{{ route('guest.dashboard') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="{{ route('guest.riwayat') }}" wire:navigate class="flex flex-col items-center gap-1 text-[#59A338] focus:outline-none">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            <span class="text-[10px] font-bold">Riwayat</span>
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
                    <h1 class="text-xl md:text-2xl font-bold text-[#114045]">Riwayat Reservasi</h1>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Daftar pemesanan Anda</p>
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
                            <a href="{{ route('guest.riwayat') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#59A338]/10 text-[#59A338] font-bold transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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

            <!-- Kolom Kanan: Riwayat (lg:col-span-8) -->
            <div class="lg:col-span-8 space-y-4">
                @forelse ($riwayats as $riwayat)
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">
                                    {{ $riwayat->kamar ? 'Kamar ' . $riwayat->kamar->nomor_kamar : 'Belum Ada Kamar' }}
                                    @if($riwayat->kamar)
                                        <span class="text-xs font-normal text-gray-500 ml-1">({{ $riwayat->kamar->tipe_kamar }})</span>
                                    @endif
                                </h3>
                                <div class="text-sm text-gray-500 mt-1 flex flex-wrap gap-x-4 gap-y-1">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        In: {{ \Carbon\Carbon::parse($riwayat->tanggal_checkin)->format('d M Y') }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        Out: {{ \Carbon\Carbon::parse($riwayat->tanggal_checkout)->format('d M Y') }}
                                    </span>
                                </div>
                                @if($riwayat->status == 'rejected' && $riwayat->alasan_penolakan)
                                    <p class="text-xs text-red-500 mt-2 flex items-start gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $riwayat->alasan_penolakan }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="md:text-right flex md:flex-col items-center md:items-end justify-between md:justify-center border-t md:border-t-0 border-gray-100 pt-3 md:pt-0">
                            <div class="text-xs text-gray-400 mb-1 hidden md:block">Status Reservasi</div>
                            @if($riwayat->status == 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Pending</span>
                            @elseif($riwayat->status == 'approved')
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Disetujui</span>
                            @elseif($riwayat->status == 'checked_in')
                                <span class="px-3 py-1 bg-[#E8F5E9] text-[#2E7D32] rounded-full text-xs font-semibold">Menginap</span>
                            @elseif($riwayat->status == 'completed')
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">Selesai</span>
                            @elseif($riwayat->status == 'rejected' || $riwayat->status == 'batal')
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Ditolak</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-10 shadow-sm border border-gray-100 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Riwayat</h3>
                        <p class="text-gray-500 text-sm mb-6">Anda belum pernah melakukan reservasi kamar sebelumnya.</p>
                        <a href="{{ route('guest.booking') }}" class="inline-block px-6 py-2.5 bg-[#114045] text-white font-semibold rounded-xl hover:bg-[#0d3034] transition-colors shadow-sm">
                            Booking Kamar Sekarang
                        </a>
                    </div>
                @endforelse

                @if($riwayats->hasPages())
                    <div class="mt-6">
                        {{ $riwayats->links() }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</div>
