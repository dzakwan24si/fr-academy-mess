<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

new class extends Component
{
    public $email;
    public $password;
    public $remember = false;
    public $turnstileToken; 

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
            'turnstileToken' => 'required', 
        ], [
            'turnstileToken.required' => 'Harap selesaikan verifikasi keamanan (Cloudflare).'
        ]);

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => '0x4AAAAAAEzPGKSsKiRsoVbsX1tzF-N7x8k', // Ganti dengan Secret Key
            'response' => $this->turnstileToken,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->json('success')) {
            $this->addError('turnstileToken', 'Verifikasi keamanan gagal. Silakan coba lagi.');
            
            // Perintahkan frontend untuk me-reset widget jika gagal
            $this->dispatch('reset-turnstile');
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        $this->addError('email', 'Kredensial yang diberikan tidak cocok dengan data kami.');
        // Reset widget jika login gagal
        $this->dispatch('reset-turnstile');
    }
};
?>

<div>
        <div class="min-h-screen flex font-sans">
            <!-- Left Side: Image & Branding -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-[#114045]">
                <div class="absolute inset-0 z-0">
                    <img src="{{ asset('images/slides-7.jpg') }}" alt="FR Academy Mess" class="w-full h-full object-cover opacity-40 mix-blend-multiply">
                </div>
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
                            <label for="email" class="block text-sm font-bold text-[#114045] mb-2">Email</label>
                            <div class="relative">
                                <input wire:model="email" id="email" name="email" type="email" autocomplete="email" placeholder="Masukkan Email Anda" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#008000] focus:border-transparent transition-shadow sm:text-sm">
                            </div>
                            @error('email') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-[#114045] mb-2">Kata Sandi</label>
                            <div class="relative" x-data="{ show: false }">
                                <input wire:model="password" id="password" name="password" :type="show ? 'text' : 'password'" autocomplete="current-password" placeholder="Masukkan kata sandi" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#008000] focus:border-transparent transition-shadow sm:text-sm">
                            </div>
                        </div>

                        <!-- WIDGET CLOUDFLARE TURNSTILE (Direvisi untuk Livewire) -->
                        <div wire:ignore>
                            <div id="cf-turnstile-container"></div>
                        </div>
                        @error('turnstileToken') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input wire:model="remember" id="remember_me" type="checkbox" class="h-4 w-4 text-[#008000] focus:ring-[#008000] border-gray-300 rounded cursor-pointer">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-500 font-medium cursor-pointer">Ingat Saya</label>
                            </div>
                            
                            <div class="text-sm">
                                <a href="#" class="font-bold text-[#008000] hover:text-green-700 transition-colors">Lupa Kata Sandi?</a>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-[#008000] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#008000] transition-colors mt-2">
                                Masuk ke Sistem
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-16 text-center absolute bottom-8 left-0 right-0">
                        <p class="text-xs font-medium text-gray-400">&copy; {{ date('Y') }} FR ACADEMY - Internal System Operational Mess </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SCRIPT CLOUDFLARE (Sekarang berada DI DALAM div root pembungkus) -->
        <!-- Perhatikan parameter ?render=explicit -->
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit" async defer></script>
        
        <script>
            let widgetId;

            // Fungsi untuk me-render widget secara manual
            function renderTurnstile() {
                if (typeof turnstile !== 'undefined') {
                    // Jika sudah ada widget, reset dulu untuk mencegah error duplikasi/memory leak
                    if (widgetId !== undefined) {
                         turnstile.reset(widgetId);
                    } else {
                        // Render widget baru
                        widgetId = turnstile.render('#cf-turnstile-container', {
                            sitekey: '0x4AAAAAAEzPGJLBNyo86KAl', // Ganti dengan Site Key
                            callback: function(token) {
                                // Set token ke variabel Livewire saat berhasil diceklis
                                @this.set('turnstileToken', token);
                            }
                        });
                    }
                }
            }

            // Jalankan render saat Livewire (atau browser) selesai dimuat
            document.addEventListener('livewire:navigated', renderTurnstile);
            document.addEventListener('DOMContentLoaded', renderTurnstile);

            // Dengarkan event dari backend jika verifikasi/login gagal agar widget di-reset
            window.addEventListener('reset-turnstile', event => {
                if (typeof turnstile !== 'undefined' && widgetId !== undefined) {
                    turnstile.reset(widgetId);
                    @this.set('turnstileToken', null); // Kosongkan token di frontend
                }
            });
        </script>
    </div> <!-- PENUTUP div root pembungkus utama -->