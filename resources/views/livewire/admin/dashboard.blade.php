<div class="p-6 h-full flex flex-col gap-6" wire:ignore.self>
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Command Center</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau seluruh operasional Mess FR Academy secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium text-gray-500 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </span>
            @can('akses_reservasi')
            <a href="{{ route('admin.reservasi') }}" class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-[#59A338] hover:bg-[#4d8f2f] text-white rounded-xl text-sm font-semibold transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Reservasi
            </a>
            @endcan
        </div>
    </div>

    <!-- Summary Cards (Top) -->
    <div class="flex flex-wrap gap-4">
        @can('akses_reservasi')
        <!-- 1. Kamar Terisi -->
        <div wire:click="showDetail('okupansi')" class="cursor-pointer hover:scale-[1.02] transition-transform flex-1 min-w-[200px] bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-gray-100 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span class="text-xs font-semibold text-gray-400 uppercase">Okupansi</span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $kamarTerisi }} <span class="text-sm font-normal text-gray-500">/ {{ $totalKamar }}</span></h3>
                <p class="text-xs text-gray-500 mt-1">Kamar sedang terisi</p>
            </div>
        </div>

        <!-- 2. Check-in Hari Ini -->
        <div wire:click="showDetail('kedatangan')" class="cursor-pointer hover:scale-[1.02] transition-transform flex-1 min-w-[200px] bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-gray-100 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                </div>
                <span class="text-xs font-semibold text-gray-400 uppercase">Kedatangan</span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $checkInHariIni }}</h3>
                <p class="text-xs text-gray-500 mt-1">Jadwal Check-in hari ini</p>
            </div>
        </div>

        <!-- 3. Check-out Hari Ini -->
        <div wire:click="showDetail('kepulangan')" class="cursor-pointer hover:scale-[1.02] transition-transform flex-1 min-w-[200px] bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-gray-100 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </div>
                <span class="text-xs font-semibold text-gray-400 uppercase">Kepulangan</span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $checkOutHariIni }}</h3>
                <p class="text-xs text-gray-500 mt-1">Jadwal Check-out hari ini</p>
            </div>
        </div>

        <!-- 4. Reservasi Pending (Warning) -->
        <div wire:click="showDetail('pending')" class="cursor-pointer hover:scale-[1.02] transition-transform flex-1 min-w-[200px] bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-orange-100 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-semibold text-orange-400 uppercase">Pending</span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $reservasiPending }}</h3>
                <p class="text-xs text-orange-600 mt-1">Menunggu persetujuan</p>
            </div>
        </div>

        <!-- 5. Kamar Kotor (Danger) -->
        <div wire:click="showDetail('perlu_bersih')" class="cursor-pointer hover:scale-[1.02] transition-transform flex-1 min-w-[200px] bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-rose-100 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <span class="text-xs font-semibold text-rose-400 uppercase">Perlu Bersih</span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $kamarKotor }}</h3>
                <p class="text-xs text-rose-600 mt-1">Kamar status kotor</p>
            </div>
        </div>
        @endcan

        <!-- 6. Komplain Baru -->
        @can('akses_komplain')
        <div wire:click="showDetail('komplain_baru')" class="cursor-pointer hover:scale-[1.02] transition-transform flex-1 min-w-[200px] bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-amber-100 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <span class="text-xs font-semibold text-amber-400 uppercase">Komplain</span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $komplainBaru }}</h3>
                <p class="text-xs text-amber-600 mt-1">Laporan belum diproses</p>
            </div>
        </div>
        @endcan
    </div>

    @php $hasChart = auth()->user()->can('akses_reservasi'); @endphp
    <!-- Main Content Area -->
    <div class="grid grid-cols-1 {{ $hasChart ? 'lg:grid-cols-3' : 'lg:grid-cols-1' }} gap-6 flex-1">
        
        @can('akses_reservasi')
        <!-- Left Side: Occupancy Chart (Col Span 2) -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <!-- Chart Container -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex-1">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Tren Tamu Menginap</h2>
                    <div class="flex items-center gap-3">
                        <div wire:loading wire:target="chartRange" class="text-sm text-gray-400 flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </div>
                        <select wire:model.live="chartRange" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block px-3 py-1.5 font-medium shadow-sm outline-none">
                            <option value="7">7 Hari Terakhir</option>
                            <option value="14">14 Hari Terakhir</option>
                            <option value="30">30 Hari Terakhir</option>
                        </select>
                    </div>
                </div>
                <div id="occupancyChart" class="w-full h-64" wire:ignore></div>
            </div>

            <!-- Recent Reservations Table -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Aktivitas Reservasi Terbaru</h2>
                    <a href="{{ route('admin.reservasi') ?? '#' }}" class="text-sm font-semibold text-green-600 hover:text-green-700">Lihat Semua &rarr;</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead>
                            <tr class="text-gray-400 border-b border-gray-100">
                                <th class="font-semibold py-3 px-2">Tamu</th>
                                <th class="font-semibold py-3 px-2">Check-in</th>
                                <th class="font-semibold py-3 px-2">Status</th>
                                <th class="font-semibold py-3 px-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentReservations as $rsv)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3 px-2">
                                    <div class="font-medium text-gray-800">{{ $rsv->tamu->nama ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $rsv->kamar->nomor_kamar ?? 'Belum ada kamar' }}</div>
                                </td>
                                <td class="py-3 px-2 text-gray-600">
                                    {{ $rsv->tanggal_checkin ? \Carbon\Carbon::parse($rsv->tanggal_checkin)->format('d M Y') : '-' }}
                                </td>
                                <td class="py-3 px-2">
                                    @if(strtolower($rsv->status) == 'aktif' || strtolower($rsv->status) == 'checked-in')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-green-50 text-green-700 border border-green-200">Aktif</span>
                                    @elseif(strtolower($rsv->status) == 'pending' || strtolower($rsv->status) == 'menunggu')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-orange-50 text-orange-700 border border-orange-200">Pending</span>
                                    @elseif(strtolower($rsv->status) == 'selesai')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Selesai</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-gray-50 text-gray-700 border border-gray-200">{{ ucfirst($rsv->status) }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-2 text-right">
                                    <a href="{{ route('admin.reservasi') ?? '#' }}" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-green-600 hover:bg-green-50 transition-colors" title="Buka Manajemen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">Belum ada data aktivitas reservasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endcan

        <!-- Right Side: Operational Widget -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col gap-6 {{ $hasChart ? '' : 'col-span-full' }}">
            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-4">Ringkasan Operasional Hari Ini</h2>
            
            <!-- Dapur -->
            @can('akses_dapur')
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z"></path></svg>
                    </div>
                    <h3 class="font-semibold text-gray-700">Porsi Dapur</h3>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <div class="text-xs text-gray-500 mb-1">Pagi</div>
                        <div class="font-bold text-gray-800">{{ $porsiPagi }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <div class="text-xs text-gray-500 mb-1">Siang</div>
                        <div class="font-bold text-gray-800">{{ $porsiSiang }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <div class="text-xs text-gray-500 mb-1">Malam</div>
                        <div class="font-bold text-gray-800">{{ $porsiMalam }}</div>
                    </div>
                </div>
                <a href="{{ route('admin.dapur') ?? '#' }}" class="mt-3 text-xs font-semibold text-green-600 hover:text-green-700 inline-block">Kelola Menu Dapur &rarr;</a>
            </div>

            <hr class="border-gray-50">
            @endcan

            <!-- Komplain & Laundry -->
            @canany(['akses_komplain', 'akses_laundry'])
            <div class="flex flex-col gap-4">
                @can('akses_komplain')
                <div class="flex items-center justify-between bg-amber-50/50 rounded-xl p-4 border border-amber-100/50 hover:bg-amber-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700 text-sm">Komplain Baru</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Laporan kerusakan fasilitas</p>
                        </div>
                    </div>
                    <div class="font-bold text-lg {{ $komplainBaru > 0 ? 'text-amber-600' : 'text-gray-400' }}">{{ $komplainBaru }}</div>
                </div>
                @endcan

                @can('akses_laundry')
                <div class="flex items-center justify-between bg-cyan-50/50 rounded-xl p-4 border border-cyan-100/50 hover:bg-cyan-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-cyan-100 text-cyan-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700 text-sm">Request Laundry</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Menunggu diproses</p>
                        </div>
                    </div>
                    <div class="font-bold text-lg {{ $laundryBaru > 0 ? 'text-cyan-600' : 'text-gray-400' }}">{{ $laundryBaru }}</div>
                </div>
                @endcan
            </div>
            @endcanany
            
            <div class="mt-auto pt-4 text-center">
                <p class="text-xs text-gray-400">Data operasional diperbarui secara real-time</p>
            </div>
        </div>
    </div>

    <!-- Global Loading Overlay for Modal Data -->
    <div wire:loading.flex wire:target="showDetail" class="fixed inset-0 z-[60] bg-black/20 backdrop-blur-sm items-center justify-center">
        <div class="bg-white p-4 rounded-xl shadow-xl flex items-center gap-3">
            <svg class="animate-spin h-6 w-6 text-[#59A338]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            <span class="text-sm font-semibold text-gray-700">Mengambil data...</span>
        </div>
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <!-- Background backdrop -->
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeDetailModal"></div>

        <!-- Modal panel -->
        <div class="relative bg-white rounded-2xl w-full max-w-2xl shadow-xl z-10 flex flex-col max-h-[85vh] overflow-hidden">
            <div class="flex justify-between items-center p-5 border-b border-gray-100 shrink-0">
                <h3 class="text-xl font-bold text-slate-800" id="modal-title">
                    {{ $detailTitle }}
                </h3>
                <button wire:click="closeDetailModal" class="bg-gray-100 rounded-full p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-200 focus:outline-none transition-colors">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="bg-gray-50 p-5 overflow-y-auto flex-1">
                @if(count($detailData) > 0)
                    <div class="space-y-0">
                        @foreach($detailData as $data)
                            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm mb-3">
                                @if(in_array($detailType, ['okupansi', 'kedatangan', 'kepulangan', 'pending']))
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            <div class="flex flex-col items-center justify-center px-4 py-2 bg-blue-50 text-blue-800 rounded-lg min-w-[80px]">
                                                <span class="text-xs tracking-wider font-semibold mb-0.5">KAMAR</span>
                                                <span class="font-bold text-lg leading-none">
                                                    {{ str_ireplace(['kamar ', 'kmr '], '', $data->kamar->nomor_kamar ?? '-') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-slate-900">{{ $data->tamu->nama ?? 'Tamu Tidak Diketahui' }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                {{ $data->tamu->instansi ?: 'Tamu Umum' }} {{ $data->tamu->no_hp ? ' - ' . $data->tamu->no_hp : '' }}
                                            </p>
                                            <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg> {{ \Carbon\Carbon::parse($data->tanggal_checkin)->format('d M Y') }}</span>
                                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg> {{ \Carbon\Carbon::parse($data->tanggal_checkout)->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($detailType == 'perlu_bersih')
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            <div class="flex flex-col items-center justify-center px-4 py-2 bg-blue-50 text-blue-800 rounded-lg min-w-[80px]">
                                                <span class="text-xs tracking-wider font-semibold mb-0.5">KAMAR</span>
                                                <span class="font-bold text-lg leading-none">
                                                    {{ str_ireplace(['kamar ', 'kmr '], '', $data->nomor_kamar) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-slate-900">Tipe: {{ $data->tipe_kamar }}</p>
                                            <div class="mt-1.5">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold tracking-wide uppercase {{ $data->status == 'kosong_kotor' ? 'bg-rose-100 text-rose-800' : 'bg-orange-100 text-orange-800' }}">
                                                    {{ str_replace('_', ' ', $data->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($detailType == 'komplain_baru')
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            <div class="flex flex-col items-center justify-center px-4 py-2 bg-blue-50 text-blue-800 rounded-lg min-w-[80px]">
                                                <span class="text-xs tracking-wider font-semibold mb-0.5">KAMAR</span>
                                                <span class="font-bold text-lg leading-none">
                                                    {{ str_ireplace(['kamar ', 'kmr '], '', $data->reservasi->kamar->nomor_kamar ?? '-') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-slate-900 line-clamp-2">{{ $data->deskripsi }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">Pelapor: {{ $data->reservasi->tamu->nama ?? 'Sistem/Admin' }}</p>
                                            <div class="mt-1.5 text-[11px] font-medium text-slate-400">
                                                {{ $data->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                            <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2zM9 15h2m-2 0l2-2" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800">Tidak ada data</h3>
                        <p class="mt-1 text-xs text-slate-500 max-w-[200px] mx-auto">
                            @if($detailType == 'kedatangan') Belum ada jadwal kedatangan tamu untuk hari ini.
                            @elseif($detailType == 'kepulangan') Belum ada jadwal kepulangan tamu untuk hari ini.
                            @elseif($detailType == 'perlu_bersih') Semua kamar saat ini dalam keadaan bersih!
                            @elseif($detailType == 'komplain_baru') Belum ada laporan komplain kerusakan baru.
                            @else Saat ini tidak ada data untuk kategori ini.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        let chartInstance = null;

        const renderChart = (chartData, chartDates) => {
            if (chartInstance) {
                chartInstance.updateOptions({
                    xaxis: { categories: chartDates }
                });
                chartInstance.updateSeries([{
                    name: 'Tamu Menginap',
                    data: chartData
                }]);
                return;
            }

            const options = {
                series: [{
                    name: 'Tamu Menginap',
                    data: chartData
                }],
                chart: {
                    type: 'area',
                    height: 250,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif',
                },
                colors: ['#10B981'], // Emerald-500
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [50, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: chartDates,
                    tooltip: { enabled: false },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: {
                    min: 0,
                    labels: {
                        formatter: (val) => { return Math.floor(val) }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } }
                },
                theme: {
                    mode: 'light'
                }
            };

            chartInstance = new ApexCharts(document.querySelector("#occupancyChart"), options);
            chartInstance.render();
        };

        // Render once on init
        renderChart(@json($chartData), @json($chartDates));

        // Listen for livewire updates
        Livewire.on('chart-updated', (...args) => {
            let eventData = args[0];
            
            // Handle Livewire 3 wrapping
            if (Array.isArray(eventData) && eventData[0] && eventData[0].chartData) {
                eventData = eventData[0];
            } else if (args[0] && args[0].chartData) {
                eventData = args[0];
            } else if (args[0] && args[0].detail && args[0].detail.chartData) {
                eventData = args[0].detail; // Native event fallback
            }

            if (eventData && eventData.chartData && eventData.chartDates) {
                renderChart(eventData.chartData, eventData.chartDates);
            }
        });
        
        // Setup re-render on navigation if needed
        document.addEventListener('livewire:navigated', () => {
            if(document.querySelector("#occupancyChart")) {
                document.querySelector("#occupancyChart").innerHTML = '';
                chartInstance = null;
                // Get the current initial data on page load
                const initialData = JSON.parse(document.querySelector('#occupancyChart').dataset.chartData || '[]');
                const initialDates = JSON.parse(document.querySelector('#occupancyChart').dataset.chartDates || '[]');
                
                if (initialData.length > 0) {
                     renderChart(initialData, initialDates);
                } else {
                     renderChart(@json($chartData), @json($chartDates));
                }
            }
        });
    });
</script>
@endpush
