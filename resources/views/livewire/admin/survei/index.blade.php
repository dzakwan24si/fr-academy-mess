<div class="p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#114045]">Evaluasi & Survei Kepuasan Tamu</h1>
            <p class="text-sm text-gray-500 mt-1">Rekapitulasi penilaian dan masukan tamu setelah check-in di Mess FR Academy.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <button wire:click="exportPdf" class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-[#2E7D32] hover:bg-green-800 text-white rounded-xl text-sm font-semibold transition-colors shadow-md">
                <span wire:loading.remove wire:target="exportPdf" class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export PDF
                </span>
                <span wire:loading wire:target="exportPdf" class="flex items-center gap-2">
                    <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memproses...
                </span>
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
            <span class="text-xs font-bold text-gray-500 mb-1">Total Responden</span>
            <span class="text-2xl font-black text-[#114045]">{{ $stats['total'] }}</span>
        </div>
        @foreach([
            ['label' => 'K. Kamar', 'value' => $stats['avg_kamar']],
            ['label' => 'K. Toilet', 'value' => $stats['avg_toilet']],
            ['label' => 'Makanan', 'value' => $stats['avg_makanan']],
            ['label' => 'Fasilitas', 'value' => $stats['avg_fasilitas']],
            ['label' => 'Staf/FO', 'value' => $stats['avg_staf']],
        ] as $stat)
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                <span class="text-xs font-bold text-gray-500 mb-1">{{ $stat['label'] }}</span>
                <div class="flex items-center gap-1 text-orange-500">
                    <span class="text-xl font-bold">{{ number_format($stat['value'], 1) }}</span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tabel Data Survei -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h2 class="font-bold text-gray-700">Daftar Hasil Survei</h2>
            <div class="relative w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input wire:model.live="search" type="text" class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-[#59A338] focus:border-[#59A338] transition-colors" placeholder="Cari nama tamu / kamar...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 font-bold text-gray-500 text-[11px] uppercase tracking-wider border-b border-gray-100">Waktu</th>
                        <th class="px-6 py-4 font-bold text-gray-500 text-[11px] uppercase tracking-wider border-b border-gray-100">Tamu & Kamar</th>
                        <th class="px-6 py-4 font-bold text-gray-500 text-[11px] uppercase tracking-wider border-b border-gray-100 text-center">Rata-Rata</th>
                        <th class="px-6 py-4 font-bold text-gray-500 text-[11px] uppercase tracking-wider border-b border-gray-100">Saran & Masukan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($surveis as $survei)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-gray-500">
                            {{ \Carbon\Carbon::parse($survei->created_at)->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">{{ $survei->reservasi->tamu->nama ?? 'Anonim' }}</div>
                            <div class="text-[11px] text-gray-500 mt-0.5">{{ $survei->reservasi->kamar->nomor_kamar ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                // Rata-rata dari 5 kategori baru, atau gunakan rating lama
                                if ($survei->kebersihan_kamar !== null) {
                                    $avg = ($survei->kebersihan_kamar + $survei->kebersihan_toilet + $survei->kualitas_makanan + $survei->kenyamanan_fasilitas + $survei->pelayanan_staf) / 5;
                                } else {
                                    $avg = $survei->rating;
                                }
                            @endphp
                            <div class="flex items-center justify-center gap-1 text-orange-500 bg-orange-50 border border-orange-100 px-2 py-1 rounded-lg w-16 mx-auto">
                                <span class="font-bold">{{ number_format($avg, 1) }}</span>
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $saran = $survei->saran_masukan ?? $survei->komentar;
                            @endphp
                            @if($saran)
                                <div class="text-sm text-gray-600 truncate max-w-sm italic">"{{ $saran }}"</div>
                            @else
                                <span class="text-gray-400 text-xs italic">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada data survei kepuasan tamu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $surveis->links() }}
        </div>
    </div>
</div>
