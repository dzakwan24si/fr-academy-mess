<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#114045]">Manajemen Akun</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola akses staf dan peran (role) pada sistem.</p>
        </div>
        <button wire:click="bukaModal" class="bg-[#59A338] hover:bg-[#4a872e] text-white px-4 py-2 rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Akun
        </button>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 relative flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 relative flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Pencarian -->
    <div class="mb-4">
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input wire:model.live="search" type="text" class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow text-sm" placeholder="Cari nama atau email...">
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Info Pengguna</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Peran (Role)</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-[#114045]/10 flex items-center justify-center text-[#114045] font-bold text-lg">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $roleName = $user->roles->first()->name ?? '-';
                                    $badgeColor = match($roleName) {
                                        'Superadmin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        'Admin Reservasi' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'Admin Dapur' => 'bg-orange-100 text-orange-700 border-orange-200',
                                        'Admin Operasional' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        default => 'bg-gray-100 text-gray-700 border-gray-200'
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $badgeColor }}">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap space-x-2">
                                <button wire:click="bukaModal({{ $user->id }})" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                <button wire:click="resetPassword({{ $user->id }})" wire:confirm="Anda yakin ingin me-reset password akun ini menjadi 'fracademy123'?" class="p-2 text-orange-500 hover:bg-orange-50 rounded-lg transition-colors" title="Reset Password">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                </button>

                                @if(Auth::id() != $user->id)
                                    <button wire:click="toggleAktif({{ $user->id }})" class="p-2 {{ $user->is_active ? 'text-orange-500 hover:bg-orange-50' : 'text-green-500 hover:bg-green-50' }} rounded-lg transition-colors" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        @if($user->is_active)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </button>

                                    <button wire:click="hapus({{ $user->id }})" wire:confirm="Apakah Anda yakin ingin menghapus akun ini secara permanen?" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-500">
                                Tidak ada data akun yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Tambah/Edit -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-900/50 backdrop-blur-sm" aria-hidden="true" wire:click="tutupModal"></div>

            <div class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-xl font-bold text-[#114045]" id="modal-title">
                        {{ $isEdit ? 'Edit Data Akun' : 'Tambah Akun Baru' }}
                    </h3>
                    <button wire:click="tutupModal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form wire:submit.prevent="simpan" class="space-y-4">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                        <input type="text" wire:model="name" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-[#59A338] focus:border-[#59A338]" placeholder="Masukkan nama...">
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Email Login</label>
                        <input type="email" wire:model="email" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-[#59A338] focus:border-[#59A338]" placeholder="nama@fracademy.com">
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Peran Default (Label Role)</label>
                        <select wire:model="role" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-[#59A338] focus:border-[#59A338]">
                            <option value="">-- Pilih Peran --</option>
                            @foreach($roles as $rl)
                                <option value="{{ $rl->name }}">{{ $rl->name }}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Hak Akses Khusus (Permissions)</label>
                        <div class="grid grid-cols-2 gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            @foreach($permissionsList as $perm)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm->name }}" class="w-4 h-4 text-[#59A338] border-gray-300 rounded focus:ring-[#59A338]">
                                    <span class="text-xs font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $perm->name)) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                            Password {{ $isEdit ? '(Biarkan kosong jika tidak diubah)' : '' }}
                        </label>
                        <input type="password" wire:model="password" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-[#59A338] focus:border-[#59A338]" placeholder="Minimal 8 karakter...">
                        @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" wire:click="tutupModal" class="w-full px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="w-full px-4 py-2.5 text-sm font-bold text-white bg-[#59A338] rounded-xl hover:bg-[#4a872e] focus:outline-none transition-colors shadow-sm">
                            <span wire:loading.remove wire:target="simpan">{{ $isEdit ? 'Simpan Perubahan' : 'Buat Akun' }}</span>
                            <span wire:loading wire:target="simpan">Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
