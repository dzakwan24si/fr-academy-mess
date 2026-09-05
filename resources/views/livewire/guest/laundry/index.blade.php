<div class="min-h-screen bg-gray-50 font-sans pb-24 lg:pb-8 relative">
    <!-- Mobile Bottom Navigation (Hidden on Desktop) -->
    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-50 lg:hidden pb-safe">
        <a href="{{ route('guest.dashboard') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="{{ route('guest.riwayat') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>
        <a href="{{ route('guest.profil') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </nav>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <!-- Header -->
        <header class="flex items-center gap-4 mb-8">
            <a href="{{ route('guest.dashboard') }}" wire:navigate class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-[#114045]">Layanan Laundry</h1>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Request cuci pakaian Anda</p>
            </div>
        </header>

        @if(!$reservasi)
            <div class="bg-red-50 border border-red-200 text-red-700 p-6 rounded-2xl text-center">
                <svg class="w-12 h-12 mx-auto text-red-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="text-lg font-bold mb-1">Akses Ditolak</h3>
                <p>Anda harus memiliki reservasi aktif (telah disetujui / sedang menginap) untuk request laundry.</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Form Request (lg:col-span-7) -->
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 mb-6 relative overflow-hidden">
                        <!-- Decorative background -->
                        <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none">
                            <svg class="w-32 h-32 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="4" y="2" width="16" height="20" rx="2" stroke-width="2"/>
                                <circle cx="12" cy="14" r="4" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-width="2" d="M8 6h8"/>
                            </svg>
                        </div>

                        <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 relative z-10">
                            <span class="w-8 h-8 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </span>
                            Buat Request Baru
                        </h2>
                        
                        @if (session()->has('success'))
                            <div class="mb-6 bg-green-50 text-green-700 border border-green-200 px-4 py-3 rounded-xl flex items-start gap-3 relative z-10">
                                <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-medium text-sm">{{ session('success') }}</span>
                            </div>
                        @endif
                        
                        @if (session()->has('error'))
                            <div class="mb-6 bg-red-50 text-red-700 border border-red-200 px-4 py-3 rounded-xl flex items-start gap-3 relative z-10">
                                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-medium text-sm">{{ session('error') }}</span>
                            </div>
                        @endif

                        <form wire:submit.prevent="simpan" class="relative z-10">
                            <div class="space-y-4 mb-6">
                                <div class="grid grid-cols-12 gap-3 pb-2 border-b border-gray-100 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                    <div class="col-span-7">Jenis Pakaian</div>
                                    <div class="col-span-3">Jumlah</div>
                                    <div class="col-span-2 text-center">Aksi</div>
                                </div>

                                @foreach($items as $index => $item)
                                    <div class="grid grid-cols-12 gap-3 items-start">
                                        <div class="col-span-7">
                                            <input wire:model="items.{{ $index }}.item_pakaian" type="text" class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 rounded-xl px-4 py-2.5 text-sm transition-all" placeholder="Kemeja Putih" required>
                                            @error("items.$index.item_pakaian") <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-span-3">
                                            <input wire:model="items.{{ $index }}.jumlah" type="number" min="1" class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 rounded-xl px-4 py-2.5 text-sm transition-all text-center" required>
                                            @error("items.$index.jumlah") <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-span-2 flex justify-center pt-1">
                                            <button type="button" wire:click="hapusItem({{ $index }})" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors {{ count($items) == 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ count($items) == 1 ? 'disabled' : '' }} title="Hapus baris">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <button type="button" wire:click="tambahItem" class="text-teal-600 font-bold text-sm flex items-center gap-1 hover:text-teal-700 bg-teal-50 hover:bg-teal-100 px-4 py-2 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Pakaian
                                </button>

                                <button type="submit" class="px-8 py-3 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition-all shadow-sm focus:ring-4 focus:ring-teal-100 flex items-center gap-2">
                                    <span wire:loading.remove wire:target="simpan">Kirim Request</span>
                                    <span wire:loading wire:target="simpan">Memproses...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Riwayat Laundry (lg:col-span-5) -->
                <div class="lg:col-span-5">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider pl-1 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Riwayat Laundry Anda
                    </h3>
                    
                    <div class="space-y-4">
                        @forelse ($riwayatLaundries as $riwayat)
                            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                                <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-50">
                                    <div class="text-xs text-gray-500 font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ \Carbon\Carbon::parse($riwayat->tanggal_request)->format('d M Y') }}
                                    </div>
                                    @if($riwayat->status == 'menunggu')
                                        <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-[10px] font-bold uppercase tracking-wide shadow-sm">Menunggu</span>
                                    @elseif($riwayat->status == 'diproses')
                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-lg text-[10px] font-bold uppercase tracking-wide shadow-sm">Diproses</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-[10px] font-bold uppercase tracking-wide shadow-sm">Selesai</span>
                                    @endif
                                </div>
                                
                                <div class="space-y-2">
                                    @foreach($riwayat->detailLaundries as $detail)
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-700 font-medium">{{ $detail->item_pakaian }}</span>
                                            <span class="text-gray-500 font-bold px-2 py-0.5 bg-gray-50 rounded-md border border-gray-100">{{ $detail->jumlah }} pcs</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4 pt-3 border-t border-gray-50 flex justify-between items-center text-xs font-bold text-gray-500">
                                    <span>Total:</span>
                                    <span class="text-teal-600 text-sm">{{ $riwayat->detailLaundries->sum('jumlah') }} pcs</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-white rounded-3xl border border-gray-100 border-dashed">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="4" y="2" width="16" height="20" rx="2" stroke-width="2"/>
                                    <circle cx="12" cy="14" r="4" stroke-width="2"/>
                                    <path stroke-linecap="round" stroke-width="2" d="M8 6h8"/>
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">Belum ada request laundry.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>
