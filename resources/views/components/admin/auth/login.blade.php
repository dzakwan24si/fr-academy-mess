<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $email;
    public $password;
    public $remember = false;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

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
    <div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Portal Staf & Admin
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Manajemen Operasional Mess FR Academy
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border-t-4 border-[#114045]">
                <form wire:submit="login" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Alamat Email
                        </label>
                        <div class="mt-1">
                            <input wire:model="email" id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#114045] focus:border-[#114045] sm:text-sm">
                        </div>
                        @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Kata Sandi
                        </label>
                        <div class="mt-1">
                            <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#114045] focus:border-[#114045] sm:text-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input wire:model="remember" id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-[#114045] focus:ring-[#114045] border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#114045] hover:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#114045] transition">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection