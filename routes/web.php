<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return Blade::render('<livewire:admin.auth.login />');
})->name('login');

// Route::get('/tamu/login', function () {
//     return Blade::render('<livewire:guest-portal.auth.login />');
// })->name('guest.login');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    if (\Illuminate\Support\Facades\Auth::guard('tamu')->check()) {
        \Illuminate\Support\Facades\Auth::guard('tamu')->logout();
    }
    if (\Illuminate\Support\Facades\Auth::guard('web')->check()) {
        \Illuminate\Support\Facades\Auth::guard('web')->logout();
    }
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/admin/kamar', \App\Livewire\Admin\Kamar\Index::class)->name('admin.kamar');
    Route::get('/admin/reservasi', \App\Livewire\Admin\Reservasi\Index::class)->name('admin.reservasi');
    Route::get('/admin/laundry', \App\Livewire\Admin\Laundry\Index::class)->name('admin.laundry');
    Route::get('/admin/dapur', \App\Livewire\Admin\Dapur\Index::class)->name('admin.dapur');
    Route::get('/admin/dapur/print', [\App\Http\Controllers\DapurExportController::class, 'printBelanja'])->name('admin.dapur.print');
    Route::get('/admin/akun', \App\Livewire\Admin\Akun\Index::class)->name('admin.akun');
    Route::get('/admin/kamar', \App\Livewire\Admin\Kamar\Index::class)->name('admin.kamar');
    Route::get('/admin/komplain', \App\Livewire\Admin\Komplain\Index::class)->name('admin.komplain');
});

Route::middleware('auth:tamu')->group(function () {
    Route::get('/tamu/booking', \App\Livewire\Guest\Booking\Index::class)->name('guest.booking');
    Route::get('/tamu/dashboard', \App\Livewire\Guest\Dashboard::class)->name('guest.dashboard');
    Route::get('/tamu/riwayat', \App\Livewire\Guest\Riwayat\Index::class)->name('guest.riwayat');
    Route::get('/tamu/profil', \App\Livewire\Guest\Profil\Index::class)->name('guest.profil');
    Route::get('/tamu/komplain', \App\Livewire\Guest\Komplain\Index::class)->name('guest.komplain');
    Route::get('/tamu/laundry', \App\Livewire\Guest\Laundry\Index::class)->name('guest.laundry');
    Route::get('/tamu/dapur', \App\Livewire\Guest\Dapur\Index::class)->name('guest.dapur');
});
