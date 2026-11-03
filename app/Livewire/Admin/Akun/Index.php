<?php

namespace App\Livewire\Admin\Akun;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin')]
#[Title('MANAJEMEN AKUN')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    // Modal state
    public $isModalOpen = false;

    public $isEdit = false;

    public $user_id = null;

    // Form fields
    public $name;

    public $email;

    public $nik;

    public $password;

    public $role = '';

    public $selectedPermissions = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function bukaModal($id = null)
    {
        $this->resetValidation();
        if ($id) {
            $user = User::findOrFail($id);
            $this->user_id = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->nik = $user->nik ?? '';
            $this->role = $user->roles->first()->name ?? '';
            $this->password = '';
            $this->selectedPermissions = $user->permissions->pluck('name')->toArray();
            $this->isEdit = true;
        } else {
            $this->isEdit = false;
            $this->user_id = null;
            $this->reset(['name', 'email', 'nik', 'password', 'role', 'selectedPermissions']);
        }
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
    }

    public function simpan()
    {
        $this->email = ! empty($this->email) ? trim($this->email) : null;
        $this->nik = ! empty($this->nik) ? trim($this->nik) : null;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required_without:nik|nullable|email|max:255|unique:users,email,'.$this->user_id,
            'nik' => 'required_without:email|nullable|string|max:50|unique:users,nik,'.$this->user_id,
            'role' => 'required|string|exists:roles,name',
        ];

        $messages = [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required_without' => 'Email atau NIK wajib diisi salah satu.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'nik.required_without' => 'Email atau NIK wajib diisi salah satu.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'role.required' => 'Pilih peran akun.',
        ];

        if (! $this->isEdit) {
            $rules['password'] = 'required|min:8';
            $messages['password.required'] = 'Kata sandi wajib diisi.';
            $messages['password.min'] = 'Kata sandi minimal 8 karakter.';
        } else {
            $rules['password'] = 'nullable|min:8';
            $messages['password.min'] = 'Kata sandi minimal 8 karakter.';
        }

        $this->validate($rules, $messages);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'nik' => $this->nik,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user = User::updateOrCreate(
            ['id' => $this->user_id],
            $data
        );

        // Sync role
        if ($this->role) {
            $user->syncRoles([$this->role]);
        }

        // Sync direct permissions
        $user->syncPermissions($this->selectedPermissions);

        $this->tutupModal();
    }

    public function hapus($id)
    {
        if (Auth::id() == $id) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');

            return;
        }

        $user = User::findOrFail($id);
        $user->delete();
    }

    public function toggleAktif($id)
    {
        if (Auth::id() == $id) {
            session()->flash('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');

            return;
        }

        $user = User::findOrFail($id);
        $user->is_active = ! $user->is_active;
        $user->save();
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make('fracademy123');
        $user->save();

        session()->flash('success', "Password untuk {$user->name} berhasil di-reset menjadi 'fracademy123'.");
    }

    public function render()
    {
        $query = User::with('roles')->orderBy('name', 'asc');

        if (! empty($this->search)) {
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->orWhere('nik', 'like', '%'.$this->search.'%');
        }

        return view('livewire.admin.akun.index', [
            'users' => $query->paginate($this->perPage),
            'roles' => Role::all(),
            'permissionsList' => Permission::all(),
        ]);
    }
}
