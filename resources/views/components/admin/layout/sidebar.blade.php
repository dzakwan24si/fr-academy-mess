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
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-4">
        
        <!-- DASHBOARD -->
        <div>
            <a href="{{ route('admin.dashboard') }}" wire:navigate class="{{ request()->routeIs('admin.dashboard') ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-semibold transition-colors text-sm">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
        </div>
        
        <!-- KAMAR & RESERVASI -->
        @canany(['akses_reservasi', 'akses_kamar', 'akses_kebersihan'])
        <div x-data="{ open: {{ request()->routeIs('admin.reservasi', 'admin.kamar', 'admin.kebersihan') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between text-gray-600 hover:bg-gray-50 px-4 py-2.5 rounded-xl font-semibold transition-colors text-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Kamar & Reservasi
                </div>
                <svg :class="{'rotate-180': open}" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-collapse class="pl-12 pr-2 mt-1 space-y-1">
                @can('akses_reservasi')
                <a href="{{ route('admin.reservasi') }}" wire:navigate class="{{ request()->routeIs('admin.reservasi') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Reservasi Kamar
                </a>
                @endcan
                @can('akses_kamar')
                <a href="{{ route('admin.kamar') }}" wire:navigate class="{{ request()->routeIs('admin.kamar') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Manajemen Kamar
                </a>
                @endcan
                @can('akses_kebersihan')
                <a href="{{ route('admin.kebersihan') }}" wire:navigate class="{{ request()->routeIs('admin.kebersihan') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Tugas Kebersihan
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- MANAJEMEN ASET -->
        @canany(['akses_aset', 'akses_maintenance'])
        <div x-data="{ open: {{ request()->routeIs('admin.aset', 'admin.aset.laporan', 'admin.maintenance') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between text-gray-600 hover:bg-gray-50 px-4 py-2.5 rounded-xl font-semibold transition-colors text-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Manajemen Aset
                </div>
                <svg :class="{'rotate-180': open}" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-collapse class="pl-12 pr-2 mt-1 space-y-1">
                @can('akses_aset')
                <a href="{{ route('admin.aset') }}" wire:navigate class="{{ request()->routeIs('admin.aset') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Master Aset
                </a>
                <a href="{{ route('admin.aset.laporan') }}" wire:navigate class="{{ request()->routeIs('admin.aset.laporan') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Laporan Distribusi Aset
                </a>
                @endcan
                @can('akses_maintenance')
                <a href="{{ route('admin.maintenance') }}" wire:navigate class="{{ request()->routeIs('admin.maintenance') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Tugas Perbaikan
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- LAYANAN MESS -->
        @canany(['akses_laundry', 'akses_dapur', 'akses_komplain'])
        <div x-data="{ open: {{ request()->routeIs('admin.laundry', 'admin.dapur', 'admin.komplain') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between text-gray-600 hover:bg-gray-50 px-4 py-2.5 rounded-xl font-semibold transition-colors text-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Layanan Mess
                </div>
                <svg :class="{'rotate-180': open}" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-collapse class="pl-12 pr-2 mt-1 space-y-1">
                @can('akses_laundry')
                <a href="{{ route('admin.laundry') }}" wire:navigate class="{{ request()->routeIs('admin.laundry') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Manajemen Laundry
                </a>
                @endcan
                @can('akses_dapur')
                <a href="{{ route('admin.dapur') }}" wire:navigate class="{{ request()->routeIs('admin.dapur') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Dapur & Menu
                </a>
                @endcan
                @can('akses_komplain')
                <a href="{{ route('admin.komplain') }}" wire:navigate class="{{ request()->routeIs('admin.komplain') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Komplain Fasilitas
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <!-- SISTEM & PENGATURAN -->
        @canany(['akses_survei', 'manajemen_akun'])
        <div x-data="{ open: {{ request()->routeIs('admin.survei.*', 'admin.akun', 'admin.laporan.okupansi') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between text-gray-600 hover:bg-gray-50 px-4 py-2.5 rounded-xl font-semibold transition-colors text-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Sistem & Laporan
                </div>
                <svg :class="{'rotate-180': open}" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-collapse class="pl-12 pr-2 mt-1 space-y-1">
                @can('akses_survei')
                <a href="{{ route('admin.survei.index') }}" wire:navigate class="{{ request()->routeIs('admin.survei.*') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Evaluasi & Survei
                </a>
                <a href="{{ route('admin.laporan.okupansi') }}" wire:navigate class="{{ request()->routeIs('admin.laporan.okupansi') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Laporan Okupansi
                </a>
                @endcan
                @can('manajemen_akun')
                <a href="{{ route('admin.akun') }}" wire:navigate class="{{ request()->routeIs('admin.akun') ? 'text-[#2E7D32] font-bold' : 'text-gray-500 hover:text-gray-800' }} block py-2 text-sm transition-colors">
                    Manajemen Akun
                </a>
                @endcan
            </div>
        </div>
        @endcanany

    </div>

    <!-- Bottom Info -->
    <div class="p-4 m-4 mt-0 bg-[#F4F8F4] rounded-xl border border-green-100">
        <h4 class="text-sm font-bold text-[#2E7D32]">FR Academy System</h4>
        <p class="text-[11px] text-green-700/80 mt-0.5 leading-tight">Versi 1.0 - Manajemen Mess</p>
    </div>
</aside>