<div class="p-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Laporan Okupansi</h2>
            <p class="text-gray-500 text-sm mt-1">Laporan tingkat hunian kamar Mess FR Academy bulanan.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <button wire:click="exportPdf" class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                <span wire:loading.remove wire:target="exportPdf" class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export PDF
                </span>
                <span wire:loading wire:target="exportPdf" class="flex items-center gap-2 text-[#59A338]">
                    <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-[#59A338]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memproses...
                </span>
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row gap-4 z-20 relative">
        <div class="flex-1 max-w-xs">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Bulan</label>
            <select wire:model.live="bulan" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <option value="all">Semua Bulan</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                @endfor
            </select>
        </div>
        <div class="flex-1 max-w-xs">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tahun</label>
            <select wire:model.live="tahun" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                <option value="all">Semua Tahun</option>
                @for($i = 2024; $i <= date('Y') + 1; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        
        <div class="ml-auto hidden sm:flex items-center gap-4">
            <div class="text-right">
                <div class="text-xs font-semibold text-gray-500 uppercase">Total Tamu</div>
                <div class="text-xl font-bold text-[#2E7D32]">{{ $totalTamu }} Orang</div>
            </div>
            <div class="h-10 border-l border-gray-200"></div>
            <div class="text-right">
                <div class="text-xs font-semibold text-gray-500 uppercase">Selesai/Check-out</div>
                <div class="text-xl font-bold text-gray-800">{{ $totalSelesai }}</div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div id="chart-data-container" class="hidden"
        data-trainee="{{ $traineeCount }}"
        data-umum="{{ $umumCount }}"
        data-kamarlabels="{{ json_encode($topKamar->pluck('kamar.nomor_kamar')->toArray()) }}"
        data-kamardata="{{ json_encode($topKamar->pluck('total')->toArray()) }}"
        data-komplainlabels="{{ json_encode($topKomplain->pluck('nomor_kamar')->toArray()) }}"
        data-komplaindata="{{ json_encode($topKomplain->pluck('total')->toArray()) }}">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 relative z-10">
        <!-- Chart 1: Trainee vs Umum -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-700 mb-4 text-center">Proporsi Tamu (Trainee vs Umum)</h3>
            <div wire:ignore class="relative h-48 w-full flex justify-center">
                <canvas id="tamuChart"></canvas>
            </div>
            <div class="mt-4 flex justify-between text-xs font-semibold">
                <div class="text-center w-1/2">
                    <span class="block text-gray-500">Trainee</span>
                    <span class="text-lg text-blue-600">{{ $traineeCount }}</span>
                </div>
                <div class="text-center w-1/2 border-l border-gray-100">
                    <span class="block text-gray-500">Umum</span>
                    <span class="text-lg text-[#59A338]">{{ $umumCount }}</span>
                </div>
            </div>
        </div>

        <!-- Chart 2: Top Kamar -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-700 mb-4 text-center">Peringkat Kamar Sering Disewa</h3>
            <div wire:ignore class="relative h-48 w-full">
                <canvas id="kamarChart"></canvas>
            </div>
        </div>

        <!-- Chart 3: Top Komplain -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-700 mb-4 text-center">Peringkat Kamar Sering Komplain</h3>
            <div wire:ignore class="relative h-48 w-full">
                <canvas id="komplainChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-semibold">
                        <th class="px-6 py-4 rounded-tl-2xl w-16">No</th>
                        <th class="px-6 py-4">Tamu & Instansi</th>
                        <th class="px-6 py-4">Kamar</th>
                        <th class="px-6 py-4">Tanggal Check-in</th>
                        <th class="px-6 py-4">Tanggal Check-out</th>
                        <th class="px-6 py-4 rounded-tr-2xl">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                    @forelse($reservasis as $index => $row)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-gray-500">
                            {{ $reservasis->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">{{ $row->tamu->nama ?? 'Tamu' }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $row->tamu->perusahaan ?? '-' }} ({{ $row->tamu->jabatan ?? '-' }})</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($row->kamar)
                                <div class="font-bold text-[#2E7D32]">{{ $row->kamar->nomor_kamar }}</div>
                                <div class="text-xs text-gray-500">{{ $row->kamar->tipe_kamar }}</div>
                            @else
                                <span class="text-gray-400 italic">Belum dialokasikan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">
                            {{ \Carbon\Carbon::parse($row->tanggal_checkin)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">
                            {{ $row->tanggal_checkout ? \Carbon\Carbon::parse($row->tanggal_checkout)->translatedFormat('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($row->status == 'checked_in')
                                <span class="px-2.5 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-semibold tracking-wide">CHECK-IN</span>
                            @elseif($row->status == 'completed')
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-800 rounded-lg text-xs font-semibold tracking-wide">SELESAI</span>
                            @else
                                <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-semibold tracking-wide">DISETUJUI</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-sm font-medium">Tidak ada data okupansi pada periode ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($reservasis->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $reservasis->links() }}
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@script
<script>
    let tamuChartInstance = null;
    let kamarChartInstance = null;
    let komplainChartInstance = null;

    function renderCharts() {
        const dataContainer = document.getElementById('chart-data-container');
        if (!dataContainer) return;
        
        const traineeCount = parseInt(dataContainer.dataset.trainee) || 0;
        const umumCount = parseInt(dataContainer.dataset.umum) || 0;
        const kamarLabels = JSON.parse(dataContainer.dataset.kamarlabels || '[]');
        const kamarData = JSON.parse(dataContainer.dataset.kamardata || '[]');
        const komplainLabels = JSON.parse(dataContainer.dataset.komplainlabels || '[]');
        const komplainData = JSON.parse(dataContainer.dataset.komplaindata || '[]');

        const tamuCtx = document.getElementById('tamuChart')?.getContext('2d');
        const kamarCtx = document.getElementById('kamarChart')?.getContext('2d');
        const komplainCtx = document.getElementById('komplainChart')?.getContext('2d');

        if(tamuChartInstance) tamuChartInstance.destroy();
        if(kamarChartInstance) kamarChartInstance.destroy();
        if(komplainChartInstance) komplainChartInstance.destroy();

        if (tamuCtx) {
            tamuChartInstance = new Chart(tamuCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Trainee', 'Tamu Umum'],
                    datasets: [{
                        data: [traineeCount, umumCount],
                        backgroundColor: ['#3b82f6', '#59A338'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    cutout: '70%'
                }
            });
        }

        if (kamarCtx) {
            kamarChartInstance = new Chart(kamarCtx, {
                type: 'bar',
                data: {
                    labels: kamarLabels,
                    datasets: [{
                        label: 'Total Disewa',
                        data: kamarData,
                        backgroundColor: '#59A338',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }

        if (komplainCtx) {
            komplainChartInstance = new Chart(komplainCtx, {
                type: 'bar',
                data: {
                    labels: komplainLabels,
                    datasets: [{
                        label: 'Total Komplain',
                        data: komplainData,
                        backgroundColor: '#ef4444',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }
    }

    // Render initially
    setTimeout(renderCharts, 100);

    // Re-render when Livewire updates the DOM (e.g., filter changed)
    $wire.on('charts-updated', () => {
        setTimeout(renderCharts, 100);
    });
</script>
@endscript
