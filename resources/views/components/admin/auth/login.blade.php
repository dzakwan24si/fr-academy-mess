<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

new class extends Component
{
    public $loginId;
    public $password;
    public $remember = false;
    public $turnstileToken; 

    public function login()
    {
        $turnstileEnabled = (bool) config('services.turnstile.enabled', false);

        $rules = [
            'loginId' => 'required|string',
            'password' => 'required',
        ];

        $messages = [
            'loginId.required' => 'Email atau NIK wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ];

        if ($turnstileEnabled) {
            $rules['turnstileToken'] = 'required';
            $messages['turnstileToken.required'] = 'Harap selesaikan verifikasi keamanan (Cloudflare).';
        }

        $this->validate($rules, $messages);

        if ($turnstileEnabled) {
            $http = Http::asForm()->timeout(5);
            if (app()->environment('local')) {
                $http = $http->withoutVerifying();
            }

            try {
                $response = $http->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => config('services.turnstile.secret', '0x4AAAAAAEzPGKSsKiRsoVbsX1tzF-N7x8k'),
                    'response' => $this->turnstileToken,
                    'remoteip' => request()->ip(),
                ]);

                if (! $response->json('success')) {
                    $this->addError('turnstileToken', 'Verifikasi keamanan gagal. Silakan coba lagi.');
                    $this->dispatch('reset-turnstile');

                    return;
                }
            } catch (\Exception $e) {
                \Log::warning('Cloudflare Turnstile verification unreachable: '.$e->getMessage());
            }
        }

        $fieldType = filter_var($this->loginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';

        if (Auth::attempt([$fieldType => $this->loginId, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            $user = Auth::user();
            if ($user) {
                $user->update(['last_login_at' => now()]);
            }

            return redirect()->intended('/admin/dashboard');
        }

        $this->addError('loginId', 'Kredensial yang diberikan tidak cocok dengan data kami.');

        if ($turnstileEnabled) {
            $this->dispatch('reset-turnstile');
        }
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

                    <form wire:submit="login" method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="loginId" class="block text-sm font-bold text-[#114045] mb-2">Email atau NIK</label>
                            <div class="relative">
                                <input wire:model="loginId" id="loginId" name="loginId" type="text" autocomplete="username" value="{{ old('loginId') }}" placeholder="Masukkan Email atau NIK Anda" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#008000] focus:border-transparent transition-shadow sm:text-sm">
                            </div>
                            @error('loginId') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-[#114045] mb-2">Kata Sandi</label>
                            <div class="relative" x-data="{ show: false }">
                                <input wire:model="password" id="password" name="password" type="password" x-bind:type="show ? 'text' : 'password'" autocomplete="current-password" placeholder="Masukkan kata sandi" required class="appearance-none block w-full px-4 py-3 pr-11 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#008000] focus:border-transparent transition-shadow sm:text-sm">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer" aria-label="Lihat kata sandi">
                                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                            @error('password') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        @if(config('services.turnstile.enabled', false))
                            <!-- WIDGET CLOUDFLARE TURNSTILE (Direvisi untuk Livewire) -->
                            <div wire:ignore>
                                <div id="cf-turnstile-container"></div>
                            </div>
                            @error('turnstileToken') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        @endif

                        <div class="flex items-center">
                            <input wire:model="remember" id="remember_me" type="checkbox" class="h-4 w-4 text-[#008000] focus:ring-[#008000] border-gray-300 rounded cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-500 font-medium cursor-pointer">Ingat Saya</label>
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

        @if(config('services.turnstile.enabled', false))
            <script>
                let widgetId;

                // Fungsi global untuk me-render widget secara manual
                window.renderTurnstile = function() {
                    if (typeof turnstile !== 'undefined') {
                        // Jika sudah ada widget, reset dulu untuk mencegah error duplikasi/memory leak
                        if (widgetId !== undefined) {
                             turnstile.reset(widgetId);
                        } else {
                            // Render widget baru
                            widgetId = turnstile.render('#cf-turnstile-container', {
                                sitekey: '{{ config('services.turnstile.key', '0x4AAAAAAEzPGJLBNyo86KAl') }}', // Site Key dari .env / config
                                theme: 'light', // Ubah tema kotak menjadi warna putih/terang
                                callback: function(token) {
                                    // Set token ke variabel Livewire saat berhasil diceklis
                                    @this.set('turnstileToken', token);
                                }
                            });
                        }
                    }
                };

                // Jalankan render saat Livewire navigasi (SPA mode)
                document.addEventListener('livewire:navigated', window.renderTurnstile);

                // Dengarkan event dari backend jika verifikasi/login gagal agar widget di-reset
                window.addEventListener('reset-turnstile', event => {
                    if (typeof turnstile !== 'undefined' && widgetId !== undefined) {
                        turnstile.reset(widgetId);
                        @this.set('turnstileToken', null); // Kosongkan token di frontend
                    }
                });
            </script>
            
            <!-- SCRIPT CLOUDFLARE (Sekarang menggunakan callback onload agar langsung muncul) -->
            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit&onload=renderTurnstile" async defer></script>
        @endif

    </div> <!-- PENUTUP div root pembungkus utama -->