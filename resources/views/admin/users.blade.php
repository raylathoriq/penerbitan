@extends('layouts.admin')

@section('page_title', 'Manajemen User')

@section('content')
<x-card class="!p-0">
    <div class="flex justify-between items-center p-6 border-b border-slate-100">
        <h2 class="text-lg font-semibold text-slate-800">Daftar Pengguna</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/75">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama / Afiliasi</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                <!-- 1. LOOPING DATA USER DARI CONTROLLER -->
                @forelse($users as $index => $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-slate-900">{{ $user->name }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $user->afiliasi ?? 'Tidak ada afiliasi' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 capitalize">
                            {{ $user->role }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ ($user->status ?? 'Aktif') === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                {{ $user->status ?? 'Aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <!-- Tombol Edit (Membuka modal edit spesifik ID) -->
                            <x-button type="ghost" @click="$dispatch('open-modal', 'modal-user-edit-{{ $user->id }}')" class="!p-2 !bg-orange-600 !text-white hover:!bg-orange-700 border border-orange-600 shadow-sm transition-all duration-200">
                                <i class="bi bi-pencil-square text-sm"></i>
                            </x-button>

                            <!-- Tombol Hapus (Membuka modal hapus spesifik ID) -->
                            <x-button type="ghost" @click="$dispatch('open-modal', 'modal-user-delete-{{ $user->id }}')" class="!p-2 !bg-rose-600 !text-white hover:!bg-rose-700 border border-rose-600 shadow-sm transition-all duration-200">
                                <i class="bi bi-trash text-sm"></i>
                            </x-button>
                        </td>
                    </tr>

                    <!-- ========================================== -->
                    <!-- 2. MODAL EDIT UNTUK USER INI -->
                    <!-- ========================================== -->
                    <x-modal name="modal-user-edit-{{ $user->id }}" title="Edit Pengguna">
                        <!-- UNTUK BACKEND: Lengkapi route action, CSRF token, dan Method PUT -->
                        <form action="{{route('users.update',$user)}}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <div>
                                    <label for="name_{{ $user->id }}" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                                    <input 
                                        type="text" 
                                        id="name_{{ $user->id }}" 
                                        name="name" 
                                        value="{{ old('name', $user->name) }}" 
                                        required 
                                        class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm"
                                    >
                                </div>

                                <div>
                                    <label for="email_{{ $user->id }}" class="block text-sm font-medium text-slate-700 mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                                    <input 
                                        type="email" 
                                        id="email_{{ $user->id }}" 
                                        name="email" 
                                        value="{{ old('email', $user->email) }}" 
                                        required 
                                        class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm bg-slate-50 cursor-not-allowed"
                                        readonly
                                    >
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="role_{{ $user->id }}" class="block text-sm font-medium text-slate-700 mb-1">Role / Peran <span class="text-rose-500">*</span></label>
                                        <select 
                                            id="role_{{ $user->id }}" 
                                            name="role" 
                                            class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm bg-white"
                                        >
                                            <option value="author" {{ $user->role == 'author' ? 'selected' : '' }}>Author</option>
                                            <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Editor</option>
                                            <option value="reviewer" {{ $user->role == 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>

                                    <div>
                                        <!-- Field Status untuk menonaktifkan pengguna -->
                                        <label for="status_{{ $user->id }}" class="block text-sm font-medium text-slate-700 mb-1">Status Akun <span class="text-rose-500">*</span></label>
                                        <select 
                                            id="status_{{ $user->id }}" 
                                            name="status" 
                                            class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm bg-white"
                                        >
                                            <option value="Aktif" {{ ($user->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Nonaktif" {{ ($user->status ?? 'Aktif') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="afiliasi_{{ $user->id }}" class="block text-sm font-medium text-slate-700 mb-1">Afiliasi / Instansi</label>
                                    <input 
                                        type="text" 
                                        id="afiliasi_{{ $user->id }}" 
                                        name="afiliasi" 
                                        value="{{ old('afiliasi', $user->afiliasi) }}" 
                                        placeholder="Contoh: Universitas Pembangunan Nasional Veteran Jakarta"
                                        class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm"
                                    >
                                </div>
                            </div>

                            <div class="mt-6 sm:flex sm:flex-row-reverse gap-2">
                                <x-button typeHtml="submit" type="primary">Simpan Perubahan</x-button>
                                <x-button type="button" @click="$dispatch('close-modal', 'modal-user-edit-{{ $user->id }}')" type="secondary">Batal</x-button>
                            </div>
                        </form>
                    </x-modal>

                    <!-- ========================================== -->
                    <!-- 3. MODAL HAPUS UNTUK USER INI -->
                    <!-- ========================================== -->
                    <x-modal name="modal-user-delete-{{ $user->id }}" title="Hapus Pengguna">
                        <!-- UNTUK BACKEND: Lengkapi route action, CSRF token, dan Method DELETE -->
                        <form action="{{route('users.destroy',$user)}}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="space-y-2">
                                <p class="text-sm text-slate-600">Apakah Anda yakin ingin menghapus pengguna <strong class="text-slate-900">{{ $user->name }}</strong>?</p>
                                <p class="text-xs text-rose-600 bg-rose-50 border border-rose-100 p-2 rounded-lg">
                                    Tindakan ini tidak dapat dibatalkan. Menghapus akun ini juga akan menghapus data akses yang bersangkutan secara permanen.
                                </p>
                            </div>

                            <div class="mt-6 sm:flex sm:flex-row-reverse gap-2">
                                <x-button typeHtml="submit" type="danger">Hapus Permanen</x-button>
                                <x-button type="button" @click="$dispatch('close-modal', 'modal-user-delete-{{ $user->id }}')" type="secondary">Batal</x-button>
                            </div>
                        </form>
                    </x-modal>

                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">
                            Belum ada pengguna terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection