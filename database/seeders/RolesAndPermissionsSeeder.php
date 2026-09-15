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
        $superadmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Superadmin']);
        $koordinator = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Koordinator Mess']);
        $kebersihan = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Staf Kebersihan']);
        $dapur = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Staf Dapur']);
        $teknisi = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Teknisi']);
        $kepalaTU = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Kepala TU']);
        $laundry = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Staf Laundry']);

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
            $user = \App\Models\User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => bcrypt('password'), // Or 'password' if you have an observer/mutator. Standard is bcrypt.
                ]
            );
            // In case the password logic mutates it directly or we need to ensure it's unhashed 'password'
            if (!\Hash::info($user->password)['algoName']) {
                $user->password = bcrypt('password');
                $user->save();
            }

            if (!$user->hasRole($userData['role']->name)) {
                $user->assignRole($userData['role']);
            }
        }
    }
}
