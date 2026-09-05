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

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <!-- Header -->
        <header class="flex items-center gap-4 mb-8">
            <a href="{{ route('guest.dashboard') }}" wire:navigate class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-[#114045]">Menu Makanan Hari Ini</h1>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            </div>
        </header>

        @if (session()->has('success'))
            <div class="mb-6 bg-green-50 text-green-700 border border-green-200 px-4 py-3 rounded-xl flex items-start gap-3 relative z-10">
                <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="space-y-6">
            @forelse($menus as $rencana)
                @php
                    $isSelesai = $rencana->status == 'selesai' || strtolower($rencana->status) == 'selesai';
                    $hasRated = isset($feedbacks[$rencana->id]);
                    $feedback = $hasRated ? $feedbacks[$rencana->id] : null;
                    
                    // Style config based on time
                    $timeTheme = match(strtolower($rencana->waktu)) {
                        'pagi' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'border' => 'border-amber-100', 'icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z'],
                        'siang' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-600', 'border' => 'border-sky-100', 'icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z'],
                        'malam' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'border' => 'border-indigo-100', 'icon' => 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z'],
                        default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-100', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z']
                    };
                @endphp

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="flex flex-col md:flex-row md:items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl {{ $timeTheme['bg'] }} {{ $timeTheme['text'] }} flex items-center justify-center shrink-0 border {{ $timeTheme['border'] }}">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $timeTheme['icon'] }}"></path>
                            </svg>
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider {{ $timeTheme['text'] }} bg-white px-2 py-0.5 rounded border {{ $timeTheme['border'] }} shadow-sm inline-block mb-2">
                                        {{ ucfirst($rencana->waktu) }}
                                    </span>
                                    <h2 class="text-xl font-bold text-gray-900">{{ $rencana->menu->nama_menu }}</h2>
                                </div>
                            </div>
                            
                            @if($rencana->menu->deskripsi)
                                <p class="text-sm text-gray-500 font-medium leading-relaxed mb-4">
                                    {{ $rencana->menu->deskripsi }}
                                </p>
                            @endif

                            <div class="flex items-center gap-3 mb-6">
                                <span class="px-3 py-1 bg-gray-50 text-gray-600 text-xs font-bold rounded-lg border border-gray-200">
                                    {{ $rencana->menu->kategori ?? 'Umum' }}
                                </span>
                                @if(strtolower($rencana->status) == 'sedang_masak' || strtolower($rencana->status) == 'sedang masak')
                                    <span class="px-3 py-1 bg-yellow-50 text-yellow-600 text-xs font-bold rounded-lg border border-yellow-200 flex items-center gap-1">
                                        <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Sedang Dimasak
                                    </span>
                                @elseif($isSelesai)
                                    <span class="px-3 py-1 bg-green-50 text-green-600 text-xs font-bold rounded-lg border border-green-200">Tersedia di Ruang Makan</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-500 text-xs font-bold rounded-lg border border-gray-200">Menunggu</span>
                                @endif
                            </div>

                            @if($isSelesai)
                                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 mt-4">
                                    <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-orange-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        {{ $hasRated ? 'Penilaian Anda' : 'Beri Penilaian Makanan Ini' }}
                                    </h3>

                                    @if($selectedRencanaId == $rencana->id || (!$hasRated && $selectedRencanaId == null))
                                        <form wire:submit.prevent="simpanFeedback" class="space-y-4">
                                            <div class="flex items-center gap-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button" wire:click="beriRating({{ $rencana->id }}, {{ $i }})" class="focus:outline-none transition-transform hover:scale-110">
                                                        <svg class="w-8 h-8 {{ $rating >= $i && $selectedRencanaId == $rencana->id ? 'text-orange-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    </button>
                                                @endfor
                                            </div>
                                            @if($selectedRencanaId == $rencana->id)
                                                @error('rating') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                <textarea wire:model="komentar" rows="2" class="w-full bg-white border border-gray-200 focus:bg-white focus:border-orange-400 focus:ring-2 focus:ring-orange-400/20 rounded-xl px-4 py-2 text-sm transition-all" placeholder="Tambahkan komentar (opsional)..."></textarea>
                                                
                                                <button type="submit" class="px-5 py-2.5 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 transition-all shadow-sm text-sm">
                                                    Kirim Penilaian
                                                </button>
                                            @endif
                                        </form>
                                    @else
                                        <!-- Show Existing Rating -->
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-5 h-5 {{ $feedback->rating >= $i ? 'text-orange-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-xs font-bold text-gray-500">{{ $feedback->rating }} Bintang</span>
                                        </div>
                                        @if($feedback->komentar)
                                            <p class="text-sm text-gray-600 font-medium italic border-l-2 border-orange-200 pl-3">"{{ $feedback->komentar }}"</p>
                                        @endif
                                        
                                        <button type="button" wire:click="beriRating({{ $rencana->id }}, {{ $feedback->rating }})" class="text-xs font-bold text-orange-500 hover:text-orange-600 mt-3 inline-block">
                                            Edit Penilaian
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Menu</h3>
                    <p class="text-sm text-gray-500 font-medium">Menu makanan untuk hari ini belum diterbitkan oleh Admin Dapur.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
