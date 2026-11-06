<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles and assign default permissions
        $superadmin = Role::firstOrCreate(['name' => 'Superadmin']);
        $koordinator = Role::firstOrCreate(['name' => 'Koordinator Mess']);
        $koordinator->syncPermissions([
            'akses_reservasi', 'akses_kamar', 'akses_aset', 'akses_laundry',
            'akses_dapur', 'akses_komplain', 'akses_survei', 'akses_maintenance', 'akses_kebersihan',
        ]);

        $kebersihan = Role::firstOrCreate(['name' => 'Staf Kebersihan']);
        $kebersihan->syncPermissions(['akses_kebersihan']);

        $dapur = Role::firstOrCreate(['name' => 'Staf Dapur']);
        $dapur->syncPermissions(['akses_dapur']);

        $teknisi = Role::firstOrCreate(['name' => 'Teknisi']);
        $teknisi->syncPermissions(['akses_maintenance', 'akses_aset']);

        $kepalaTU = Role::firstOrCreate(['name' => 'Kepala TU']);
        $kepalaTU->syncPermissions([
            'akses_reservasi', 'akses_kamar', 'akses_aset', 'akses_laundry',
            'akses_dapur', 'akses_komplain', 'akses_survei', 'akses_maintenance', 'akses_kebersihan',
        ]);

        $laundry = Role::firstOrCreate(['name' => 'Staf Laundry']);
        $laundry->syncPermissions(['akses_laundry']);

        // Define users for each role
        $usersData = [
            ['name' => 'Admin Utama', 'email' => 'superadmin@fracademy.test', 'role' => $superadmin],
            ['name' => 'Koordinator Mess', 'email' => 'koordinator@fracademy.test', 'role' => $koordinator],
            ['name' => 'Staf Kebersihan', 'email' => 'kebersihan@fracademy.test', 'role' => $kebersihan],
            ['name' => 'Staf Dapur', 'email' => 'dapur@fracademy.test', 'role' => $dapur],
            ['name' => 'Pak Tepung Teknisi', 'email' => 'teknisi@fracademy.test', 'role' => $teknisi],
            ['name' => 'Kepala TU', 'email' => 'kepalatu@fracademy.test', 'role' => $kepalaTU],
            ['name' => 'Staf Laundry', 'email' => 'laundry@fracademy.test', 'role' => $laundry],
        ];

        // Create users and assign roles
        foreach ($usersData as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => bcrypt('password'), // Or 'password' if you have an observer/mutator. Standard is bcrypt.
                ]
            );
            // In case the password logic mutates it directly or we need to ensure it's unhashed 'password'
            if (! \Hash::info($user->password)['algoName']) {
                $user->password = bcrypt('password');
                $user->save();
            }

            if (! $user->hasRole($userData['role']->name)) {
                $user->assignRole($userData['role']);
            }
        }
    }
}
