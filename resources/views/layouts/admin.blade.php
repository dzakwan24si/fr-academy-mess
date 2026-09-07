@props(['title' => 'Dashboard'])

@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#F4F7F6] font-sans p-4 md:p-6 flex flex-col gap-4">
        <!-- Top Header (Floating) -->
        <header class="bg-white rounded-2xl shadow-sm h-16 flex items-center justify-between px-6 shrink-0 relative z-20">
            <!-- Left Side -->
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <div class="flex items-center gap-3 border-r border-gray-100 pr-6">
                    <img src="{{ asset('logofr.png') }}" alt="Logo FR" class="h-8 w-auto object-contain">
                    <span class="font-bold text-gray-800 tracking-tight text-lg">FR Academy</span>
                </div>
                
                <!-- Page Title / Breadcrumb -->
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-full border border-gray-100">
                    <svg class="w-4 h-4 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="text-[11px] font-bold text-gray-500 tracking-wider uppercase">{{ $title }}</span>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-6">
                <!-- Clock / Date (Alpine.js) -->
                <div x-data="clock()" class="hidden md:flex flex-col items-end text-sm">
                    <div class="flex items-center gap-1 font-bold text-gray-700">
                        <svg class="w-4 h-4 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span x-text="time">--:--:--</span>
                    </div>
                    <span class="text-[11px] text-gray-400 font-medium mt-0.5" x-text="date">-- -- ----</span>
                </div>

                <!-- User Profile -->
                <div class="flex items-center gap-3 pl-6 border-l border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-[#E8F5E9] text-[#2E7D32] font-bold flex items-center justify-center text-sm">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-bold text-gray-800 leading-none mb-1">{{ auth()->user()->name ?? 'Admin FR' }}</p>
                        <p class="text-[11px] text-gray-500 leading-none">{{ auth()->user()->roles->first()->name ?? 'Superadmin' }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 ml-1 cursor-pointer hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </header>

        <!-- Main Workspace -->
        <div class="flex flex-1 gap-4 overflow-hidden h-[calc(100vh-7rem)]">
            <!-- Sidebar (Floating) -->
            <livewire:admin.layout.sidebar />

            <!-- Content Area (Floating) -->
            <main class="flex-1 bg-white rounded-2xl shadow-sm overflow-y-auto relative">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Clock Script for Alpine.js -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('clock', () => ({
                time: '',
                date: '',
                init() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                },
                updateClock() {
                    const now = new Date();
                    this.time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/:/g, '.');
                    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                    this.date = now.toLocaleDateString('id-ID', options);
                }
            }));
        });
    </script>
@endsection
