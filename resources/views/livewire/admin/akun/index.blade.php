<div class="p-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Manajemen Akun & Peran</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola data pengguna, peran (role), dan hak akses sistem.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            @if($activeTab === 'users')
                <button wire:click="bukaModal" class="flex-shrink-0 flex items-center gap-2 px-4 py-2.5 bg-[#59A338] hover:bg-[#4d8f2f] text-white rounded-xl text-sm font-semibold transition-colors shadow-sm w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Akun</span>
                </button>
            @else
                <button wire:click="bukaRoleModal" class="flex-shrink-0 flex items-center gap-2 px-4 py-2.5 bg-[#2E7D32] hover:bg-green-800 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Peran Baru</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 relative flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 relative flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="flex items-center gap-3 border-b border-gray-200 mb-6">
        <button wire:click="setTab('users')" class="flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 transition-colors {{ $activeTab === 'users' ? 'border-[#59A338] text-[#59A338]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span>Daftar Akun Pengguna</span>
            <span class="text-xs px-2 py-0.5 rounded-full {{ $activeTab === 'users' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">{{ $users->total() }}</span>
        </button>
        <button wire:click="setTab('roles')" class="flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 transition-colors {{ $activeTab === 'roles' ? 'border-[#59A338] text-[#59A338]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            <span>Kelola Peran & Hak Akses (Role)</span>
            <span class="text-xs px-2 py-0.5 rounded-full {{ $activeTab === 'roles' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">{{ count($rolesList) }}</span>
        </button>
    </div>

    <!-- TAB 1: DAFTAR AKUN PENGGUNA -->
    @if($activeTab === 'users')
        <!-- Filter Section -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row gap-4 z-20 relative">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cari Akun</label>
                <div class="relative">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Ketik nama, email, atau NIK..." class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-[#59A338] focus:border-transparent transition-shadow">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Tabel Data Pengguna -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-semibold text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 rounded-tl-2xl">Nama Pengguna</th>
                            <th class="py-4 px-6">Email</th>
                            <th class="py-4 px-6">NIK</th>
                            <th class="py-4 px-6">Peran (Role)</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right rounded-tr-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-[#114045]/10 flex items-center justify-center text-[#114045] font-bold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-3.5">
                                            <div class="text-sm font-bold text-gray-900 leading-tight">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($user->email)
                                        <span class="text-sm text-gray-600 font-medium">{{ $user->email }}</span>
                                    @else
                                        <span class="text-xs text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($user->nik)
                                        <span class="inline-flex items-center font-mono text-xs font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200/80 px-2.5 py-1 rounded-lg">
                                            {{ $user->nik }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $userRole = $user->roles->first();
                                        $roleName = $userRole->name ?? '-';
                                        $isReadOnlyRole = $userRole?->is_read_only ?? false;
                                        $badgeColor = match($roleName) {
                                            'Superadmin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                            'Koordinator Mess' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'Direktur', 'Manager' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                            'Kepala TU' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'Staf Dapur' => 'bg-orange-100 text-orange-700 border-orange-200',
                                            'Staf Kebersihan', 'Staf Laundry', 'Teknisi' => 'bg-teal-100 text-teal-700 border-teal-200',
                                            default => 'bg-gray-100 text-gray-700 border-gray-200'
                                        };
                                    @endphp
                                    <div class="flex flex-col gap-1 items-start">
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $badgeColor }}">
                                            {{ $roleName }}
                                        </span>
                                        @if($isReadOnlyRole)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-medium text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Read-Only
                                            </span>
                                        @endif
                                    </div>
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
                                    <button wire:click="bukaModal({{ $user->id }})" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Akun">
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

                                        <button wire:click="hapus({{ $user->id }})" wire:confirm="Apakah Anda yakin ingin menghapus akun ini secara permanen?" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Akun">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500">
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
    @endif

    <!-- TAB 2: KELOLA PERAN & HAK AKSES (ROLE) -->
    @if($activeTab === 'roles')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-semibold text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 rounded-tl-2xl">Nama Peran (Role)</th>
                            <th class="py-4 px-6">Mode Akses</th>
                            <th class="py-4 px-6">Hak Akses Modul</th>
                            <th class="py-4 px-6 text-center">Jumlah Pengguna</th>
                            <th class="py-4 px-6 text-right rounded-tr-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($rolesList as $rItem)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="text-sm font-bold text-gray-900">{{ $rItem->name }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($rItem->name === 'Superadmin')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                            <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                            Akses Penuh Sistem
                                        </span>
                                    @elseif($rItem->is_read_only)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Read-Only (Monitoring Saja)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                            <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Operasional (Input/Edit)
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-wrap gap-1 max-w-md">
                                        @if($rItem->name === 'Superadmin')
                                            <span class="text-xs text-purple-700 font-medium italic">Semua Modul & Fitur Sistem</span>
                                        @else
                                            @forelse($rItem->permissions as $p)
                                                <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                                    {{ ucwords(str_replace(['akses_', 'manajemen_'], '', $p->name)) }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-400 italic">Belum ada izin modul</span>
                                            @endforelse
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        {{ $rItem->users_count }} Pengguna
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap space-x-2">
                                    <button wire:click="bukaRoleModal({{ $rItem->id }})" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Peran">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    @if($rItem->name !== 'Superadmin')
                                        <button wire:click="hapusRole({{ $rItem->id }})" wire:confirm="Yakin ingin menghapus peran '{{ $rItem->name }}'?" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Peran">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">
                                    Belum ada data peran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- MODAL TAMBAH/EDIT AKUN PENGGUNA -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
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

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-4">
                        <div class="flex items-center justify-between pb-2 mb-3 border-b border-gray-200">
                            <span class="text-xs font-semibold text-gray-700">Kredensial Login <span class="text-gray-400 font-normal">(Isi salah satu atau keduanya)</span></span>
                            <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">Bisa Digunakan Login</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1.5 text-xs font-semibold text-gray-700">Email Login</label>
                                <input type="email" wire:model="email" class="w-full px-3.5 py-2.5 text-sm bg-white border border-gray-300 rounded-xl focus:ring-[#59A338] focus:border-[#59A338]" placeholder="nama@fracademy.com">
                                @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-xs font-semibold text-gray-700">NIK (Nomor Induk Karyawan)</label>
                                <input type="text" wire:model="nik" class="w-full px-3.5 py-2.5 text-sm bg-white border border-gray-300 rounded-xl focus:ring-[#59A338] focus:border-[#59A338]" placeholder="Contoh: 2012040260">
                                @error('nik') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Peran Default (Label Role)</label>
                        <select wire:model.live="role" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-[#59A338] focus:border-[#59A338]">
                            <option value="">-- Pilih Peran --</option>
                            @foreach($roles as $rl)
                                <option value="{{ $rl->name }}">{{ $rl->name }}{{ $rl->is_read_only ? ' (Read-Only)' : '' }}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror

                        @php
                            $currentSelectedRole = $roles->firstWhere('name', $role);
                        @endphp
                        @if($currentSelectedRole && $currentSelectedRole->is_read_only)
                            <div class="mt-2 text-xs text-amber-800 bg-amber-50 border border-amber-200 px-3 py-2 rounded-lg flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Peran ini bertipe <strong>Read-Only</strong>. Pengguna hanya dapat memantau data tanpa mengubah data operasional.</span>
                            </div>
                        @endif
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

    <!-- MODAL TAMBAH/EDIT PERAN (ROLE) -->
    @if($isRoleModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-role-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900/50 backdrop-blur-sm" aria-hidden="true" wire:click="tutupRoleModal"></div>

            <div class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-[#114045]" id="modal-role-title">
                        {{ $isRoleEdit ? 'Edit Peran (Role)' : 'Tambah Peran Baru' }}
                    </h3>
                    <button wire:click="tutupRoleModal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form wire:submit.prevent="simpanRole" class="mt-4 space-y-4">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700">Nama Peran (Role) <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="role_name" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-[#59A338] focus:border-[#59A338]" placeholder="Contoh: Direktur, Manager, Auditor...">
                        @error('role_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Mode Read-Only Checkbox -->
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="role_is_read_only" class="w-4 h-4 mt-0.5 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                            <div>
                                <span class="text-sm font-bold text-amber-900 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Mode Read-Only (Hanya Monitoring / Pantau Data)
                                </span>
                                <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                                    Sangat cocok untuk <strong>Direktur, Manager, atau Atasan</strong>. Akun dengan peran ini hanya dapat melihat data & mencetak laporan, tanpa tombol aksi operasional (tambah/edit/hapus).
                                </p>
                            </div>
                        </label>
                    </div>

                    <!-- Hak Akses Modul -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Hak Akses Modul yang Diizinkan</label>
                        <div class="grid grid-cols-2 gap-3 bg-gray-50 p-4 rounded-xl border border-gray-200 max-h-56 overflow-y-auto">
                            @foreach($permissionsList as $perm)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" wire:model="role_permissions" value="{{ $perm->name }}" class="w-4 h-4 text-[#59A338] border-gray-300 rounded focus:ring-[#59A338]">
                                    <span class="text-xs font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $perm->name)) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" wire:click="tutupRoleModal" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#59A338] hover:bg-[#4d8f2f] rounded-xl transition-colors shadow-sm">
                            {{ $isRoleEdit ? 'Simpan Perubahan' : 'Buat Peran' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
