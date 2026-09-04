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
    <div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Portal Tamu
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Masuk menggunakan Nomor HP Anda
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form wire:submit="login" class="space-y-6">
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700">
                            Nomor HP
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input wire:model="no_hp" id="no_hp" name="no_hp" type="text" autocomplete="tel" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#114045] focus:border-[#114045] sm:text-sm" placeholder="Contoh: 08123456789">
                        </div>
                        @error('no_hp') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#114045] hover:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#114045] transition">
                            Masuk
                        </button>
                    </div>
                </form>
                
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">
                                Kembali ke
                            </span>
                        </div>
                    </div>
                    <div class="mt-6 text-center">
                        <a href="{{ route('home') }}" class="font-medium text-[#114045] hover:text-teal-900">
                            Halaman Utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>