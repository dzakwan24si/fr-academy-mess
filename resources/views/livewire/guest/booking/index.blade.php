<div>
    <!-- Top Navigation for Booking -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#114045] text-white flex items-center justify-center font-bold">
                    {{ substr(Auth::guard('tamu')->user()->nama, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-lg font-bold text-[#114045] leading-tight">Halo, {{ explode(' ', Auth::guard('tamu')->user()->nama)[0] }}!</h1>
                    <p class="text-xs text-gray-500">Silakan pilih kamar Anda</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit" class="w-10 h-10 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors" title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </header>

    <div class="min-h-screen bg-gray-50 font-sans pb-12">
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Filter Section -->
            <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Kamar</label>
                        <select wire:model.live="tipe_kamar" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow text-gray-700">
                            <option value="">Semua Tipe Kamar</option>
                            <option value="Reguler">Reguler</option>
                            <option value="Executive">Executive</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Check-in</label>
                        <input wire:model.live="tanggal_checkin" type="date" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow text-gray-700">
                        @error('tanggal_checkin') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Check-out</label>
                        <input wire:model.live="tanggal_checkout" type="date" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow text-gray-700">
                        @error('tanggal_checkout') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Room List Grid -->
            <div class="flex justify-between items-end mb-5">
                <h2 class="text-xl font-bold text-[#114045]">Kamar Tersedia <span class="text-sm font-normal text-gray-500 ml-2">({{ $kamars->total() }} kamar)</span></h2>
            </div>
            
            @if($kamars->isEmpty())
                <div class="bg-white p-8 rounded-2xl text-center border border-gray-100 shadow-sm">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Tidak ada kamar tersedia</h3>
                    <p class="text-gray-500 text-sm">Cobalah mengganti tipe kamar atau ubah tanggal pencarian Anda.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($kamars as $kamar)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-gray-100 flex flex-col group cursor-pointer" wire:click="bukaModalBooking({{ $kamar->id }})">
                            <!-- Cover Image -->
                            <div class="relative h-48 w-full overflow-hidden bg-gray-200">
                                @if(str_contains(strtolower($kamar->tipe_kamar), 'executive'))
                                    <img src="{{ asset('images/slides-23.jpg') }}" alt="Room" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div class="absolute top-3 right-3 bg-[#59A338] text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">Executive</div>
                                @else
                                    <img src="{{ asset('images/slides-15.jpg') }}" alt="Room" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div class="absolute top-3 right-3 bg-white text-[#114045] px-3 py-1 rounded-full text-xs font-bold shadow-md border border-gray-100">Reguler</div>
                                @endif
                                <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-sm text-white px-2 py-1 rounded-md text-xs font-semibold">Tersedia</div>
                            </div>
                            
                            <!-- Card Body -->
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="font-bold text-lg text-[#114045] mb-1">Kamar {{ $kamar->nomor_kamar }}</h3>
                                <p class="text-sm text-gray-500 mb-4">{{ $kamar->tipe_kamar }}</p>
                                
                                <div class="flex items-center gap-4 text-sm text-gray-600 mb-5">
                                    <div class="flex items-center gap-1.5 font-medium">
                                        <svg class="w-4 h-4 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $kamar->kapasitas }} Orang
                                    </div>
                                    <div class="flex items-center gap-1.5 font-medium">
                                        <svg class="w-4 h-4 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Kondisi Bersih
                                    </div>
                                </div>
                                
                                <div class="mt-auto pt-4 border-t border-gray-100">
                                    <button class="w-full py-2.5 rounded-xl bg-white border border-[#59A338] text-[#59A338] font-bold group-hover:bg-[#59A338] group-hover:text-white transition-colors">
                                        Pilih Kamar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $kamars->links() }}
                </div>
            @endif
        </main>
    </div>

    <!-- Modal Booking -->
    @if($isBookingModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="tutupModalBooking"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-white rounded-3xl w-full max-w-md p-6 md:p-8 shadow-2xl z-10 mx-auto">
                <button wire:click="tutupModalBooking" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <h3 class="text-2xl font-bold text-[#114045] mb-6 border-b border-gray-100 pb-4">Konfirmasi Booking</h3>
                
                <div class="bg-gray-50 rounded-2xl p-4 mb-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-500 font-semibold">Kamar Pilihan</span>
                        <span class="font-bold text-[#114045]">{{ $selectedKamar ? 'Kamar ' . $selectedKamar->nomor_kamar : '' }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-500 font-semibold">Check-in</span>
                        <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($tanggal_checkin)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 font-semibold">Check-out</span>
                        <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($tanggal_checkout)->format('d M Y') }}</span>
                    </div>
                </div>
                
                <form wire:submit.prevent="konfirmasiBooking">
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Keperluan Menginap (Wajib) <span class="text-red-500">*</span></label>
                        <textarea wire:model="keperluan" rows="3" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow resize-none" placeholder="Contoh: Mengikuti pelatihan dasar angkatan 5..." required></textarea>
                        @error('keperluan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="button" wire:click="tutupModalBooking" class="flex-1 py-3.5 rounded-xl border-2 border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3.5 rounded-xl bg-[#59A338] text-white font-bold hover:bg-[#4d8c2f] transition-colors shadow-lg">
                            <span wire:loading.remove wire:target="konfirmasiBooking">Ajukan Booking</span>
                            <span wire:loading wire:target="konfirmasiBooking">Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
