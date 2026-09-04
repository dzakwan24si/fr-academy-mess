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

<div class="h-full bg-[#114045] text-white w-64 fixed left-0 top-0 overflow-y-auto">
    <div class="p-6 border-b border-teal-800">
        <h2 class="text-2xl font-bold tracking-tight">Mess Admin</h2>
        <p class="text-teal-200 text-sm mt-1">FR Academy</p>
    </div>
    
    <nav class="mt-6 px-4 space-y-2">
        <a href="#" class="block px-4 py-3 bg-teal-800 rounded-lg font-medium transition">Dashboard</a>
        
        @hasanyrole('Superadmin|Koordinator Mess')
        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-teal-300 uppercase tracking-wider">Reservasi & Kamar</p>
        </div>
        <a href="#" class="block px-4 py-2 text-teal-100 hover:bg-teal-800 rounded-md transition">Kelola Reservasi</a>
        <a href="#" class="block px-4 py-2 text-teal-100 hover:bg-teal-800 rounded-md transition">Status Kamar</a>
        @endhasanyrole

        @hasanyrole('Superadmin|Staf Kebersihan')
        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-teal-300 uppercase tracking-wider">Layanan</p>
        </div>
        <a href="#" class="block px-4 py-2 text-teal-100 hover:bg-teal-800 rounded-md transition">Daftar Laundry</a>
        <a href="#" class="block px-4 py-2 text-teal-100 hover:bg-teal-800 rounded-md transition">Log Kebersihan</a>
        @endhasanyrole

        @hasanyrole('Superadmin|Staf Dapur')
        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-teal-300 uppercase tracking-wider">Dapur & Makanan</p>
        </div>
        <a href="#" class="block px-4 py-2 text-teal-100 hover:bg-teal-800 rounded-md transition">Rencana Menu</a>
        <a href="#" class="block px-4 py-2 text-teal-100 hover:bg-teal-800 rounded-md transition">Stok Bahan Baku</a>
        @endhasanyrole

        @hasanyrole('Superadmin|Teknisi')
        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-teal-300 uppercase tracking-wider">Maintenance</p>
        </div>
        <a href="#" class="block px-4 py-2 text-teal-100 hover:bg-teal-800 rounded-md transition">Tiket Komplain</a>
        @endhasanyrole

        @hasanyrole('Superadmin|Kepala TU')
        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-teal-300 uppercase tracking-wider">Laporan</p>
        </div>
        <a href="#" class="block px-4 py-2 text-teal-100 hover:bg-teal-800 rounded-md transition">Statistik Kepuasan</a>
        <a href="#" class="block px-4 py-2 text-teal-100 hover:bg-teal-800 rounded-md transition">Pengeluaran</a>
        @endhasanyrole
    </nav>
    
    <div class="absolute bottom-0 w-full p-4 border-t border-teal-800">
        <form method="POST" action="#">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 text-teal-200 hover:text-white hover:bg-teal-800 rounded-md transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                </svg>
                Keluar
            </button>
        </form>
    </div>
</div>