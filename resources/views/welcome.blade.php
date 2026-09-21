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
                        <p class="text-4xl md:text-5xl font-extrabold text-[#59A338]"><span class="stat-number" data-target="51">0</span></p>
                        <p class="text-gray-200 mt-3 font-medium tracking-wide">Kamar Nyaman</p>
                    </div>
                    <div class="py-4">
                        <p class="text-4xl md:text-5xl font-extrabold text-[#59A338]"><span class="stat-number" data-target="100">0</span>+</p>
                        <p class="text-gray-200 mt-3 font-medium tracking-wide">Kapasitas Trainee</p>
                    </div>
                    <div class="py-4">
                        <p class="text-4xl md:text-5xl font-extrabold text-[#59A338]"><span class="stat-number" data-target="12">0</span></p>
                        <p class="text-gray-200 mt-3 font-medium tracking-wide">Lorong Terintegrasi</p>
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

        <!-- 5. Intro & Digital Service Flow (Soft Gray) -->
        <section class="bg-[#F4F7F6] py-24">
            <!-- Kutipan Intro -->
            <div class="max-w-4xl mx-auto text-center px-4 mb-24">
                <svg class="w-10 h-10 mx-auto text-[#59A338] mb-6 opacity-80" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-medium text-[#114045] leading-relaxed italic mb-8">
                    "Lebih dari sekadar tempat singgah. Kami memadukan layanan kebersihan prima dan katering berkualitas tinggi untuk memulihkan energi Anda sepenuhnya."
                </h2>
                <div class="w-20 h-1 bg-[#59A338] mx-auto rounded-full"></div>
            </div>

            <!-- Alur Layanan Digital -->
            <div class="max-w-7xl mx-auto px-6 lg:px-8" id="fasilitas">
                <!-- Header Section -->
                <div class="text-center mb-16 max-w-3xl mx-auto">
                    <h2 class="text-4xl font-bold text-[#114045] mb-6 tracking-tight">Kemudahan Dalam Genggaman</h2>
                    <p class="text-lg text-gray-500 leading-relaxed">
                        Akses seluruh layanan Mess FR Academy langsung dari smartphone Anda.
                    </p>
                </div>

                <!-- Grid Flow (Cards) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                    
                    <!-- Item 1: Login -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 rounded-full bg-[#eaf4e6] text-[#59A338] flex items-center justify-center mb-6 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#114045] mb-3">1. Login Praktis</h3>
                        <p class="text-gray-500 leading-relaxed">
                            Cukup gunakan Nomor HP yang terdaftar saat check-in, tanpa perlu repot menghafal password.
                        </p>
                    </div>

                    <!-- Item 2: Pesan Layanan -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 rounded-full bg-[#eaf4e6] text-[#59A338] flex items-center justify-center mb-6 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#114045] mb-3">2. Pesan Layanan</h3>
                        <p class="text-gray-500 leading-relaxed">
                            Pesan layanan laundry atau laporkan kendala fasilitas kamar hanya dengan beberapa klik.
                        </p>
                    </div>

                    <!-- Item 3: Beri Penilaian -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 rounded-full bg-[#eaf4e6] text-[#59A338] flex items-center justify-center mb-6 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#114045] mb-3">3. Beri Penilaian</h3>
                        <p class="text-gray-500 leading-relaxed">
                            Bantu kami menjaga kualitas dengan memberikan rating masakan dapur dan kebersihan kamar Anda.
                        </p>
                    </div>
                    
                </div>
            </div>
        </section>

        <!-- 6. Pilihan Kamar -->
        <section id="kamar" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#114045] mb-4">Temukan Kenyamanan Anda</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Kami menyediakan berbagai tipe kamar yang disesuaikan dengan tingkat jabatan dan kebutuhan istirahat Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                    <!-- Card 1: Reguler -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('images/slides-15.jpg') }}" alt="Kamar Reguler" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-bold text-[#114045]">
                            Tersedia
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-[#114045] mb-3">Kamar Reguler</h3>
                        <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                            Kamar berdesain minimalis yang nyaman untuk staf dengan fasilitas lengkap pendukung kerja.
                        </p>
                        <div class="flex items-center gap-6 mb-8">
                            <div class="flex items-center text-sm font-medium text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                2 Orang
                            </div>
                            <div class="flex items-center text-sm font-medium text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                                Kipas Angin & Wi-Fi
                            </div>
                        </div>
                        <a href="#hero-slider" class="block text-center w-full py-3.5 rounded-xl bg-[#114045] text-white font-semibold hover:bg-[#0a282c] transition-colors">
                            Login untuk Reservasi
                        </a>
                    </div>
                </div>

                <!-- Card 2: Executive -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('images/slides-23.jpg') }}" alt="Kamar Executive" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute top-4 right-4 bg-[#59A338] text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">Premium</div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-[#114045] mb-2">Kamar Executive</h3>
                            <p class="text-gray-500 text-sm mb-6 line-clamp-2">Spasi ekstra lebar dengan ranjang ukuran Queen dan meja kerja privat berbalut interior elegan.</p>
                            
                            <div class="flex items-center gap-4 mb-8">
                                <div class="flex items-center gap-1.5 text-gray-600 text-sm font-medium">
                                    <svg class="w-5 h-5 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    2 Orang
                                </div>
                                <div class="flex items-center gap-1.5 text-gray-600 text-sm font-medium">
                                    <svg class="w-5 h-5 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    TV & AC
                                </div>
                            </div>

                            <a href="#hero-slider" class="block text-center w-full py-3.5 rounded-xl bg-[#114045] text-white font-semibold hover:bg-[#0a282c] transition-colors">
                                Login untuk Reservasi
                            </a>
                        </div>
                    </div>

                    <!-- Card 3: Guest House -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl transition-all duration-300 group">
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ asset('images/slides-25.jpg') }}" alt="Guest House" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute top-4 right-4 bg-[#59A338] text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">Premium</div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-[#114045] mb-2">Guest House</h3>
                            <p class="text-gray-500 text-sm mb-6 line-clamp-2">Fasilitas rumah tamu eksklusif dengan ruang tamu yang luas dan dapur pribadi untuk kenyamanan beristirahat maksimal.</p>
                            
                            <div class="flex items-center gap-4 mb-8">
                                <div class="flex items-center gap-1.5 text-gray-600 text-sm font-medium">
                                    <svg class="w-5 h-5 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    4 Orang
                                </div>
                                <div class="flex items-center gap-1.5 text-gray-600 text-sm font-medium">
                                    <svg class="w-5 h-5 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    AC & Kulkas
                                </div>
                            </div>

                            <a href="#hero-slider" class="block text-center w-full py-3.5 rounded-xl bg-[#114045] text-white font-semibold hover:bg-[#0a282c] transition-colors">
                                Login untuk Reservasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. Footer -->
        <footer class="bg-[#114045] text-white py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                    <div class="md:col-span-2">
                        <span class="text-2xl font-extrabold tracking-tight text-white mb-4 block">MESS <span class="text-[#59A338]">FR ACADEMY</span></span>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                            Sistem Manajemen Properti terpadu untuk menunjang kebutuhan akomodasi dan fasilitas peserta pelatihan di First Resources.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-4">Tautan Pantas</h4>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Beranda</a></li>
                            <li><a href="#fasilitas" class="hover:text-white transition-colors">Fasilitas Kami</a></li>
                            <li><a href="#kamar" class="hover:text-white transition-colors">Tipe Kamar</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Portal Staf</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-4">Lokasi Kami</h4>
                        <div class="w-full h-40 rounded-xl overflow-hidden shadow-sm border border-white/10 mb-3 relative">
                            <!-- Google Maps Embed -->
                            <iframe 
                                src="https://maps.google.com/maps?q=Learning+Center+First+Resources&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <a href="https://maps.app.goo.gl/cydFmxfJTyqwfoBMA" target="_blank" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                            <svg class="w-4 h-4 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
                <div class="border-t border-white/10 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                    <p>&copy; {{ date('Y') }} Mess FR Academy. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </body>
</html>