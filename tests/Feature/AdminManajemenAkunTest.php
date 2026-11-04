<?php

namespace Tests\Feature;

use App\Livewire\Admin\Akun\Index as AdminAkunIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminManajemenAkunTest extends TestCase
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

    public function test_login_updates_last_login_at(): void
    {
        $user = User::create([
            'name' => 'Test User '.uniqid(),
            'email' => 'login_test_'.uniqid().'@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->assertNull($user->last_login_at);

        $response = $this->post('/login', [
            'loginId' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin/dashboard');

        $user->refresh();
        $this->assertNotNull($user->last_login_at);
    }

    public function test_livewire_login_updates_last_login_at(): void
    {
        config(['services.turnstile.enabled' => false]);

        $user = User::create([
            'name' => 'Livewire User '.uniqid(),
            'email' => 'livewire_test_'.uniqid().'@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->assertNull($user->last_login_at);

        Livewire::test('admin.auth.login')
            ->set('loginId', $user->email)
            ->set('password', 'password123')
            ->call('login')
            ->assertRedirect('/admin/dashboard');

        $user->refresh();
        $this->assertNotNull($user->last_login_at);
    }

    public function test_admin_can_view_akun_table_with_new_layout_and_anda_badge(): void
    {
        Permission::firstOrCreate(['name' => 'manajemen_akun', 'guard_name' => 'web']);
        $role = Role::firstOrCreate(['name' => 'Superadmin', 'guard_name' => 'web']);

        $admin = User::create([
            'name' => 'Yogie Hizkia '.uniqid(),
            'nik' => '2018050444',
            'email' => 'yogie_'.uniqid().'@example.com',
            'password' => bcrypt('password123'),
            'last_login_at' => now(),
        ]);
        $admin->givePermissionTo('manajemen_akun');
        $admin->assignRole($role);

        $this->actingAs($admin)
            ->get(route('admin.akun'))
            ->assertOk()
            ->assertSee('Pengguna & NIK', false)
            ->assertSee('Role Akses')
            ->assertSee('Status')
            ->assertSee('Login Terakhir')
            ->assertSee('Anda')
            ->assertSee('2018050444');
    }

    public function test_admin_can_create_and_edit_user(): void
    {
        Permission::firstOrCreate(['name' => 'manajemen_akun', 'guard_name' => 'web']);
        $role = Role::firstOrCreate(['name' => 'Koordinator Mess', 'guard_name' => 'web']);

        $admin = User::create([
            'name' => 'Admin Akun '.uniqid(),
            'email' => 'admin_'.uniqid().'@example.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->givePermissionTo('manajemen_akun');

        Livewire::actingAs($admin)
            ->test(AdminAkunIndex::class)
            ->call('bukaModal')
            ->set('name', 'Staff Mess Baru')
            ->set('nik', '99887766')
            ->set('role', 'Koordinator Mess')
            ->set('password', 'password123')
            ->call('simpan')
            ->assertHasNoErrors();

        $created = User::where('nik', '99887766')->first();
        $this->assertNotNull($created);
        $this->assertEquals('Staff Mess Baru', $created->name);

        // Test Edit
        Livewire::actingAs($admin)
            ->test(AdminAkunIndex::class)
            ->call('bukaModal', $created->id)
            ->assertSet('name', 'Staff Mess Baru')
            ->set('name', 'Staff Mess Senior')
            ->call('simpan')
            ->assertHasNoErrors();

        $created->refresh();
        $this->assertEquals('Staff Mess Senior', $created->name);
    }
}
