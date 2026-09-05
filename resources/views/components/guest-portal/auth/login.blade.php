<?php

use Livewire\Component;

new class extends Component
{
    public $no_hp;

    public function login()
    {
        $this->validate([
            'no_hp' => 'required|string',
        ]);

        $tamu = \App\Models\Tamu::where('no_hp', $this->no_hp)->first();

        if ($tamu) {
            \Illuminate\Support\Facades\Auth::guard('tamu')->login($tamu);
            return redirect()->intended('/tamu/dashboard');
        }

        $this->addError('no_hp', 'Nomor HP tidak terdaftar atau tidak memiliki reservasi aktif.');
    }
};
?>


<x-layouts.app>
    <div class="min-h-screen flex flex-col lg:flex-row font-sans bg-gray-50">
        <!-- Bagian Kiri (Desktop) / Atas (Mobile) - Image Background -->
        <div class="relative w-full lg:w-5/12 h-[45vh] lg:h-screen bg-[#114045] flex-shrink-0">
            <!-- Background Image -->
            <img src="{{ asset('images/slides-7.jpg') }}" alt="FR Academy Building" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-60">
            
            <!-- Gradient Overlay for better text readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#0a282c] via-transparent to-transparent lg:bg-gradient-to-b lg:from-transparent lg:to-[#0a282c]"></div>

            <!-- Content -->
            <div class="relative z-10 h-full flex flex-col items-center justify-center lg:items-start lg:justify-center p-8 lg:p-16 text-white text-center lg:text-left">
                <h1 class="text-2xl lg:text-4xl font-extrabold tracking-tight mb-3 lg:mb-4">FR ACADEMY</h1>
                <p class="text-sm lg:text-base text-gray-200 leading-relaxed font-light">
                    Pusat Informasi, Edukasi, dan<br class="hidden lg:block"> Operasional Terpadu<br>
                    <span class="font-medium mt-1 block text-gray-300">First Resources</span>
                </p>
            </div>
        </div>

        <!-- Bagian Kanan (Desktop) / Bawah (Mobile) - Login Form -->
        <div class="w-full lg:w-7/12 flex flex-col justify-center px-6 py-10 lg:px-24 lg:py-16 bg-white rounded-t-[2.5rem] lg:rounded-none -mt-12 lg:mt-0 relative z-20 flex-grow shadow-[0_-10px_40px_rgba(0,0,0,0.1)] lg:shadow-none">
            
            <div class="w-full max-w-md mx-auto lg:mx-0">
                <h2 class="text-2xl lg:text-3xl font-bold text-[#114045] mb-3">Selamat Datang</h2>
                <p class="text-sm text-gray-500 mb-10 leading-relaxed">
                    Silakan masukkan nomor WhatsApp Anda yang terdaftar untuk mengakses jadwal pelatihan dan layanan mess.
                </p>

                <form wire:submit="login" class="space-y-6">
                    <div>
                        <label for="no_hp" class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp</label>
                        <div class="flex shadow-sm rounded-xl overflow-hidden border border-gray-300 focus-within:border-[#59A338] focus-within:ring-1 focus-within:ring-[#59A338] transition-all bg-white">
                            <span class="inline-flex items-center px-4 bg-gray-50 text-gray-600 border-r border-gray-300 font-semibold text-sm">
                                +62
                            </span>
                            <input wire:model="no_hp" id="no_hp" type="tel" autocomplete="tel" required class="flex-1 block w-full px-4 py-3.5 text-sm lg:text-base border-0 focus:ring-0 text-gray-900 bg-transparent placeholder-gray-400" placeholder="812 3456 7890">
                        </div>
                        @error('no_hp') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm lg:text-base font-bold text-white bg-[#4e9231] hover:bg-[#3d7a24] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#59A338] transition-all transform active:scale-[0.98]">
                        Masuk ke Sistem
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>

                <div class="mt-12 text-center lg:text-left flex flex-col lg:flex-row items-center gap-2 lg:gap-3">
                    <p class="text-sm text-gray-500">Belum terdaftar atau nomor tidak dikenali?</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-1 text-sm font-bold text-[#4e9231] hover:text-[#3d7a24] transition-colors">
                        Hubungi Admin Pelatihan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</x-layouts.app>