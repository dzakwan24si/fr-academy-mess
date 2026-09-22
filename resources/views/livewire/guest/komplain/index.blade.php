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

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <!-- Header -->
        <header class="flex items-center gap-4 mb-8">
            <a href="{{ route('guest.dashboard') }}" wire:navigate class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-[#114045]">Lapor Kerusakan</h1>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Ada masalah di kamar Anda?</p>
            </div>
        </header>

        @if(!$reservasi)
            <div class="bg-red-50 border border-red-200 text-red-700 p-6 rounded-2xl text-center">
                <svg class="w-12 h-12 mx-auto text-red-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="text-lg font-bold mb-1">Akses Ditolak</h3>
                <p>Anda harus memiliki reservasi aktif (telah disetujui / sedang menginap) untuk membuat laporan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Form Komplain -->
                <div>
                    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 mb-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            Buat Laporan Baru
                        </h2>
                        
                        @if (session()->has('success'))
                            <div class="mb-6 bg-green-50 text-green-700 border border-green-200 px-4 py-3 rounded-xl flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-medium text-sm">{{ session('success') }}</span>
                            </div>
                        @endif

                        <form wire:submit.prevent="simpan" class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Kerusakan <span class="text-red-500">*</span></label>
                                <textarea wire:model="deskripsi" rows="4" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm transition-shadow resize-none" placeholder="Ceritakan detail kerusakan yang terjadi (misal: AC bocor menetes ke kasur)..." required></textarea>
                                @error('deskripsi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Unggah Foto Bukti <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition-colors">
                                    <div class="space-y-1 text-center">
                                        @if ($foto_bukti)
                                            <div class="mb-3 relative group rounded-lg overflow-hidden border border-gray-200 inline-block">
                                                <img src="{{ $foto_bukti->temporaryUrl() }}" class="h-32 object-contain bg-white">
                                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <button type="button" wire:click="$set('foto_bukti', null)" class="text-white text-xs bg-red-500 px-3 py-1.5 rounded-full font-semibold">Hapus Foto</button>
                                                </div>
                                            </div>
                                        @else
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        @endif
                                        <div x-data="{ open: false }" class="relative flex flex-col items-center text-sm text-gray-600 justify-center">
                                            <div class="flex items-center">
                                                <button @click.prevent="open = !open" @click.away="open = false" type="button" class="relative bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none flex items-center gap-1">
                                                    <span>{{ $foto_bukti ? 'Ganti foto' : 'Pilih foto' }}</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                </button>
                                                <p class="pl-1">atau tarik & lepas</p>
                                            </div>
                                            
                                            <!-- Dropdown Menu -->
                                            <div x-show="open" x-transition.opacity class="absolute top-6 mt-1 w-52 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden z-20 text-left" style="display: none;">
                                                <label class="px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 cursor-pointer flex items-center gap-3 border-b border-gray-100 transition-colors">
                                                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    Buka Kamera
                                                    <input wire:model="foto_bukti" type="file" class="sr-only" accept="image/*" capture="environment" @change="open = false">
                                                </label>
                                                <label class="px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 cursor-pointer flex items-center gap-3 transition-colors">
                                                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    Pilih dari Galeri
                                                    <input wire:model="foto_bukti" type="file" class="sr-only" accept="image/*" @change="open = false">
                                                </label>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-3">PNG, JPG, GIF maksimal 20MB</p>
                                    </div>
                                </div>
                                <div wire:loading wire:target="foto_bukti" class="text-xs text-orange-500 mt-2 font-medium">Sedang mengunggah foto...</div>
                                @error('foto_bukti') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full px-8 py-3.5 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 transition-all shadow-sm focus:ring-4 focus:ring-orange-100 flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="simpan">Kirim Laporan</span>
                                <span wire:loading wire:target="simpan">Mengirim...</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Riwayat Komplain -->
                <div>
                    <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider pl-1">Riwayat Laporan</h3>
                    
                    <div class="space-y-4">
                        @forelse ($komplains as $komplain)
                            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <span class="text-xs text-gray-400 font-medium">{{ $komplain->created_at->format('d M Y, H:i') }}</span>
                                        @if($komplain->status_perbaikan == 'dilaporkan')
                                            <span class="ml-2 px-2 py-0.5 bg-orange-100 text-orange-700 rounded text-[10px] font-bold uppercase">Dilaporkan</span>
                                        @elseif($komplain->status_perbaikan == 'diproses')
                                            <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold uppercase">Sedang Diperbaiki</span>
                                        @else
                                            <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold uppercase">Selesai</span>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed font-medium mb-3">"{{ $komplain->deskripsi }}"</p>
                                
                                @if($komplain->foto_bukti)
                                    <div class="mb-3">
                                        <a href="{{ Storage::url($komplain->foto_bukti) }}" target="_blank" class="inline-block relative rounded-lg overflow-hidden border border-gray-200">
                                            <img src="{{ Storage::url($komplain->foto_bukti) }}" class="h-20 w-32 object-cover">
                                            <div class="absolute inset-0 bg-black/10 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                                <svg class="w-5 h-5 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                            </div>
                                        </a>
                                    </div>
                                @endif

                                @if($komplain->teknisi_id)
                                    <div class="bg-gray-50 rounded-lg p-3 text-xs border border-gray-100 flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                            {{ substr($komplain->teknisi->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="text-gray-500 block leading-tight">Ditangani oleh Teknisi:</span>
                                            <span class="font-bold text-gray-700 leading-tight">{{ $komplain->teknisi->name }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-10 bg-white rounded-3xl border border-gray-100 border-dashed">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-sm text-gray-500 font-medium">Belum ada laporan kerusakan dari Anda.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
