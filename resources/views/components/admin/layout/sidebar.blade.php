<?php
use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return view('components.admin.layout.sidebar');
    }
};
?>
<aside class="w-64 bg-white rounded-2xl shadow-sm flex flex-col overflow-hidden shrink-0 h-full border border-gray-50">
    <div class="flex-1 overflow-y-auto py-6 px-4">
        
        <!-- MENU UTAMA -->
        <div class="mb-6">
            <h3 class="px-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Menu Utama</h3>
            <nav class="space-y-1.5">
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="{{ request()->routeIs('admin.dashboard') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                @can('akses_reservasi')
                <a href="{{ route('admin.reservasi') }}" wire:navigate class="{{ request()->routeIs('admin.reservasi') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.reservasi') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Reservasi Kamar
                </a>
                @endcan
                
                @can('akses_kamar')
                <a href="{{ route('admin.kamar') }}" wire:navigate class="{{ request()->routeIs('admin.kamar') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.kamar') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Manajemen Kamar
                </a>
                @endcan

                @can('akses_aset')
                <a href="{{ route('admin.aset') }}" wire:navigate class="{{ request()->routeIs('admin.aset') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.aset') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Master Aset
                </a>

                <a href="{{ route('admin.aset.laporan') }}" wire:navigate class="{{ request()->routeIs('admin.aset.laporan') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.aset.laporan') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Distribusi Aset
                </a>
                @endcan
            </nav>
            </nav>
        </div>

        <!-- OPERASIONAL -->
        @canany(['akses_laundry', 'akses_dapur', 'akses_komplain'])
        <div class="mb-6">
            <h3 class="px-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Operasional</h3>
            <nav class="space-y-1.5">
                @can('akses_laundry')
                <a href="{{ route('admin.laundry') }}" wire:navigate class="{{ request()->routeIs('admin.laundry') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.laundry') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    Manajemen Laundry
                </a>
                @endcan
                
                @can('akses_dapur')
                <a href="{{ route('admin.dapur') }}" wire:navigate class="{{ request()->routeIs('admin.dapur') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dapur') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z"></path></svg>
                    Dapur & Menu
                </a>
                @endcan

                @can('akses_komplain')
                <a href="{{ route('admin.komplain') }}" wire:navigate class="{{ request()->routeIs('admin.komplain') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.komplain') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Komplain Fasilitas
                </a>
                @endcan
            </nav>
        </div>
        @endcanany

        <!-- LAPORAN & EVALUASI -->
        @can('akses_survei')
        <div class="mb-6">
            <h3 class="px-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Laporan & Evaluasi</h3>
            <nav class="space-y-1.5">
                <a href="{{ route('admin.survei.index') }}" wire:navigate class="{{ request()->routeIs('admin.survei.*') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.survei.*') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Evaluasi & Survei
                </a>
            </nav>
        </div>
        @endcan

        <!-- PENGATURAN -->
        @can('manajemen_akun')
        <div class="mb-6">
            <h3 class="px-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Pengaturan</h3>
            <nav class="space-y-1.5">
                <a href="{{ route('admin.akun') }}" wire:navigate class="{{ request()->routeIs('admin.akun') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.akun') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manajemen Akun
                </a>
            </nav>
        </div>
        @endcan
    </div>

    <!-- Bottom Info -->
    <div class="p-4 m-4 mt-0 bg-[#F4F8F4] rounded-xl border border-green-100">
        <h4 class="text-sm font-bold text-[#2E7D32]">FR Academy System</h4>
        <p class="text-[11px] text-green-700/80 mt-0.5 leading-tight">Versi 1.0 - Manajemen Mess</p>
    </div>
</aside>