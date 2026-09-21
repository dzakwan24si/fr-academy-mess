<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('Superadmin') ? true : null;
        });

        // Tingkatkan batas ukuran upload foto kamera untuk komponen Livewire (Max 20MB)
        config(['livewire.temporary_file_upload.rules' => ['required', 'file', 'max:20480']]);
    }
}
