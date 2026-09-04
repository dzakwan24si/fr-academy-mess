<x-layouts.app>
<div class="bg-[#F8F9FA] min-h-screen font-sans selection:bg-[#59A338] selection:text-white">
    <!-- 1. Header -->
    <header 
        x-data="{ scrolled: false }"
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="{'bg-[#114045] shadow-lg py-3': scrolled, 'bg-gradient-to-b from-black/70 to-transparent py-4 border-b border-white/10': !scrolled}"
        class="fixed top-0 left-0 w-full z-50 px-6 md:px-12 flex justify-between items-center transition-all duration-300"
    >
        <!-- Logo -->
        <div class="flex items-center gap-3">
            <img src="{{ asset('logofr.png') }}" alt="Logo FR" class="h-10 w-auto object-contain">
            <span class="text-white font-bold text-xl tracking-wide drop-shadow-md">FR ACADEMY</span>
        </div>
        
        <!-- Center Nav (Desktop Only) -->
        <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold text-white/90 tracking-wider">
            <a href="#" class="hover:text-white transition-colors">BERANDA</a>
            <a href="#tentang" class="hover:text-white transition-colors">TENTANG</a>
            <a href="#kamar" class="hover:text-white transition-colors">KAMAR</a>
            <a href="#fasilitas" class="hover:text-white transition-colors">FASILITAS</a>
        </nav>

        <!-- Right Side -->
        <div class="flex items-center gap-6">
            <a href="{{ route('login') }}" class="bg-[#59A338] hover:bg-green-600 text-white font-semibold py-2 px-6 rounded shadow-lg transition-all duration-300">Masuk Portal</a>
        </div>
    </header>

    <!-- 2. Hero Section (Slider) -->
    <section 
        x-data="{ 
            activeSlide: 0, 
            slides: [
                '{{asset('slides-1.jpg')}}',
                '{{asset('slides-2.jpg')}}',
                '{{asset('slides-3.jpg')}}',
                '{{asset('slides-4.jpg')}}'
            ],
            next() { this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1 },
            prev() { this.activeSlide = this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1 },
            init() { setInterval(() => this.next(), 5000) }
        }" 
        class="relative h-screen min-h-[700px] flex items-center justify-center overflow-hidden"
    >
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div 
                x-show="activeSlide === index" 
                x-transition:enter="transition ease-out duration-1000" 
                x-transition:enter-start="opacity-0 scale-105" 
                x-transition:enter-end="opacity-100 scale-100" 
                x-transition:leave="transition ease-in duration-1000" 
                x-transition:leave-start="opacity-100 scale-100" 
                x-transition:leave-end="opacity-0 scale-105" 
                class="absolute inset-0 z-0"
            >
                <img :src="slide" alt="Mess Facilities" class="w-full h-full object-cover">
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-black/65"></div>
            </div>
        </template>
        
        <!-- Slider Controls: Arrows -->
        <button @click="prev()" class="absolute left-4 md:left-10 z-20 w-12 h-12 flex items-center justify-center rounded-full bg-black/20 text-white/70 hover:bg-black/50 hover:text-white border border-white/10 transition-all backdrop-blur-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="next()" class="absolute right-4 md:right-10 z-20 w-12 h-12 flex items-center justify-center rounded-full bg-black/20 text-white/70 hover:bg-black/50 hover:text-white border border-white/10 transition-all backdrop-blur-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Slider Controls: Dots -->
        <div class="absolute bottom-10 z-20 flex gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" :class="{'bg-[#59A338] w-8': activeSlide === index, 'bg-white/50 w-2 hover:bg-white': activeSlide !== index}" class="h-2 rounded-full transition-all duration-300"></button>
            </template>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto mt-16">
            <!-- Pill -->
            <div class="inline-block px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white text-xs font-bold tracking-widest uppercase mb-8 backdrop-blur-sm">
                First Resources Academy Mess
            </div>
            
            <!-- Main Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 drop-shadow-lg leading-tight tracking-tight">
                Kenyamanan Anda, <br class="hidden md:block">
                Prioritas Utama <span class="text-[#59A338]">Pelayanan Kami</span>
            </h1>
            
            <p class="text-[#59A338] font-semibold text-lg md:text-xl mb-6 tracking-wide drop-shadow-md">
                "Mess Itu Sebaik Pelayanannya."
            </p>
            
            <!-- Description -->
            <p class="text-base md:text-lg text-gray-200 mb-10 drop-shadow-md font-light leading-relaxed max-w-3xl mx-auto">
                FR Academy Mess hadir sebagai pusat hunian yang terintegrasi, memberikan pengalaman istirahat terbaik dan fasilitas penunjang lengkap untuk para peserta pelatihan.
            </p>
            
            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('guest.login') }}" class="bg-[#59A338] hover:bg-green-600 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition-all duration-300 text-lg border border-transparent">
                    Login Tamu
                </a>
                <a href="#tentang" class="bg-black/30 hover:bg-black/50 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition-all duration-300 text-lg border border-white/30 backdrop-blur-sm">
                    Lihat Fasilitas
                </a>
            </div>
        </div>
    </section>

    <!-- 3. About Us Section -->
    <section class="py-20 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <div class="lg:w-1/2">
                <div class="inline-block px-4 py-1.5 rounded-full bg-green-100 text-[#59A338] font-semibold text-sm mb-6 uppercase tracking-wider">Tentang Kami</div>
                <h2 class="text-3xl md:text-4xl font-bold text-[#114045] mb-6">Lebih Dari Sekadar Tempat Singgah</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    Terletak di kawasan rindang seluas 300 hektare, Mess FR Academy dirancang khusus untuk memberikan pengalaman istirahat terbaik bagi para peserta pelatihan dan tamu perusahaan. Kami memadukan layanan kebersihan prima, katering berkualitas, dan asri alam untuk memulihkan energi Anda.
                </p>
            </div>
            <div class="lg:w-1/2 w-full">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <img src="https://i.ibb.co.com/hFZ1CScS/slides-6.jpg" alt="Lounge Area" class="w-full h-[400px] object-cover hover:scale-105 transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Features Section -->
    <section class="bg-[#114045] py-20 px-6 md:px-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="p-6 bg-teal-950/40 rounded-xl border border-teal-800/50 hover:bg-teal-900/60 transition-colors">
                    <div class="w-14 h-14 bg-teal-900 rounded-lg flex items-center justify-center mb-6 text-[#59A338]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Layanan Kebersihan Harian</h3>
                    <p class="text-teal-100/70">Kamar Anda selalu rapi dan bersih setiap saat berkat layanan tata graha profesional kami.</p>
                </div>
                <!-- Feature 2 -->
                <div class="p-6 bg-teal-950/40 rounded-xl border border-teal-800/50 hover:bg-teal-900/60 transition-colors">
                    <div class="w-14 h-14 bg-teal-900 rounded-lg flex items-center justify-center mb-6 text-[#59A338]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Laundry Cepat & Praktis</h3>
                    <p class="text-teal-100/70">Pakaian bersih tepat waktu untuk menunjang jadwal kegiatan Anda yang padat.</p>
                </div>
                <!-- Feature 3 -->
                <div class="p-6 bg-teal-950/40 rounded-xl border border-teal-800/50 hover:bg-teal-900/60 transition-colors">
                    <div class="w-14 h-14 bg-teal-900 rounded-lg flex items-center justify-center mb-6 text-[#59A338]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Dapur & Katering Terpadu</h3>
                    <p class="text-teal-100/70">Sajian makanan bergizi dan lezat yang disiapkan khusus oleh tim koki internal kami.</p>
                </div>
                <!-- Feature 4 -->
                <div class="p-6 bg-teal-950/40 rounded-xl border border-teal-800/50 hover:bg-teal-900/60 transition-colors">
                    <div class="w-14 h-14 bg-teal-900 rounded-lg flex items-center justify-center mb-6 text-[#59A338]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Respon Perbaikan 24/7</h3>
                    <p class="text-teal-100/70">Tim teknisi siaga untuk memastikan seluruh fasilitas Anda berfungsi dengan sempurna.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Room Types Section -->
    <section class="py-20 px-6 md:px-12 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#114045] mb-4">Pilihan Akomodasi Kami</h2>
                <div class="w-20 h-1 bg-[#59A338] mx-auto rounded"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Card 1 -->
                <div class="bg-[#F8F9FA] rounded-2xl overflow-hidden shadow-lg group hover:shadow-xl transition-shadow border border-gray-100">
                    <div class="h-64 overflow-hidden relative">
                        <img src="https://i.ibb.co.com/PvMLk9wB/slides-15.jpg" alt="Kamar Reguler Twin Bed" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-[#114045] font-bold px-4 py-1 rounded-full shadow">Twin Bed</div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-[#114045] mb-3">Kamar Reguler</h3>
                        <p class="text-gray-600 leading-relaxed">Fasilitas lengkap untuk dua orang peserta, dirancang untuk kenyamanan istirahat optimal dengan pencahayaan alami dan AC.</p>
                    </div>
                </div>
                
                <!-- Card 2 -->
                <div class="bg-[#F8F9FA] rounded-2xl overflow-hidden shadow-lg group hover:shadow-xl transition-shadow border border-gray-100">
                    <div class="h-64 overflow-hidden relative">
                        <img src="https://i.ibb.co.com/qMm0b989/slides-23.jpg" alt="Kamar Executive" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-[#114045] font-bold px-4 py-1 rounded-full shadow">VIP</div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-[#114045] mb-3">Kamar Executive</h3>
                        <p class="text-gray-600 leading-relaxed">Privasi dan kenyamanan ekstra, dikhususkan bagi para trainer, instruktur, maupun tamu manajemen dengan fasilitas premium.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Fasilitas Penunjang -->
    <section class="py-20 px-6 md:px-12 bg-[#F8F9FA]">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#114045] mb-4">Lengkapi Pengalaman Anda</h2>
                <div class="w-20 h-1 bg-[#59A338] mx-auto rounded"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Foto 1 -->
                <div class="relative h-72 rounded-2xl overflow-hidden group">
                    <img src="https://images.unsplash.com/photo-1552674605-db6ffd4facb5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Sarana Olahraga & Jogging Track" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <h3 class="text-white text-xl font-bold">Sarana Olahraga & Jogging Track</h3>
                    </div>
                </div>
                
                <!-- Foto 2 -->
                <div class="relative h-72 rounded-2xl overflow-hidden group">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Ruang Makan Luas & Bersih" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <h3 class="text-white text-xl font-bold">Ruang Makan Luas & Bersih</h3>
                    </div>
                </div>
                
                <!-- Foto 3 -->
                <div class="relative h-72 rounded-2xl overflow-hidden group">
                    <img src="https://images.unsplash.com/photo-1594498653385-d5172c532c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Area Terbuka Hijau" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <h3 class="text-white text-xl font-bold">Area Terbuka Hijau</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Footer -->
    <footer class="bg-[#114045] pt-16 pb-8 px-6 md:px-12 border-t border-teal-900">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="text-white font-bold text-2xl tracking-tight">MESS FR ACADEMY</span>
                    </div>
                    <p class="text-teal-100/80 mb-6 max-w-md leading-relaxed">
                        Sistem manajemen operasional mess terpadu untuk memastikan kenyamanan dan kelancaran kegiatan Anda selama berada di First Resources Academy.
                    </p>
                    <div class="flex items-start gap-3 text-teal-100/80">
                        <svg class="w-6 h-6 shrink-0 mt-0.5 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <p>Kubang Raya, Kabupaten Kampar, Riau.</p>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-6 text-lg">Tautan Cepat</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('login') }}" class="text-teal-100/70 hover:text-white hover:pl-2 transition-all">Login Staf & Admin</a></li>
                        <li><a href="{{ route('guest.login') }}" class="text-teal-100/70 hover:text-white hover:pl-2 transition-all">Login Tamu (No HP)</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-6 text-lg">Hubungi Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-teal-100/70">
                            <svg class="w-5 h-5 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            mess@fracademy.test
                        </li>
                        <li class="flex items-center gap-3 text-teal-100/70">
                            <svg class="w-5 h-5 text-[#59A338]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +62 811 0000 000
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-teal-800/50 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-teal-100/50">
                <p>Copyright &copy; 2026 First Resources Academy - Mess Management System.</p>
                <p>Designed with <span class="text-red-500">&hearts;</span> for FR Academy.</p>
            </div>
        </div>
    </footer>
</div>
</x-layouts.app>