<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

Route::get('/', function () {
    return view('components.welcome');
})->name('home');

Route::get('/login', function () {
    return Blade::render('<livewire:admin.auth.login />');
})->name('login');

Route::get('/tamu/login', function () {
    return Blade::render('<livewire:guest-portal.auth.login />');
})->name('guest.login');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/admin/reservasi', \App\Livewire\Admin\Reservasi\Index::class)->name('admin.reservasi');
    Route::get('/admin/laundry', \App\Livewire\Admin\Laundry\Index::class)->name('admin.laundry');
    Route::get('/admin/dapur', \App\Livewire\Admin\Dapur\Index::class)->name('admin.dapur');
    Route::get('/admin/komplain', \App\Livewire\Admin\Komplain\Index::class)->name('admin.komplain');
    Route::get('/admin/akun', \App\Livewire\Admin\Akun\Index::class)->name('admin.akun');
});

Route::middleware('auth:tamu')->group(function () {
    Route::get('/tamu/dashboard', function () {
        return Blade::render('<livewire:guest-portal.dashboard />');
    })->name('guest.dashboard');
});
