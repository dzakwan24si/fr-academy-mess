<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('components.welcome');
})->name('home');

Route::get('/login', function () {
    return view('components.admin.auth.login');
})->name('login');

Route::get('/tamu/login', function () {
    return view('components.guest-portal.auth.login');
})->name('guest.login');
