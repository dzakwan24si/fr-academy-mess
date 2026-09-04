<x-layouts.app>
<div class="min-h-screen bg-slate-50 flex flex-col font-sans">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm py-4 px-6 fixed w-full z-10">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded bg-[#114045] flex items-center justify-center text-white font-bold text-lg">FR</div>
                <span class="text-xl font-bold text-gray-800 tracking-tight">FR Academy Mess</span>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('guest.login') }}" class="text-gray-600 hover:text-[#114045] font-medium transition py-2 px-4">Portal Tamu</a>
                <a href="{{ route('login') }}" class="bg-[#114045] text-white px-5 py-2 rounded-lg font-medium hover:bg-teal-900 transition shadow-md">Portal Staf</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center relative pt-20">
        <div class="absolute inset-0 bg-[#114045] bg-opacity-95 z-0">
            <img src="https://images.unsplash.com/photo-1542314831-c53cd453f500?q=80&w=2000&auto=format&fit=crop" alt="Hotel Building" class="w-full h-full object-cover mix-blend-overlay opacity-40">
        </div>
        
        <div class="max-w-7xl mx-auto px-6 py-32 relative z-10 text-center w-full">
            <span class="text-teal-200 font-semibold tracking-wider uppercase text-sm mb-4 block">Sistem Manajemen Properti</span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-6 leading-tight">
                Kenyamanan Anda <br> <span class="text-teal-300">Prioritas Kami</span>
            </h1>
            <p class="text-lg md:text-xl text-teal-100 max-w-2xl mx-auto mb-10 leading-relaxed">
                Fasilitas mess eksklusif berkapasitas 100+ trainee. Dilengkapi layanan binatu, dapur komersial, dan layanan perbaikan cepat.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('guest.login') }}" class="px-8 py-4 bg-white text-[#114045] font-bold rounded-lg hover:bg-gray-100 transition shadow-xl hover:shadow-2xl flex items-center justify-center gap-2 text-lg">
                    <span>Masuk Portal Tamu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8 text-center text-sm border-t border-gray-800">
        <p>&copy; {{ date('Y') }} FR Academy Property Management System. Hak Cipta Dilindungi.</p>
    </footer>
</div>
</x-layouts.app>