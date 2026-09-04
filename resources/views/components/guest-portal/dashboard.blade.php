<?php
use Livewire\Component;

new class extends Component
{
    //
};
?>
<x-layouts.app>
    <div class="min-h-screen bg-slate-50 font-sans">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm py-4 px-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded bg-[#114045] flex items-center justify-center text-white font-bold text-lg">FR</div>
                    <span class="text-xl font-bold text-gray-800 tracking-tight">Portal Tamu</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600 font-medium">Halo, {{ auth('tamu')->user()->nama ?? 'Tamu' }}</span>
                    <form method="POST" action="#">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium transition">Keluar</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto p-8 mt-4">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Selamat datang!</h2>
                <p class="text-gray-600">Ini adalah dashboard khusus tamu. Anda dapat melihat informasi reservasi dan layanan fasilitas di sini nanti.</p>
            </div>
        </main>
    </div>
</x-layouts.app>