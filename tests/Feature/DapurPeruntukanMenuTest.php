<?php

namespace Tests\Feature;

use App\Livewire\Admin\Dapur\Index as AdminDapurIndex;
use App\Livewire\Guest\Dapur\Index as GuestDapurIndex;
use App\Models\Menu;
use App\Models\RencanaMenuHarian;
use App\Models\Tamu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DapurPeruntukanMenuTest extends TestCase
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

    public function test_guest_dapur_only_displays_reguler_menus_and_hides_khusus_and_jus_trainer(): void
    {
        $today = Carbon::today()->toDateString();

        $menuReguler = Menu::create([
            'nama_menu' => 'Ayam Penyet Reguler '.uniqid(),
            'kategori' => 'Umum',
            'waktu_penyajian' => 'Siang',
            'estimasi_harga_porsi' => 20000,
        ]);

        $menuKhusus = Menu::create([
            'nama_menu' => 'Jus Semangka Instruktur '.uniqid(),
            'kategori' => 'Jus Trainer',
            'waktu_penyajian' => 'jus_trainer',
            'estimasi_harga_porsi' => 5000,
        ]);

        RencanaMenuHarian::create([
            'tanggal' => $today,
            'waktu' => 'siang',
            'menu_id' => $menuReguler->id,
            'status' => 'selesai',
            'target_porsi' => 30,
            'peruntukan' => 'reguler',
        ]);

        RencanaMenuHarian::create([
            'tanggal' => $today,
            'waktu' => 'jus_trainer',
            'menu_id' => $menuKhusus->id,
            'status' => 'selesai',
            'target_porsi' => 5,
            'peruntukan' => 'trainer',
        ]);

        $tamu = Tamu::create([
            'nama' => 'Budi Santoso',
            'no_hp' => '081234'.rand(100000, 999999),
            'kategori' => 'trainee',
            'jabatan' => 'FAT I 2027',
        ]);

        Livewire::actingAs($tamu, 'tamu')
            ->test(GuestDapurIndex::class)
            ->assertSee($menuReguler->nama_menu)
            ->assertDontSee($menuKhusus->nama_menu);
    }

    public function test_admin_dapur_auto_assigns_khusus_for_jus_trainer(): void
    {
        Permission::firstOrCreate(['name' => 'akses_dapur', 'guard_name' => 'web']);

        $user = User::create([
            'name' => 'Koki Dapur '.uniqid(),
            'email' => 'koki_'.uniqid().'@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->givePermissionTo('akses_dapur');

        $menu = Menu::create([
            'nama_menu' => 'Jus Mangga Trainer '.uniqid(),
            'kategori' => 'Jus Trainer',
            'waktu_penyajian' => 'jus_trainer',
            'estimasi_harga_porsi' => 5000,
        ]);

        $today = Carbon::today()->toDateString();

        Livewire::actingAs($user)
            ->test(AdminDapurIndex::class)
            ->set('rencana_tanggal', $today)
            ->set('rencana_waktu', 'jus_trainer')
            ->set('rencana_menu_id', $menu->id)
            ->set('rencana_target_porsi', 5)
            ->call('simpanRencana');

        $this->assertDatabaseHas('rencana_menu_harians', [
            'menu_id' => $menu->id,
            'waktu' => 'jus_trainer',
            'peruntukan' => 'trainer',
        ]);
    }
}
