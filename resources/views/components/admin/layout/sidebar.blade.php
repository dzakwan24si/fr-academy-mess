<?php

use Livewire\Component;

new class extends Component
{
    public $activeMenu = 'Dashboard';

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
                <a href="{{ route('admin.dashboard') }}" class="{{ $activeMenu === 'Dashboard' ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ $activeMenu === 'Dashboard' ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                <a href="#" class="{{ $activeMenu === 'Reservasi Kamar' ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ $activeMenu === 'Reservasi Kamar' ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Reservasi Kamar
                </a>
            </nav>
        </div>

        <!-- OPERASIONAL -->
        <div class="mb-6">
            <h3 class="px-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Operasional</h3>
            <nav class="space-y-1.5">
                <a href="#" class="{{ $activeMenu === 'Manajemen Laundry' ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ $activeMenu === 'Manajemen Laundry' ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    Manajemen Laundry
                </a>
                
                <a href="#" class="{{ $activeMenu === 'Dapur & Menu' ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ $activeMenu === 'Dapur & Menu' ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z"></path></svg>
                    Dapur & Menu
                </a>

                <a href="#" class="{{ $activeMenu === 'Komplain Fasilitas' ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ $activeMenu === 'Komplain Fasilitas' ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    Komplain Fasilitas
                </a>
            </nav>
        </div>

        <!-- PENGATURAN -->
        <div class="mb-6">
            <h3 class="px-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Pengaturan</h3>
            <nav class="space-y-1.5">
                <a href="#" class="{{ $activeMenu === 'Manajemen Akun' ? 'bg-[#2E7D32] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-colors text-sm">
                    <svg class="w-5 h-5 {{ $activeMenu === 'Manajemen Akun' ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manajemen Akun
                </a>
            </nav>
        </div>
    </div>

    <!-- Bottom Info -->
    <div class="p-4 m-4 mt-0 bg-[#F4F8F4] rounded-xl border border-green-100">
        <h4 class="text-sm font-bold text-[#2E7D32]">FR Academy System</h4>
        <p class="text-[11px] text-green-700/80 mt-0.5 leading-tight">Versi 1.0 - Manajemen Mess</p>
    </div>
</aside>