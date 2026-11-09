<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mess FR Academy</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('faviconfr.svg') }}?v=1" type="image/svg+xml">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes scrollLeft {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            @keyframes scrollRight {
                0% { transform: translateX(-50%); }
                100% { transform: translateX(0); }
            }
            .marquee-left {
                display: flex;
                width: max-content;
                animation: scrollLeft 40s linear infinite;
            }
            .marquee-right {
                display: flex;
                width: max-content;
                animation: scrollRight 45s linear infinite;
            }
            .marquee-left:hover, .marquee-right:hover {
                animation-play-state: paused;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-800 bg-[#F8F9FA]">

        <!-- 1. Dynamic Header -->
        <header id="main-header" class="fixed top-4 md:top-6 left-1/2 -translate-x-1/2 w-[calc(100%-2rem)] md:w-[calc(100%-3rem)] z-50 bg-transparent transition-all duration-500 ease-in-out">
            <div class="max-w-7xl mx-auto px-6 md:px-8 py-3 md:py-4 flex justify-between items-center h-16 md:h-20 transition-all duration-500">
                <!-- Nav Kiri -->
                <nav class="hidden md:flex space-x-8 items-center flex-1">
                    <a href="#" class="nav-link text-sm font-semibold text-white transition-colors" data-active="true">Beranda</a>
                    <a href="#fasilitas" class="nav-link text-sm font-semibold text-white/80 hover:text-white transition-colors">Fasilitas</a>
                    <a href="#kamar" class="nav-link text-sm font-semibold text-white/80 hover:text-white transition-colors">Kamar</a>
                </nav>

                <!-- Logo Tengah -->
                <div class="flex-shrink-0 flex items-center justify-center flex-1 md:flex-none">
                    <img src="{{ asset('logofr.png') }}" alt="FR Academy Logo" class="h-10 md:h-12 w-auto object-contain drop-shadow-md">
                </div>

                <!-- Tombol Kanan -->
                <div class="flex items-center justify-end space-x-4 flex-1">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/admin/dashboard') }}" class="px-6 py-2.5 rounded-full text-sm font-bold text-white bg-[#59A338] hover:bg-[#4d8c2f] transition-all shadow-lg">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full text-sm font-bold text-white bg-[#59A338] hover:bg-[#4d8c2f] transition-all shadow-lg">
                                Masuk Portal
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <!-- 2. Hero Section (Rounded & Perfect Fit) -->
        <section class="p-4 md:p-6 bg-white min-h-screen">
            <!-- Container Melengkung -->
            <div class="relative w-full h-[calc(100vh-2rem)] md:h-[calc(100vh-3rem)] rounded-[2.5rem] md:rounded-[3.5rem] overflow-hidden shadow-2xl bg-[#114045]" id="hero-slider">
                <!-- Background Image Loop -->
                <img src="{{ asset('images/slides-6.jpg') }}" class="hero-slide absolute inset-0 w-full h-full object-cover transform transition-all duration-1000 ease-in-out opacity-100" alt="Mess FR Academy 1">
                <img src="{{ asset('images/slides-7.jpg') }}" class="hero-slide absolute inset-0 w-full h-full object-cover transform transition-all duration-1000 ease-in-out opacity-0" alt="Mess FR Academy 2">
                <img src="{{ asset('images/slides-2.jpg') }}" class="hero-slide absolute inset-0 w-full h-full object-cover transform transition-all duration-1000 ease-in-out opacity-0" alt="Mess FR Academy 3">
                <img src="{{ asset('images/slides-5.jpg') }}" class="hero-slide absolute inset-0 w-full h-full object-cover transform transition-all duration-1000 ease-in-out opacity-0" alt="Mess FR Academy 4">
                
                <!-- Overlay Hitam -->
                <div class="absolute inset-0 bg-black/40 pointer-events-none"></div>
                
                <!-- Konten Hero -->
                <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center pointer-events-none z-10">
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight mb-6 drop-shadow-xl max-w-5xl leading-tight">
                        Kenyamanan Anda,<br>
                        <span class="text-[#59A338]">Prioritas Kami.</span>
                    </h1>
                    <p class="mt-2 max-w-3xl text-base md:text-xl text-gray-200 font-medium drop-shadow-md">
                        Hunian terintegrasi dengan fasilitas lengkap untuk mendukung fokus pelatihan Anda selama berada di FR Academy.
                    </p>
                </div>

                <!-- 3. Floating Check-in / Login Box INSIDE HERO -->
                <div class="absolute bottom-8 md:bottom-10 left-1/2 -translate-x-1/2 z-40 w-11/12 max-w-3xl">
                    <livewire:guest.auth.login />
                </div>
            </div>
        </section>

        <!-- Script Animasi Header & Slider -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Header Scroll Animation
                const header = document.getElementById('main-header');
                const navLinks = document.querySelectorAll('.nav-link');
                
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 50) {
                        // Floating Pill Mode
                        header.classList.remove('w-[calc(100%-2rem)]', 'md:w-[calc(100%-3rem)]', 'bg-transparent');
                        header.classList.add('w-[95%]', 'max-w-7xl', 'bg-white/95', 'backdrop-blur-md', 'shadow-xl', 'rounded-full', 'border', 'border-gray-200');
                        
                        // Text colors to dark
                        navLinks.forEach(link => {
                            link.classList.remove('text-white', 'text-white/80', 'hover:text-white');
                            if(link.getAttribute('data-active') === 'true') {
                                link.classList.add('text-[#59A338]'); // Active link color
                            } else {
                                link.classList.add('text-[#114045]', 'hover:text-[#59A338]');
                            }
                        });
                    } else {
                        // Transparent Wide Mode
                        header.classList.add('w-[calc(100%-2rem)]', 'md:w-[calc(100%-3rem)]', 'bg-transparent');
                        header.classList.remove('w-[95%]', 'max-w-7xl', 'bg-white/95', 'backdrop-blur-md', 'shadow-xl', 'rounded-full', 'border', 'border-gray-200');
                        
                        // Text colors to white
                        navLinks.forEach(link => {
                            link.classList.remove('text-[#114045]', 'text-[#59A338]', 'hover:text-[#59A338]');
                            if(link.getAttribute('data-active') === 'true') {
                                link.classList.add('text-white');
                            } else {
                                link.classList.add('text-white/80', 'hover:text-white');
                            }
                        });
                    }
                });

                // Image Slider
                const slides = document.querySelectorAll('.hero-slide');
                let currentSlide = 0;
                if(slides.length > 0) {
                    setInterval(() => {
                        slides[currentSlide].classList.remove('opacity-100');
                        slides[currentSlide].classList.add('opacity-0');
                        
                        currentSlide = (currentSlide + 1) % slides.length;
                        
                        slides[currentSlide].classList.remove('opacity-0');
                        slides[currentSlide].classList.add('opacity-100');
                    }, 5000);
                }
            });
        </script>

        <!-- 3.5 Statistik Section -->
        <section class="bg-[#114045] py-12 md:py-16" id="statistik-section">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center divide-y sm:divide-y-0 sm:divide-x divide-white/10">
                    <div class="py-4">
                        <p class="text-4xl md:text-5xl font-extrabold text-[#59A338]"><span class="stat-number" data-target="{{ $totalKamar ?? 72 }}">0</span></p>
                        <p class="text-gray-200 mt-3 font-medium tracking-wide">Kamar Nyaman</p>
                    </div>
                    <div class="py-4">
                        <p class="text-4xl md:text-5xl font-extrabold text-[#59A338]"><span class="stat-number" data-target="100">0</span>+</p>
                        <p class="text-gray-200 mt-3 font-medium tracking-wide">Kapasitas Trainee</p>
                    </div>
                    <div class="py-4">
                        <p class="text-4xl md:text-5xl font-extrabold text-[#59A338]"><span class="stat-number" data-target="{{ $totalLorong ?? 12 }}">0</span></p>
                        <p class="text-gray-200 mt-3 font-medium tracking-wide">Lorong</p>
                    </div>
                    <div class="py-4">
                        <p class="text-4xl md:text-5xl font-extrabold text-[#59A338]"><span class="stat-number" data-target="24">0</span>/7</p>
                        <p class="text-gray-200 mt-3 font-medium tracking-wide">Kebersihan & Dapur</p>
                    </div>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const counters = document.querySelectorAll('.stat-number');
                const duration = 2500; // Durasi animasi 2.5 detik untuk efek lebih dramatis

                const animateCounters = () => {
                    counters.forEach(counter => {
                        const target = +counter.getAttribute('data-target');
                        let startTimestamp = null;
                        
                        const step = (timestamp) => {
                            if (!startTimestamp) startTimestamp = timestamp;
                            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                            
                            // Easing function: easeOutExpo untuk efek lambat di akhir
                            const easeOutExpo = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                            
                            counter.innerText = Math.floor(easeOutExpo * target);
                            
                            if (progress < 1) {
                                window.requestAnimationFrame(step);
                            } else {
                                counter.innerText = target;
                            }
                        };
                        
                        window.requestAnimationFrame(step);
                    });
                };

                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounters();
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });

                const section = document.getElementById('statistik-section');
                if (section) {
                    observer.observe(section);
                }
            });
        </script>

        <!-- 4. Gallery Marquee Section -->
        <section class="py-20 md:py-28 bg-white overflow-hidden">
            <div class="text-center mb-12 px-4">
                <h2 class="text-4xl md:text-5xl font-extrabold text-[#114045] mb-4">Fasilitas <span class="text-[#59A338]">Premium</span> Kami</h2>
                <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto font-medium">
                    Rasakan kenyamanan suasana dan kelengkapan fasilitas Mess FR Academy bahkan sebelum Anda tiba.
                </p>
            </div>

            <!-- Marquee Container -->
            <div class="relative w-full flex flex-col gap-6 md:gap-8">
                <!-- Baris 1: Scroll Kiri -->
                <div class="w-full overflow-hidden">
                    <div class="marquee-left gap-6 md:gap-8 px-3">
                        @php
                            $imagesRow1 = ['slides-5.jpg', 'slides-12.jpg', 'slides-7.jpg', 'slides-18.jpg', 'slides-9.jpg', 'slides-20.jpg', 'slides-25.jpg', 'slides-26.jpg'];
                        @endphp
                        @foreach(array_merge($imagesRow1, $imagesRow1) as $img)
                        <div class="flex-shrink-0 w-72 md:w-96 h-56 md:h-72 rounded-[1.5rem] md:rounded-[2rem] overflow-hidden group shadow-lg">
                            <img src="{{ asset('images/' . $img) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 cursor-pointer" alt="Gallery">
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Baris 2: Scroll Kanan -->
                <div class="w-full overflow-hidden">
                    <div class="marquee-right gap-6 md:gap-8 px-3">
                        @php
                            $imagesRow2 = ['slides-21.jpg', 'slides-14.jpg', 'slides-16.jpg', 'slides-23.jpg', 'slides-19.jpg', 'slides-11.jpg', 'slides-27.jpg', 'slides-28.jpg', 'slides-29.jpg'];
                        @endphp
                        @foreach(array_merge($imagesRow2, $imagesRow2) as $img)
                        <div class="flex-shrink-0 w-80 md:w-[28rem] h-56 md:h-72 rounded-[1.5rem] md:rounded-[2rem] overflow-hidden group shadow-lg">
                            <img src="{{ asset('images/' . $img) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 cursor-pointer" alt="Gallery">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Ekosistem Layanan Terpadu (Anti-Slop Editorial Flow) -->
        <section class="bg-[#F4F7F6] py-20 md:py-28" id="fasilitas">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <!-- Section Header -->
                <div class="max-w-3xl mb-16">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-[#114045]/5 text-[#114045] text-xs font-bold tracking-wider uppercase mb-4">
                        Ekosistem Layanan Residen
                    </span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-[#114045] tracking-tight leading-tight">
                        Standar Hunian Terpadu untuk Mendukung Intensitas Diklat
                    </h2>
                    <p class="mt-4 text-base md:text-lg text-gray-600 font-normal leading-relaxed">
                        Fasilitas Mess FR Academy dikelola secara profesional dengan operasional harian yang tertata, memastikan kebutuhan nutrisi, kebersihan, dan pemeliharaan kamar terpenuhi tanpa mengganggu jadwal pelatihan.
                    </p>
                </div>

                <!-- 3 Pillars Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Pilar 1: Dapur & Katering -->
                    <div class="bg-white rounded-2xl p-8 border border-gray-200/80 shadow-sm flex flex-col justify-between hover:border-[#59A338]/50 transition-colors">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-[#59A338]/10 text-[#59A338] flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-[#59A338] tracking-wider uppercase block mb-1">Gizi & Katering</span>
                            <h3 class="text-xl font-bold text-[#114045] mb-3">Katering Tiga Waktu</h3>
                            <p class="text-sm text-gray-600 leading-relaxed mb-6">
                                Jadwal menu makan pagi, siang, dan malam dengan standar higienis dan porsi terencana untuk memulihkan stamina peserta pelatihan.
                            </p>
                        </div>
                        <ul class="border-t border-gray-100 pt-4 space-y-2 text-xs font-medium text-gray-500">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#59A338]"></span>
                                Jadwal menu bergilir setiap pekan
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#59A338]"></span>
                                Survei mutu masakan berkala via portal
                            </li>
                        </ul>
                    </div>

                    <!-- Pilar 2: Laundry -->
                    <div class="bg-white rounded-2xl p-8 border border-gray-200/80 shadow-sm flex flex-col justify-between hover:border-[#59A338]/50 transition-colors">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-[#114045]/10 text-[#114045] flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-[#114045] tracking-wider uppercase block mb-1">Sanitasi Pakaian</span>
                            <h3 class="text-xl font-bold text-[#114045] mb-3">Layanan Laundry Terjadwal</h3>
                            <p class="text-sm text-gray-600 leading-relaxed mb-6">
                                Penanganan pencucian seragam dinas, pakaian lapangan, serta penggantian linen kamar berkala oleh staf operasional laundry.
                            </p>
                        </div>
                        <ul class="border-t border-gray-100 pt-4 space-y-2 text-xs font-medium text-gray-500">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#114045]"></span>
                                Permintaan cuci mandiri melalui akun tamu
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#114045]"></span>
                                Pengelolaan linen & handuk higienis
                            </li>
                        </ul>
                    </div>

                    <!-- Pilar 3: Respon Pemeliharaan -->
                    <div class="bg-white rounded-2xl p-8 border border-gray-200/80 shadow-sm flex flex-col justify-between hover:border-[#59A338]/50 transition-colors">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-[#59A338]/10 text-[#59A338] flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-[#59A338] tracking-wider uppercase block mb-1">Fasilitas & Pemeliharaan</span>
                            <h3 class="text-xl font-bold text-[#114045] mb-3">Respon Perbaikan Cepat</h3>
                            <p class="text-sm text-gray-600 leading-relaxed mb-6">
                                Sistem tiket perbaikan kamar langsung terhubung ke tim teknisi untuk penanganan kendala AC, kelistrikan, maupun sanitasi kamar.
                            </p>
                        </div>
                        <ul class="border-t border-gray-100 pt-4 space-y-2 text-xs font-medium text-gray-500">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#59A338]"></span>
                                Pelaporan kerusakan kamar instan
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#59A338]"></span>
                                Bukti foto penyelesaian dari teknisi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. Direktori Akomodasi (Showcase Horizontal Asimetris) -->
        <section id="kamar" class="py-20 md:py-28 bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
                    <div class="max-w-2xl">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-[#59A338]/10 text-[#59A338] text-xs font-bold tracking-wider uppercase mb-4">
                            Direktori Akomodasi
                        </span>
                        <h2 class="text-3xl md:text-5xl font-extrabold text-[#114045] tracking-tight leading-tight">
                            Spesifikasi & Kapasitas Hunian
                        </h2>
                        <p class="mt-3 text-base md:text-lg text-gray-600 font-normal">
                            Penetapan tipe kamar disesuaikan menurut strata pelatihan, kebutuhan staf, instruktur, hingga tamu pimpinan perusahaan.
                        </p>
                    </div>
                    <div class="hidden lg:flex items-center gap-6 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50 px-5 py-2.5 rounded-full border border-gray-100">
                        <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-[#114045]"></span> {{ $totalKamar ?? 72 }} Total Kamar</span>
                        <span class="w-px h-4 bg-gray-200"></span>
                        <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-[#59A338]"></span> {{ $totalLorong ?? 12 }} Lorong</span>
                    </div>
                </div>

                <!-- Showcase Direktori List -->
                <div class="flex flex-col gap-6 md:gap-8">
                    <!-- Tipe 1: Kamar Reguler -->
                    <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden grid grid-cols-1 lg:grid-cols-12 lg:min-h-[240px] transition-all hover:border-[#114045]/40 hover:shadow-md">
                        <div class="lg:col-span-5 h-56 sm:h-64 lg:h-auto relative overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/slides-15.jpg') }}" alt="Kamar Reguler Mess FR Academy" class="absolute inset-0 w-full h-full object-cover object-center">
                            <div class="absolute top-4 left-4 z-10 bg-[#114045] text-white text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                                Trainee & Staf Diklat
                            </div>
                        </div>
                        <div class="lg:col-span-7 p-6 sm:p-7 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-4 mb-2">
                                    <h3 class="text-xl sm:text-2xl font-bold text-[#114045]">Kamar Tipe Reguler</h3>
                                    <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-3 py-1 rounded-full border border-gray-200">Kapasitas 2 Orang</span>
                                </div>
                                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                    Tata ruang efisien dengan ranjang twin-bed terpisah, lemari pakaian individual, dan meja belajar mandiri untuk menunjang kebutuhan belajar mandiri dan istirahat pasca-pelatihan.
                                </p>
                            </div>
                            
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 mt-5 border-t border-gray-100 text-xs text-gray-700 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Twin Single Bed</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Meja Belajar Mandiri</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Lemari Pakaian</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Wi-Fi & Sirkulasi Alami</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tipe 2: Kamar Executive -->
                    <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden grid grid-cols-1 lg:grid-cols-12 lg:min-h-[240px] transition-all hover:border-[#114045]/40 hover:shadow-md">
                        <div class="lg:col-span-5 h-56 sm:h-64 lg:h-auto relative overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/slides-23.jpg') }}" alt="Kamar Executive Mess FR Academy" class="absolute inset-0 w-full h-full object-cover object-center">
                            <div class="absolute top-4 left-4 z-10 bg-[#59A338] text-white text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                                Instruktur & Tamu Dinas
                            </div>
                        </div>
                        <div class="lg:col-span-7 p-6 sm:p-7 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-4 mb-2">
                                    <h3 class="text-xl sm:text-2xl font-bold text-[#114045]">Kamar Tipe Executive</h3>
                                    <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-3 py-1 rounded-full border border-gray-200">Kapasitas 1 - 2 Orang</span>
                                </div>
                                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                    Kenyamanan privat berbalut interior modern dengan ranjang Queen-size, pendingin udara split, kamar mandi dalam, dan ruang kerja pribadi untuk menunjang persiapan pelatihan tingkat manajerial.
                                </p>
                            </div>
                            
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 mt-5 border-t border-gray-100 text-xs text-gray-700 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Queen-size Bed</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>AC Split & Smart TV</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Kamar Mandi Dalam</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Meja Kerja Eksklusif</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tipe 3: Guest House -->
                    <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden grid grid-cols-1 lg:grid-cols-12 lg:min-h-[240px] transition-all hover:border-[#114045]/40 hover:shadow-md">
                        <div class="lg:col-span-5 h-56 sm:h-64 lg:h-auto relative overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/slides-25.jpg') }}" alt="Guest House VIP Mess FR Academy" class="absolute inset-0 w-full h-full object-cover object-center">
                            <div class="absolute top-4 left-4 z-10 bg-[#114045] text-white text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                                VIP & Pimpinan Perusahaan
                            </div>
                        </div>
                        <div class="lg:col-span-7 p-6 sm:p-7 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-4 mb-2">
                                    <h3 class="text-xl sm:text-2xl font-bold text-[#114045]">Unit Guest House Mandiri</h3>
                                    <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-3 py-1 rounded-full border border-gray-200">Kapasitas 4 - 6 Orang</span>
                                </div>
                                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                    Akomodasi berkonsep hunian privat terpisah dengan ruang tamu keluarga yang luas, dapur dan kulkas pribadi, kamar tidur ganda ber-AC, serta area parkir mobil mandiri tepat di depan teras.
                                </p>
                            </div>
                            
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 mt-5 border-t border-gray-100 text-xs text-gray-700 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Rumah Mandiri Privat</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Living Room & TV</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Dapur & Kulkas Pribadi</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Area Parkir Khusus</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>

        <!-- 8. Footer (Prestisius & Terpadu) -->
        <footer class="bg-white pt-8 pb-14 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl xl:max-w-[1400px] mx-auto">
                <!-- Rounded Island Container -->
                <div class="relative bg-[#114045] rounded-[2rem] md:rounded-[2.75rem] px-8 sm:px-12 lg:px-14 py-12 sm:py-14 text-white overflow-hidden shadow-2xl">
                    
                    <!-- Motif Watermark Pattern (Pola Kelapa Sawit Otentik Khas First Resources) -->
                    <div class="absolute bottom-0 left-0 right-0 h-24 sm:h-28 pointer-events-none opacity-[0.09] overflow-hidden">
                        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="footer-motif" width="160" height="95" patternUnits="userSpaceOnUse">
                                    <!-- Batang Kelapa Sawit Bertekstur Sisik Pelepah -->
                                    <g fill="white" fill-opacity="0.9" stroke="white" stroke-width="0.8">
                                        <path d="M72,70 L70,92 L90,92 L88,70 Z" />
                                        <path d="M70,88 L80,83 L90,88 M71,83 L80,78 L89,83 M72,78 L80,73 L88,78" fill="none" stroke="#114045" stroke-width="1.3" />
                                        
                                        <!-- Tandan Buah Kelapa Sawit (Kiri, Tengah, Kanan) -->
                                        <ellipse cx="73" cy="67" rx="4.5" ry="5.5" fill="white" />
                                        <circle cx="72" cy="65" r="1.2" fill="#114045" />
                                        <circle cx="74" cy="67" r="1.2" fill="#114045" />
                                        <circle cx="72" cy="69" r="1.2" fill="#114045" />

                                        <ellipse cx="87" cy="67" rx="4.5" ry="5.5" fill="white" />
                                        <circle cx="88" cy="65" r="1.2" fill="#114045" />
                                        <circle cx="86" cy="67" r="1.2" fill="#114045" />
                                        <circle cx="88" cy="69" r="1.2" fill="#114045" />

                                        <ellipse cx="80" cy="63" rx="5.5" ry="6.5" fill="white" />
                                        <circle cx="78" cy="61" r="1.2" fill="#114045" />
                                        <circle cx="82" cy="61" r="1.2" fill="#114045" />
                                        <circle cx="80" cy="65" r="1.2" fill="#114045" />
                                    </g>

                                    <!-- Mahkota Pelepah Daun Kelapa Sawit (Menyirip Melengkung Khas Kelapa Sawit) -->
                                    <g stroke="white" stroke-width="1.3" fill="none" stroke-linecap="round" stroke-linejoin="round" opacity="0.9">
                                        <!-- Pelepah 1: Pusat Menjulang -->
                                        <path d="M80,60 Q80,36 80,10" />
                                        <path d="M80,15 L75,11 M80,15 L85,11 M80,24 L73,19 M80,24 L87,19 M80,33 L71,27 M80,33 L89,27 M80,42 L71,36 M80,42 L89,36 M80,51 L73,46 M80,51 L87,46" />

                                        <!-- Pelepah 2: Kiri Atas Melengkung -->
                                        <path d="M78,60 Q70,34 52,18" />
                                        <path d="M56,22 L52,17 M60,27 L55,20 M65,33 L59,25 M69,39 L62,31 M73,47 L66,39 M62,30 L66,23 M67,36 L72,28 M72,42 L77,34" />

                                        <!-- Pelepah 3: Kanan Atas Melengkung -->
                                        <path d="M82,60 Q90,34 108,18" />
                                        <path d="M104,22 L108,17 M100,27 L105,20 M95,33 L101,25 M91,39 L98,31 M87,47 L94,39 M98,30 L94,23 M93,36 L88,28 M88,42 L83,34" />

                                        <!-- Pelepah 4: Kiri Tengah Melebar -->
                                        <path d="M76,62 Q58,42 32,34" />
                                        <path d="M38,36 L32,31 M46,39 L41,32 M54,44 L49,36 M62,50 L57,41 M70,56 L65,47 M42,39 L46,46 M50,43 L55,51 M58,48 L63,57" />

                                        <!-- Pelepah 5: Kanan Tengah Melebar -->
                                        <path d="M84,62 Q102,42 128,34" />
                                        <path d="M122,36 L128,31 M114,39 L119,32 M106,44 L111,36 M98,50 L103,41 M90,56 L95,47 M118,39 L114,46 M110,43 L105,51 M102,48 L97,57" />

                                        <!-- Pelepah 6: Kiri Bawah Menjuntai -->
                                        <path d="M74,65 Q50,57 22,60" />
                                        <path d="M28,59 L22,54 M37,60 L31,54 M47,62 L41,55 M58,64 L52,56 M34,60 L38,67 M44,61 L48,69 M54,63 L58,71" />

                                        <!-- Pelepah 7: Kanan Bawah Menjuntai -->
                                        <path d="M86,65 Q110,57 138,60" />
                                        <path d="M132,59 L138,54 M123,60 L129,54 M113,62 L119,55 M102,64 L108,56 M126,60 L122,67 M116,61 L112,69 M106,63 L102,71" />
                                    </g>
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#footer-motif)" />
                        </svg>
                    </div>

                    <!-- Content Grid: 12 Columns -->
                    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-start">
                        
                        <!-- Kolom 1: Statement Headline, Social Media, & Kontak (Col Span 5) -->
                        <div class="lg:col-span-5 flex flex-col justify-between">
                            <div>
                                <!-- Headline Utama -->
                                <h2 class="text-3xl sm:text-4xl lg:text-[2.35rem] font-extrabold text-white tracking-tight leading-[1.2] mb-6">
                                    Hunian Terpadu Penunjang<br>
                                    <span class="relative inline-block pb-2">
                                        Fokus & Prestasi
                                        <span class="absolute bottom-0 left-0 w-full h-1 bg-[#59A338] rounded-full"></span>
                                    </span>
                                </h2>

                                <!-- Ikon Sosial / Kanal Media (Bulat Outline) -->
                                <div class="flex items-center gap-3 mb-8">
                                    <!-- Instagram -->
                                    <a href="https://www.instagram.com/growwithfr" target="_blank" rel="noopener noreferrer" aria-label="Instagram First Resources (@growwithfr)" class="w-10 h-10 rounded-full border border-white/40 flex items-center justify-center text-white hover:bg-white hover:text-[#114045] hover:border-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    </a>
                                    <!-- LinkedIn -->
                                    <a href="https://www.linkedin.com/company/first-resources-limited" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn First Resources Limited" class="w-10 h-10 rounded-full border border-white/40 flex items-center justify-center text-white hover:bg-white hover:text-[#114045] hover:border-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    </a>
                                    <!-- Facebook -->
                                    <a href="https://www.facebook.com/grow.with.fr/" target="_blank" rel="noopener noreferrer" aria-label="Facebook Grow With FR" class="w-10 h-10 rounded-full border border-white/40 flex items-center justify-center text-white hover:bg-white hover:text-[#114045] hover:border-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                                    </a>
                                    <!-- YouTube -->
                                    <a href="https://www.youtube.com/@GrowWithFR" target="_blank" rel="noopener noreferrer" aria-label="YouTube First Resources (@GrowWithFR)" class="w-10 h-10 rounded-full border border-white/40 flex items-center justify-center text-white hover:bg-white hover:text-[#114045] hover:border-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Alamat Fisik & Kontak Langsung -->
                            <div class="space-y-2.5 text-xs sm:text-sm text-gray-200">
                                <!-- Alamat -->
                                <div class="flex items-start gap-2.5">
                                    <svg class="w-4 h-4 text-[#59A338] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="leading-relaxed">Learning Center First Resources, Riau, Indonesia</span>
                                </div>
                                <!-- Telepon & Email -->
                                <div class="flex flex-col sm:flex-row sm:items-center gap-x-5 gap-y-1.5 pt-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <span>(0761) – 53939 <span class="text-white/40">atau</span> 0811 758 0101</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#59A338] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <a href="mailto:academy@first-resources.com" class="hover:text-white transition-colors underline-offset-2 hover:underline">academy@first-resources.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom 2: Navigasi Layanan & Portal (Col Span 4) -->
                        <div class="lg:col-span-4 grid grid-cols-2 gap-6 lg:gap-8 pt-2">
                            <!-- Subkolom 1: Layanan Mess -->
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-white mb-4 tracking-wide">Layanan Mess</h3>
                                <ul class="space-y-2.5 text-xs sm:text-sm text-gray-200">
                                    <li>
                                        <a href="#fasilitas" class="hover:text-[#59A338] transition-colors">Katering Tiga Waktu</a>
                                    </li>
                                    <li>
                                        <a href="#fasilitas" class="hover:text-[#59A338] transition-colors">Manajemen Laundry</a>
                                    </li>
                                    <li>
                                        <a href="#fasilitas" class="hover:text-[#59A338] transition-colors">Perbaikan Kamar</a>
                                    </li>
                                    <li>
                                        <a href="#kamar" class="hover:text-[#59A338] transition-colors">Direktori Tipe Kamar</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Subkolom 2: Akses Sistem -->
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-white mb-4 tracking-wide">Akses Sistem</h3>
                                <ul class="space-y-2.5 text-xs sm:text-sm text-gray-200">
                                    <li>
                                        <a href="#hero-slider" class="hover:text-[#59A338] transition-colors">Portal Tamu & Trainee</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('login') }}" class="hover:text-[#59A338] transition-colors">Masuk Staf Mess</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/admin/dashboard') }}" class="hover:text-[#59A338] transition-colors">Command Center</a>
                                    </li>
                                    <li>
                                        <a href="https://first-resources.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#59A338] transition-colors">First Resources Group</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Kolom 3: Peta Lokasi Mess Interaktif (Col Span 3) -->
                        <div class="lg:col-span-3 pt-2">
                            <h3 class="text-sm sm:text-base font-bold text-white mb-4 tracking-wide">Lokasi Mess</h3>
                            <div class="w-full h-44 rounded-2xl overflow-hidden border border-white/20 shadow-md relative bg-gray-900">
                                <iframe 
                                    src="https://maps.google.com/maps?q=Learning+Center+First+Resources&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade"
                                    class="w-full h-full filter saturate-[0.9] contrast-[1.05]">
                                </iframe>
                            </div>
                            <a href="https://maps.app.goo.gl/cydFmxfJTyqwfoBMA" target="_blank" rel="noopener noreferrer" class="mt-3.5 inline-flex items-center gap-2 text-xs font-semibold text-gray-200 hover:text-white transition-colors group">
                                <span class="w-2 h-2 rounded-full bg-[#59A338]"></span>
                                <span>Buka di Google Maps</span>
                                <svg class="w-3.5 h-3.5 text-[#59A338] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>

                    </div>
                </div>

                <!-- Sub-Footer / Copyright & Scroll to Top Sesuai Standar FR Academy -->
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-4 px-2">
                    <p class="text-center sm:text-left">&copy; {{ date('Y') }} Learning Center First Resources (FR Academy). Seluruh hak cipta dilindungi.</p>
                    <a href="#hero-slider" aria-label="Kembali ke atas" class="inline-flex items-center gap-2 font-medium text-[#114045] hover:text-[#59A338] transition-colors group">
                        <span class="hidden sm:inline text-xs font-semibold">Kembali ke atas</span>
                        <div class="w-8 h-8 rounded-full bg-[#114045] group-hover:bg-[#59A338] text-white flex items-center justify-center transition-all shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
                        </div>
                    </a>
                </div>
            </div>
        </footer>

    </body>
</html>