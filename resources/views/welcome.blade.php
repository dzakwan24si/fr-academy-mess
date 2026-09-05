<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mess FR Academy</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-800 bg-[#F8F9FA]">

        <!-- 1. Fixed Header -->
        <header class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Nav Kiri -->
                    <nav class="hidden md:flex space-x-8">
                        <a href="#" class="text-sm font-semibold text-[#114045] hover:text-[#59A338] transition-colors">Beranda</a>
                        <a href="#fasilitas" class="text-sm font-medium text-gray-500 hover:text-[#59A338] transition-colors">Fasilitas</a>
                        <a href="#kamar" class="text-sm font-medium text-gray-500 hover:text-[#59A338] transition-colors">Kamar</a>
                    </nav>

                    <!-- Logo Tengah -->
                    <div class="flex-shrink-0 flex items-center justify-center absolute left-1/2 -translate-x-1/2">
                        <span class="text-xl font-extrabold tracking-tight text-[#114045]">MESS <span class="text-[#59A338]">FR ACADEMY</span></span>
                    </div>

                    <!-- Tombol Kanan -->
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-[#114045] hover:text-[#59A338]">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-full text-sm font-semibold text-white bg-[#114045] hover:bg-[#0c2f33] transition-all shadow-md shadow-[#114045]/20">
                                    Login Staf
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- 2. Hero Section -->
        <section class="relative pt-28 pb-10">
            <!-- Container Melengkung -->
            <div class="mx-4 md:mx-10 relative h-[600px] md:h-[700px] rounded-[3rem] md:rounded-[4rem] overflow-hidden group shadow-2xl">
                <!-- Background Image -->
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=2000" alt="Mess FR Academy" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000 ease-in-out">
                
                <!-- Overlay Hitam -->
                <div class="absolute inset-0 bg-black/40 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                
                <!-- Konten Hero -->
                <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center">
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight mb-6 drop-shadow-lg max-w-4xl leading-tight">
                        Kenyamanan Anda,<br>
                        <span class="text-[#59A338]">Prioritas Kami.</span>
                    </h1>
                    <p class="mt-2 max-w-2xl text-lg md:text-xl text-gray-200 font-medium drop-shadow-md">
                        Hunian terintegrasi dengan fasilitas lengkap untuk mendukung fokus pelatihan Anda selama berada di FR Academy.
                    </p>
                </div>

                <!-- 3. Floating Check-in / Login Box -->
                <div class="absolute -bottom-8 md:-bottom-10 left-1/2 -translate-x-1/2 z-40 w-11/12 max-w-4xl">
                    <div class="bg-white rounded-2xl md:rounded-full shadow-2xl p-4 md:p-3 border border-gray-100 flex flex-col md:flex-row items-center gap-4">
                        <div class="flex-1 w-full flex items-center px-4 bg-gray-50 rounded-xl md:rounded-full py-3 md:py-0 h-full">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <input type="text" placeholder="Masukkan Nomor HP Anda (Tamu)..." class="w-full bg-transparent border-none focus:ring-0 text-gray-700 placeholder-gray-400 font-medium">
                        </div>
                        <button class="w-full md:w-auto px-8 py-4 rounded-xl md:rounded-full text-white font-bold bg-[#59A338] hover:bg-[#4d8c2f] transition-colors shadow-lg shadow-[#59A338]/30 flex-shrink-0 flex items-center justify-center gap-2">
                            Masuk Portal Tamu
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Intro & Testimonial Section -->
        <section class="pt-24 md:pt-32 pb-20 px-4">
            <div class="max-w-4xl mx-auto text-center">
                <svg class="w-10 h-10 mx-auto text-[#59A338] mb-6 opacity-80" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-medium text-[#114045] leading-relaxed italic mb-8">
                    "Lebih dari sekadar tempat singgah. Kami memadukan layanan kebersihan prima dan katering berkualitas tinggi untuk memulihkan energi Anda sepenuhnya."
                </h2>
                <div class="w-20 h-1 bg-[#59A338] mx-auto rounded-full"></div>
            </div>
        </section>

        <!-- 5. Features (Bento Grid Style) -->
        <section id="fasilitas" class="py-16 px-4 md:px-10 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 h-auto md:h-[600px]">
                
                <!-- Fitur 1: Kamar -->
                <div class="relative rounded-3xl overflow-hidden group h-96 md:h-full">
                    <img src="https://images.unsplash.com/photo-1522771731478-44eb10e536ad?auto=format&fit=crop&q=80&w=800" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#114045]/90 via-[#114045]/40 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-8 flex flex-col justify-end">
                        <h3 class="text-2xl font-bold text-white mb-2">Kenyamanan Kamar</h3>
                        <p class="text-gray-200 text-sm mb-6 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">Desain interior ergonomis dengan AC dan Wi-Fi cepat.</p>
                        <button class="w-max px-6 py-2.5 rounded-full border border-white text-white text-sm font-semibold hover:bg-white hover:text-[#114045] transition-colors">
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <!-- Fitur 2: Dapur -->
                <div class="relative rounded-3xl overflow-hidden group h-96 md:h-full md:mt-8">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&q=80&w=800" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-8 flex flex-col justify-end">
                        <h3 class="text-2xl font-bold text-white mb-2">Dapur & Katering</h3>
                        <p class="text-gray-200 text-sm mb-6 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">Menu bergizi yang disiapkan segar setiap harinya.</p>
                        <button class="w-max px-6 py-2.5 rounded-full border border-white text-white text-sm font-semibold hover:bg-[#59A338] hover:border-[#59A338] transition-colors">
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <!-- Fitur 3: Laundry -->
                <div class="relative rounded-3xl overflow-hidden group h-96 md:h-full">
                    <img src="https://images.unsplash.com/photo-1582735689151-c112635ce13e?auto=format&fit=crop&q=80&w=800" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#114045]/90 via-[#114045]/40 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-8 flex flex-col justify-end">
                        <h3 class="text-2xl font-bold text-white mb-2">Layanan Laundry</h3>
                        <p class="text-gray-200 text-sm mb-6 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">Penanganan pakaian profesional, cepat dan bersih.</p>
                        <button class="w-max px-6 py-2.5 rounded-full border border-white text-white text-sm font-semibold hover:bg-white hover:text-[#114045] transition-colors">
                            Lihat Detail
                        </button>
                    </div>
                </div>

            </div>
        </section>

        <!-- 6. Pilihan Kamar -->
        <section id="kamar" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#114045] mb-4">Temukan Kenyamanan Anda</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Kami menyediakan berbagai tipe kamar yang disesuaikan dengan tingkat jabatan dan kebutuhan istirahat Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto">
                    <!-- Tipe Reguler -->
                    <div class="group rounded-3xl bg-[#F8F9FA] overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-300">
                        <div class="h-64 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-[#114045]">Tersedia</div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-[#114045] mb-2">Kamar Reguler</h3>
                            <p class="text-gray-500 text-sm mb-6 line-clamp-2">Kamar berdesain minimalis yang nyaman untuk staf dengan fasilitas lengkap pendukung kerja.</p>
                            
                            <div class="flex items-center gap-4 mb-8">
                                <div class="flex items-center gap-1.5 text-gray-600 text-sm font-medium">
                                    <svg class="w-5 h-5 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    1 Orang
                                </div>
                                <div class="flex items-center gap-1.5 text-gray-600 text-sm font-medium">
                                    <svg class="w-5 h-5 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                                    AC & Wi-Fi
                                </div>
                            </div>

                            <button class="w-full py-3 rounded-xl bg-[#114045] text-white font-semibold hover:bg-[#0c2f33] transition-colors">
                                Lihat Galeri
                            </button>
                        </div>
                    </div>

                    <!-- Tipe Executive -->
                    <div class="group rounded-3xl bg-[#F8F9FA] overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-300">
                        <div class="h-64 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                                    TV & Kulkas
                                </div>
                            </div>

                            <button class="w-full py-3 rounded-xl bg-white border-2 border-[#114045] text-[#114045] font-semibold hover:bg-gray-50 transition-colors">
                                Lihat Galeri
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. Footer -->
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
                        <h4 class="font-bold text-lg mb-4">Hubungi Kami</h4>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>FR Academy Mess Complex<br>Pekanbaru, Riau, Indonesia</span>
                            </li>
                            <li class="flex items-center gap-2 mt-2">
                                <svg class="w-5 h-5 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>+62 123 4567 890</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-white/10 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                    <p>&copy; {{ date('Y') }} Mess FR Academy. All rights reserved.</p>
                    <p class="mt-2 md:mt-0">Designed for First Resources</p>
                </div>
            </div>
        </footer>

    </body>
</html>
