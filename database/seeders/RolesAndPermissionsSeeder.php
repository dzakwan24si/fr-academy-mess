<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superadmin = \Spatie\Permission\Models\Role::create(['name' => 'Superadmin']);
        $koordinator = \Spatie\Permission\Models\Role::create(['name' => 'Koordinator Mess']);
        $kebersihan = \Spatie\Permission\Models\Role::create(['name' => 'Staf Kebersihan']);
        $dapur = \Spatie\Permission\Models\Role::create(['name' => 'Staf Dapur']);
        $teknisi = \Spatie\Permission\Models\Role::create(['name' => 'Teknisi']);
        $kepalaTU = \Spatie\Permission\Models\Role::create(['name' => 'Kepala TU']);

        // Create superadmin user
        $user = \App\Models\User::create([
            'name' => 'Admin Utama',
            'email' => 'superadmin@fracademy.test',
            'password' => 'password',
        ]);

        $user->assignRole($superadmin);
    }
}
