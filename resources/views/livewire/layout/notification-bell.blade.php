<div class="relative flex items-center" x-data="{ open: false }" wire:poll.10s>
    <button @click="open = !open" @click.away="open = false" class="relative p-2 text-gray-500 hover:text-[#59A338] transition-colors rounded-full hover:bg-gray-50 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        
        @if($unreadCount > 0)
            <span class="absolute top-1 right-1 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full ring-2 ring-white">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 translate-y-2"
         x-transition:enter-end="transform opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 translate-y-0"
         x-transition:leave-end="transform opacity-0 translate-y-2"
         class="absolute right-0 top-full mt-3 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50"
         style="display: none;">
        
        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-800">Notifikasi</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-[11px] font-semibold text-[#59A338] hover:text-[#4d8c2f] transition-colors">
                    Tandai semua dibaca
                </button>
            @endif
        </div>

        <div class="max-h-[350px] overflow-y-auto">
            @forelse($notifications as $notification)
                <button wire:click="markAsRead('{{ $notification->id }}', '{{ $notification->data['url'] ?? '#' }}')" class="w-full text-left px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition-colors flex gap-3 {{ is_null($notification->read_at) ? 'bg-green-50/30' : '' }}">
                    <div class="flex-shrink-0 mt-0.5">
                        @if(isset($notification->data['type']) && $notification->data['type'] == 'komplain')
                            <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                        @elseif(isset($notification->data['type']) && $notification->data['type'] == 'reservasi')
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @elseif(isset($notification->data['type']) && $notification->data['type'] == 'laundry')
                            <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                            </div>
                        @elseif(isset($notification->data['type']) && $notification->data['type'] == 'kebersihan')
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            </div>
                        @else
                            <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-800 {{ is_null($notification->read_at) ? 'font-bold' : '' }}">
                            {{ $notification->data['title'] ?? 'Pemberitahuan Baru' }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">
                            {{ $notification->data['message'] ?? '' }}
                        </p>
                        <p class="text-[10px] text-gray-400 mt-1.5 font-medium">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                </button>
            @empty
                <div class="px-4 py-8 text-center">
                    <div class="w-16 h-16 rounded-full border border-gray-100 bg-white shadow-sm flex items-center justify-center mx-auto mb-3 text-gray-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Belum ada notifikasi</p>
                </div>
            @endforelse
        </div>
        
        @if(count($notifications) > 0)
            <div class="px-4 py-2 border-t border-gray-100 bg-gray-50 text-center">
                <span class="text-[11px] text-gray-400">Menampilkan 10 notifikasi terbaru</span>
            </div>
        @endif
    </div>
</div>
