@extends('layouts.admin')

@section('title', 'Manajemen Kategori - Admin LPPM UPNVJ Press')
@section('page_title', 'Manajemen Kategori')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <p class="text-sm text-slate-500">Kelola kategori naskah/buku untuk klasifikasi pengajuan di LPPM UPNVJ Press.</p>
        </div>
        <div>
            <!-- Tombol Tambah (Membuka modal-tambah) -->
            <x-button type="primary" @click="$dispatch('open-modal', 'modal-kategori-tambah')" class="w-full sm:w-auto shadow-md">
                <i class="bi bi-plus-lg mr-2 text-sm"></i>
                Tambah Kategori
            </x-button>
        </div>
    </div>

    <!-- Table Card -->
    <x-card class="!p-0">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/75">
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Kategori</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    <!-- 1. LOOPING DATA KATEGORI DARI CONTROLLER -->
                    @forelse($categories as $index => $category)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $category->nama_kategori }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <!-- Tombol Edit (Membuka modal edit spesifik ID) -->
                                <x-button type="ghost" @click="$dispatch('open-modal', 'modal-kategori-edit-{{ $category->id }}')" class="!p-2 !bg-orange-600 !text-white hover:!bg-orange-700 border border-orange-600 shadow-sm transition-all duration-200">
                                    <i class="bi bi-pencil-square text-sm"></i>
                                </x-button>

                                <!-- Tombol Hapus (Membuka modal hapus spesifik ID) -->
                                <x-button type="ghost" @click="$dispatch('open-modal', 'modal-kategori-delete-{{ $category->id }}')" class="!p-2 !bg-rose-600 !text-white hover:!bg-rose-700 border border-rose-600 shadow-sm transition-all duration-200">
                                    <i class="bi bi-trash text-sm"></i>
                                </x-button>

                            </td>
                        </tr>

                        <!-- ========================================== -->
                        <!-- 2. MODAL EDIT UNTUK KATEGORI INI -->
                        <!-- ========================================== -->
                        <x-modal name="modal-kategori-edit-{{ $category->id }}" title="Edit Kategori">
                            <form action="{{ route('kategori.update', $category) }}" method="POST">
                                @csrf
                                @method('PUT') 

                                <div class="space-y-4">
                                    <div>
                                        <label for="nama_kategori_{{ $category->id }}" class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                                        <input 
                                            type="text" 
                                            id="nama_kategori_{{ $category->id }}" 
                                            name="nama_kategori" 
                                            value="{{ old('nama_kategori', $category->nama_kategori) }}" 
                                            required 
                                            class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm"
                                        >
                                    </div>
                                </div>
                                
                                <div class="mt-6 sm:flex sm:flex-row-reverse gap-2">
                                    <x-button typeHtml="submit" type="primary">Simpan Perubahan</x-button>
                                    <x-button type="button" @click="$dispatch('close-modal', 'modal-kategori-edit-{{ $category->id }}')" type="secondary">Batal</x-button>
                                </div>
                            </form>
                        </x-modal>

                        <!-- ========================================== -->
                        <!-- 3. MODAL HAPUS UNTUK KATEGORI INI -->
                        <!-- ========================================== -->
                        <x-modal name="modal-kategori-delete-{{ $category->id }}" title="Hapus Kategori">
                            <form action="{{ route('kategori.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE') 

                                <div class="space-y-2">
                                    <p class="text-sm text-slate-600">Apakah Anda yakin ingin menghapus kategori <strong class="text-slate-900">{{ $category->nama_kategori }}</strong>?</p>
                                    <p class="text-xs text-rose-600 bg-rose-50 border border-rose-100 p-2 rounded-lg">
                                        Tindakan ini tidak dapat dibatalkan. Pastikan tidak ada naskah aktif yang terhubung dengan kategori ini.
                                    </p>
                                </div>
                                
                                <div class="mt-6 sm:flex sm:flex-row-reverse gap-2">
                                    <x-button typeHtml="submit" type="danger">Hapus Permanen</x-button>
                                    <x-button type="button" @click="$dispatch('close-modal', 'modal-kategori-delete-{{ $category->id }}')" type="secondary">Batal</x-button>
                                </div>
                            </form>
                        </x-modal>

                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-sm text-slate-500">
                                Belum ada kategori yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    <!-- ========================================== -->
    <!-- 4. MODAL TAMBAH KATEGORI (DI LUAR LOOPING) -->
    <!-- ========================================== -->
    <x-modal name="modal-kategori-tambah" title="Tambah Kategori">
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="nama_kategori" class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                    <input 
                        type="text" 
                        id="nama_kategori" 
                        name="nama_kategori" 
                        required 
                        placeholder="Contoh: Buku Ajar"
                        class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm"
                    >
                </div>
            </div>
            
            <div class="mt-6 sm:flex sm:flex-row-reverse gap-2">
                <x-button typeHtml="submit" type="primary">Simpan</x-button>
                <x-button type="button" @click="$dispatch('close-modal', 'modal-kategori-tambah')" type="secondary">Batal</x-button>
            </div>
        </form>
    </x-modal>

</div>
@endsection
