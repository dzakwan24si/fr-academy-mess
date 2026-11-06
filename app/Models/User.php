<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'nik', 'is_active', 'last_login_at', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function isReadOnly(): bool
    {
        if ($this->hasRole('Superadmin')) {
            return false;
        }

        return $this->roles->contains('is_read_only', true);
    }

    public function getHomeRoute(): string
    {
        // Staf operasional dialihkan langsung ke menu kerja hariannya
        if ($this->hasRole('Teknisi')) {
            return route('admin.maintenance');
        }

        if ($this->hasRole('Staf Kebersihan')) {
            return route('admin.kebersihan');
        }

        if ($this->hasRole('Staf Dapur')) {
            return route('admin.dapur');
        }

        if ($this->hasRole('Staf Laundry')) {
            return route('admin.laundry');
        }

        // Superadmin, Koordinator Mess, Kepala TU, Direktur, dan tim manajemen lainnya
        return route('admin.dashboard');
    }

    public function canAccessDashboard(): bool
    {
        // Staf operasional murni tidak membutuhkan tampilan dashboard manajerial
        if ($this->hasAnyRole(['Teknisi', 'Staf Kebersihan', 'Staf Dapur', 'Staf Laundry'])) {
            return $this->hasAnyRole(['Superadmin', 'Koordinator Mess', 'Kepala TU', 'Direktur']);
        }

        return true;
    }
}
