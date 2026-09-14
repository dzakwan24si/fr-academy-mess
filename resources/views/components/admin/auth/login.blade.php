<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Tambahkan ini untuk request ke API Cloudflare

new class extends Component
{
    public $email;
    public $password;
    public $remember = false;
    public $turnstileToken; // Tambahkan variabel untuk menyimpan token Cloudflare

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
            'turnstileToken' => 'required', // Pastikan token diisi (user sudah verifikasi)
        ], [
            'turnstileToken.required' => 'Harap selesaikan verifikasi keamanan (Cloudflare).'
        ]);

        // Validasi token ke server Cloudflare
        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => '0x4AAAAAAEzPGKSsKiRsoVbsX1tzF-N7x8k', // Ganti dengan Secret Key dari Dasbor Cloudflare
            'response' => $this->turnstileToken,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->json('success')) {
            $this->addError('turnstileToken', 'Verifikasi keamanan gagal. Silakan coba lagi.');
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        $this->addError('email', 'Kredensial yang diberikan tidak cocok dengan data kami.');
    }
};
?>

@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex font-sans">
        <!-- Left Side: Image & Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-[#114045]">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/slides-7.jpg') }}" alt="FR Academy Mess" class="w-full h-full object-cover opacity-40 mix-blend-multiply">
            </div>
            <!-- Overlay Content -->
            <div class="relative z-10 flex flex-col justify-end p-12 text-white h-full w-full bg-gradient-to-t from-[#114045] via-[#114045]/60 to-transparent">
                <h1 class="text-5xl font-extrabold tracking-tight mb-3 uppercase drop-shadow-md">FR ACADEMY</h1>
                <p class="text-lg font-medium text-gray-200 mb-1 drop-shadow-sm">Pusat Informasi, Edukasi, dan Operasional Terpadu</p>
                <p class="text-md text-gray-300 drop-shadow-sm">First Resources</p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white p-8 sm:p-12 relative">
            <div class="w-full max-w-md">
                <div class="mb-10 text-left">
                    <h2 class="text-[32px] font-bold text-[#114045] mb-2 leading-tight">Selamat Datang</h2>
                    <p class="text-sm text-gray-500 font-medium">Silakan masuk menggunakan kredensial FR Academy Anda.</p>
                </div>

                <form wire:submit="login" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-bold text-[#114045] mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <input wire:model="email" id="email" name="email" type="email" autocomplete="email" placeholder="Masukkan Email Anda" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#008000] focus:border-transparent transition-shadow sm:text-sm">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>
                        @error('email') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-[#114045] mb-2">
                            Kata Sandi
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <input wire:model="password" id="password" name="password" :type="show ? 'text' : 'password'" autocomplete="current-password" placeholder="Masukkan kata sandi" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#008000] focus:border-transparent transition-shadow sm:text-sm">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 cursor-pointer hover:text-gray-600" @click="show = !show">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- WIDGET CLOUDFLARE TURNSTILE -->
                    <div wire:ignore>
                        <div class="cf-turnstile" 
                             data-sitekey="0x4AAAAAAEzPGJLBNyo86KAl" 
                             data-callback="turnstileCallback">
                        </div>
                    </div>
                    @error('turnstileToken') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input wire:model="remember" id="remember_me" type="checkbox" class="h-4 w-4 text-[#008000] focus:ring-[#008000] border-gray-300 rounded cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-500 font-medium cursor-pointer">
                                Ingat Saya
                            </label>
                        </div>
                        
                        <div class="text-sm">
                            <a href="#" class="font-bold text-[#008000] hover:text-green-700 transition-colors">Lupa Kata Sandi?</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-[#008000] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#008000] transition-colors mt-2">
                            Masuk ke Sistem
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        </button>
                    </div>
                </form>
                
                <div class="mt-16 text-center absolute bottom-8 left-0 right-0">
                    <p class="text-xs font-medium text-gray-400">&copy; {{ date('Y') }} FR ACADEMY - Internal System Operational Mess </p>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT CLOUDFLARE -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script>
        // Fungsi ini akan dipanggil otomatis oleh Cloudflare saat verifikasi sukses
        function turnstileCallback(token) {
            // Memasukkan token ke variabel Livewire
            @this.set('turnstileToken', token);
        }
    </script>
@endsection