<?php

namespace Tests\Feature;

use App\Livewire\Admin\Tamu\Index as AdminTamuIndex;
use App\Models\Tamu;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AdminDataTamuTest extends TestCase
{
    use DatabaseTransactions;

    public static function setUpBeforeClass(): void
    {
        putenv('DB_CONNECTION=mysql');
        putenv('DB_DATABASE=db_mess_fracademy');
        $_ENV['DB_CONNECTION'] = 'mysql';
        $_ENV['DB_DATABASE'] = 'db_mess_fracademy';
        $_SERVER['DB_CONNECTION'] = 'mysql';
        $_SERVER['DB_DATABASE'] = 'db_mess_fracademy';
        parent::setUpBeforeClass();
    }

    public function test_admin_with_akses_reservasi_can_view_tamu_page(): void
    {
        Permission::firstOrCreate(['name' => 'akses_reservasi', 'guard_name' => 'web']);

        $user = User::create([
            'name' => 'Admin Reservasi '.uniqid(),
            'email' => 'admin_res_'.uniqid().'@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->givePermissionTo('akses_reservasi');

        $tamu = Tamu::create([
            'nama' => 'Rahmat Hidayat '.uniqid(),
            'no_hp' => '0877'.rand(10000000, 99999999),
            'kategori' => 'trainee',
            'perusahaan' => 'FR Academy',
            'jabatan' => 'FAT I 2027',
        ]);

        $this->actingAs($user)
            ->get(route('admin.tamu'))
            ->assertOk();

        Livewire::actingAs($user)
            ->test(AdminTamuIndex::class)
            ->set('search', $tamu->nama)
            ->assertSee($tamu->nama)
            ->assertSee($tamu->no_hp);
    }

    public function test_admin_can_edit_tamu_and_fix_phone_number(): void
    {
        Permission::firstOrCreate(['name' => 'akses_reservasi', 'guard_name' => 'web']);

        $user = User::create([
            'name' => 'Admin Reservasi '.uniqid(),
            'email' => 'admin_res_'.uniqid().'@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->givePermissionTo('akses_reservasi');

        $oldPhone = '0811'.rand(10000000, 99999999);
        $newPhone = '0822'.rand(10000000, 99999999);

        $tamu = Tamu::create([
            'nama' => 'Joko Susilo '.uniqid(),
            'no_hp' => $oldPhone,
            'kategori' => 'tamu_umum',
            'perusahaan' => 'PT Sawit Makmur',
            'jabatan' => 'Manager',
        ]);

        Livewire::actingAs($user)
            ->test(AdminTamuIndex::class)
            ->call('bukaModalEdit', $tamu->id)
            ->set('no_hp', $newPhone)
            ->set('nama', 'Joko Susilo Updated')
            ->call('simpan');

        $this->assertDatabaseHas('tamus', [
            'id' => $tamu->id,
            'nama' => 'Joko Susilo Updated',
            'no_hp' => $newPhone,
        ]);
    }

    public function test_admin_can_soft_delete_tamu_and_release_phone_number(): void
    {
        Permission::firstOrCreate(['name' => 'akses_reservasi', 'guard_name' => 'web']);

        $user = User::create([
            'name' => 'Admin Reservasi '.uniqid(),
            'email' => 'admin_res_'.uniqid().'@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->givePermissionTo('akses_reservasi');

        $phone = '0899'.rand(10000000, 99999999);

        $tamu = Tamu::create([
            'nama' => 'Peserta Lama '.uniqid(),
            'no_hp' => $phone,
            'kategori' => 'trainee',
            'perusahaan' => 'FR Academy',
            'jabatan' => 'Alumni 2024',
        ]);

        Livewire::actingAs($user)
            ->test(AdminTamuIndex::class)
            ->call('konfirmasiHapus', $tamu->id)
            ->call('hapusTamu');

        // Tamu is soft deleted
        $this->assertSoftDeleted('tamus', [
            'id' => $tamu->id,
        ]);

        // Original phone number is released so it does not collide
        $this->assertDatabaseMissing('tamus', [
            'id' => $tamu->id,
            'no_hp' => $phone,
        ]);
    }
}
