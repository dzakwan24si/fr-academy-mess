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
    Route::get('/admin/dashboard', function () {
        return Blade::render('<livewire:admin.dashboard />');
    })->name('admin.dashboard');
});

Route::middleware('auth:tamu')->group(function () {
    Route::get('/tamu/dashboard', function () {
        return Blade::render('<livewire:guest-portal.dashboard />');
    })->name('guest.dashboard');
});
