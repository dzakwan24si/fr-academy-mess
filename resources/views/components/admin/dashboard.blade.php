<?php
use Livewire\Component;

new class extends Component
{
    // Mock data for display purposes based on user request
    public $reservations = [
        ['no' => 'RSV-260904-001', 'nama' => 'Budi Santoso', 'kamar' => '101 (Reguler)', 'checkin' => '04 Sep 2026', 'status' => 'Checked-in'],
        ['no' => 'RSV-260904-002', 'nama' => 'Agus Yudhoyono', 'kamar' => 'VIP-02 (Executive)', 'checkin' => '04 Sep 2026', 'status' => 'Checked-in'],
        ['no' => 'RSV-260904-003', 'nama' => 'Siti Aminah', 'kamar' => '102 (Reguler)', 'checkin' => '04 Sep 2026', 'status' => 'Menunggu'],
        ['no' => 'RSV-260904-004', 'nama' => 'Doni Salmanan', 'kamar' => '201 (Reguler)', 'checkin' => '04 Sep 2026', 'status' => 'Menunggu'],
        ['no' => 'RSV-260904-005', 'nama' => 'Eka Pratama', 'kamar' => 'VIP-01 (Executive)', 'checkin' => '03 Sep 2026', 'status' => 'Checked-in'],
    ];
};
?>
<x-layouts.admin title="RESERVASI KAMAR / AKTIF HARI INI">
    
    <div class="p-6 h-full flex flex-col">
        <!-- Header & Toolbar -->
        <div class="flex flex-col xl:flex-row xl:items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Reservasi Aktif Hari Ini</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar tamu Mess FR Academy yang sedang menginap atau akan check-in.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors w-48 lg:w-64" placeholder="Cari Nama / No RSV...">
                </div>

                <!-- Filters -->
                <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 font-medium hover:bg-gray-50 flex items-center gap-2 transition-colors shadow-sm">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Semua Tipe
                </button>
                <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 font-medium hover:bg-gray-50 flex items-center gap-2 transition-colors shadow-sm">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Semua Status
                </button>

                <!-- Add Button -->
                <button class="px-4 py-2 bg-[#2E7D32] hover:bg-green-700 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="flex-1 overflow-auto rounded-xl border border-gray-100">
            <table class="min-w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-white sticky top-0 z-10 shadow-sm">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">No Reservasi</th>
                        <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Nama Tamu</th>
                        <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Nomor Kamar</th>
                        <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Tgl Check-in</th>
                        <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 bg-white">
                    @foreach($reservations as $rsv)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $rsv['no'] }}</td>
                        <td class="px-6 py-4 text-gray-600 font-medium">{{ $rsv['nama'] }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $rsv['kamar'] }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $rsv['checkin'] }}</td>
                        <td class="px-6 py-4">
                            @if($rsv['status'] == 'Checked-in')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Checked-in
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Menunggu
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button class="p-1.5 rounded-full text-emerald-600 bg-emerald-50 hover:bg-emerald-100 transition-colors" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button class="p-1.5 rounded-full text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="p-1.5 rounded-full text-red-600 bg-red-50 hover:bg-red-100 transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>