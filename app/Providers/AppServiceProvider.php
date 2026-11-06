<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Superadmin')) {
                return true;
            }

            // Fallback pemetaan izin peran standar Mess FR Academy
            $roleDefaultPermissions = [
                'Staf Kebersihan' => ['akses_kebersihan'],
                'Teknisi' => ['akses_maintenance', 'akses_aset'],
                'Staf Dapur' => ['akses_dapur'],
                'Staf Laundry' => ['akses_laundry'],
                'Koordinator Mess' => [
                    'akses_reservasi', 'akses_kamar', 'akses_aset', 'akses_laundry',
                    'akses_dapur', 'akses_komplain', 'akses_survei', 'akses_maintenance', 'akses_kebersihan',
                ],
                'Kepala TU' => [
                    'akses_reservasi', 'akses_kamar', 'akses_aset', 'akses_laundry',
                    'akses_dapur', 'akses_komplain', 'akses_survei', 'akses_maintenance', 'akses_kebersihan',
                ],
                'Direktur' => [
                    'akses_reservasi', 'akses_kamar', 'akses_aset', 'akses_laundry',
                    'akses_dapur', 'akses_komplain', 'akses_survei',
                ],
            ];

            foreach ($roleDefaultPermissions as $role => $permissions) {
                if ($user->hasRole($role) && in_array($ability, $permissions, true)) {
                    return true;
                }
            }

            return null;
        });

        // Tingkatkan batas ukuran upload foto kamera untuk komponen Livewire (Max 20MB)
        config(['livewire.temporary_file_upload.rules' => ['required', 'file', 'max:20480']]);

        if (
            str_starts_with((string) config('app.url'), 'https://')
            || request()->isSecure()
            || request()->header('x-forwarded-proto') === 'https'
            || request()->server('HTTP_X_FORWARDED_PROTO') === 'https'
            || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        ) {
            URL::forceScheme('https');
        }
    }
}
