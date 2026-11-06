<?php

use App\Http\Controllers\Admin\BarcodeController;
use App\Http\Controllers\DapurExportController;
use App\Http\Controllers\Guest\ETicketController;
use App\Livewire\Admin\Aset\Laporan;
use App\Livewire\Admin\Dapur\Index;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Kamar\Aset;
use App\Livewire\Admin\Laporan\Okupansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/sitemap.xml', function () {
    return response()->view('sitemap')->header('Content-Type', 'text/xml');
})->name('sitemap');

Route::get('/login', function () {
    return view('admin.auth.login-wrapper');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'loginId' => 'required|string',
        'password' => 'required',
    ], [
        'loginId.required' => 'Email atau NIK wajib diisi.',
        'password.required' => 'Kata sandi wajib diisi.',
    ]);

    $fieldType = filter_var($request->loginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';
    $remember = $request->boolean('remember');

    if (Auth::attempt([$fieldType => $request->loginId, 'password' => $request->password], $remember)) {
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user) {
            $user->update(['last_login_at' => now()]);
        }

        return redirect()->intended($user?->getHomeRoute() ?? '/admin/dashboard');
    }

    return back()->withErrors([
        'loginId' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
    ])->withInput($request->only('loginId', 'remember'));
});

Route::get('/tamu/login', function () {
    return redirect()->route('home');
})->name('guest.login');

Route::post('/logout', function (Request $request) {
    if (Auth::guard('tamu')->check()) {
        Auth::guard('tamu')->logout();
    }
    if (Auth::guard('web')->check()) {
        Auth::guard('web')->logout();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard (Akses umum untuk admin)
    Route::get('/admin/dashboard', Dashboard::class)->name('admin.dashboard');

    // Dapur
    Route::middleware('permission:akses_dapur')->group(function () {
        Route::get('/admin/dapur', Index::class)->name('admin.dapur');
        Route::get('/admin/dapur/print', [DapurExportController::class, 'printBelanja'])->name('admin.dapur.print');
        Route::get('/admin/dapur/print-jadwal', [DapurExportController::class, 'printJadwal'])->name('admin.dapur.print-jadwal');
    });

    // Reservasi
    Route::middleware('permission:akses_reservasi')->group(function () {
        Route::get('/admin/reservasi', App\Livewire\Admin\Reservasi\Index::class)->name('admin.reservasi');
    });

    // Data Tamu (dapat diakses oleh tim reservasi maupun admin sistem)
    Route::middleware('permission:akses_reservasi|manajemen_akun')->group(function () {
        Route::get('/admin/tamu', App\Livewire\Admin\Tamu\Index::class)->name('admin.tamu');
    });

    // Laundry
    Route::middleware('permission:akses_laundry')->group(function () {
        Route::get('/admin/laundry', App\Livewire\Admin\Laundry\Index::class)->name('admin.laundry');
    });

    // Sistem & Evaluasi
    Route::middleware('permission:akses_survei')->group(function () {
        Route::get('/admin/survei', App\Livewire\Admin\Survei\Index::class)->name('admin.survei.index');
        // Laporan Okupansi juga diletakkan di sini, atau bisa dibatasi khusus admin utama
        Route::get('/admin/laporan/okupansi', Okupansi::class)->name('admin.laporan.okupansi');
    });

    // Manajemen Akun
    Route::middleware('permission:manajemen_akun')->group(function () {
        Route::get('/admin/akun', App\Livewire\Admin\Akun\Index::class)->name('admin.akun');
    });

    // Kamar
    Route::middleware('permission:akses_kamar')->group(function () {
        Route::get('/admin/kamar', App\Livewire\Admin\Kamar\Index::class)->name('admin.kamar');

        // Barcode
        Route::get('/barcode/cetak', [BarcodeController::class, 'cetak'])->name('admin.barcode.cetak');

        Route::get('/admin/kamar/{kamar}/aset', Aset::class)->name('admin.kamar.aset');
    });

    // Tugas Kebersihan
    Route::middleware('permission:akses_kebersihan')->group(function () {
        Route::get('/admin/tugas-kebersihan', App\Livewire\Admin\Kebersihan\Index::class)->name('admin.kebersihan');
    });

    // Aset
    Route::middleware('permission:akses_aset')->group(function () {
        Route::get('/admin/aset', App\Livewire\Admin\Aset\Index::class)->name('admin.aset');
        Route::get('/admin/aset/laporan', Laporan::class)->name('admin.aset.laporan');
    });

    // Komplain
    Route::middleware('permission:akses_komplain')->group(function () {
        Route::get('/admin/komplain', App\Livewire\Admin\Komplain\Index::class)->name('admin.komplain');
    });

    // Tugas Perbaikan (Maintenance)
    Route::middleware('permission:akses_maintenance')->group(function () {
        Route::get('/admin/tugas-perbaikan', App\Livewire\Admin\Maintenance\Index::class)->name('admin.maintenance');
    });
});

Route::middleware('auth:tamu')->group(function () {
    Route::get('/tamu/booking', App\Livewire\Guest\Booking\Index::class)->name('guest.booking');
    Route::get('/tamu/dashboard', App\Livewire\Guest\Dashboard::class)->name('guest.dashboard');
    Route::get('/tamu/riwayat', App\Livewire\Guest\Riwayat\Index::class)->name('guest.riwayat');
    Route::get('/tamu/reservasi/{id}/e-ticket', [ETicketController::class, 'download'])->name('guest.eticket');
    Route::get('/tamu/profil', App\Livewire\Guest\Profil\Index::class)->name('guest.profil');
    Route::get('/tamu/komplain', App\Livewire\Guest\Komplain\Index::class)->name('guest.komplain');
    Route::get('/tamu/laundry', App\Livewire\Guest\Laundry\Index::class)->name('guest.laundry');
    Route::get('/tamu/dapur', App\Livewire\Guest\Dapur\Index::class)->name('guest.dapur');
});
