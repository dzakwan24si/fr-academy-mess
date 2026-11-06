<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Pastikan seluruh permission dasar sudah ada
        $permissions = [
            'akses_reservasi',
            'akses_kamar',
            'akses_aset',
            'akses_laundry',
            'akses_dapur',
            'akses_komplain',
            'manajemen_akun',
            'akses_survei',
            'akses_maintenance',
            'akses_kebersihan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Pemetaan izin ke peran (role)
        $rolePermissions = [
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

        foreach ($rolePermissions as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
