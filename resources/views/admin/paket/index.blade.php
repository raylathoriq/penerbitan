@extends('layouts.admin')

@section('title', 'Manajemen Paket Penerbitan - Admin LPPM UPNVJ Press')
@section('page_title', 'Manajemen Paket')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <p class="text-sm text-slate-500">Kelola paket penerbitan buku (harga, kuota cetak, fasilitas pendukung) untuk calon penulis.</p>
        </div>
        <div>
            <!-- Tombol Tambah (Membuka modal-tambah) -->
            <x-button type="primary" @click="$dispatch('open-modal', 'modal-paket-tambah')" class="w-full sm:w-auto shadow-md">
                <i class="bi bi-plus-lg mr-2 text-sm"></i>
                Tambah Paket Baru
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
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Paket</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider max-w-sm">Deskripsi</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    <!-- 1. LOOPING DATA PAKET DARI CONTROLLER -->
                    @forelse($packages as $index => $package)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">{{ $package->nama_paket }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-700">
                                {{$package->harga}}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate" title="{{ $package->deskripsi }}">{{ $package->deskripsi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $package->status === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                    {{ $package->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <!-- Tombol Edit (Membuka modal edit spesifik ID) -->
                                <x-button type="ghost" @click="$dispatch('open-modal', 'modal-paket-edit-{{ $package->id }}')" class="!p-2 !bg-orange-600 !text-white hover:!bg-orange-700 border border-orange-600 shadow-sm transition-all duration-200">
                                    <i class="bi bi-pencil-square text-sm"></i>
                                </x-button>

                                <!-- Tombol Hapus (Membuka modal hapus spesifik ID) -->
                                <x-button type="ghost" @click="$dispatch('open-modal', 'modal-paket-delete-{{ $package->id }}')" class="!p-2 !bg-rose-600 !text-white hover:!bg-rose-700 border border-rose-600 shadow-sm transition-all duration-200">
                                    <i class="bi bi-trash text-sm"></i>
                                </x-button>
                            </td>
                        </tr>

                        <!-- ========================================== -->
                        <!-- 2. MODAL EDIT UNTUK PAKET INI -->
                        <!-- ========================================== -->
                        <x-modal name="modal-paket-edit-{{ $package->id }}" title="Edit Paket Penerbitan">
                            <form action="{{route('paket.update', $package)}}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <div>
                                        <label for="name_{{ $package->id }}" class="block text-sm font-medium text-slate-700 mb-1">Nama Paket <span class="text-rose-500">*</span></label>
                                        <input 
                                            type="text" 
                                            id="name_{{ $package->id }}" 
                                            name="nama_paket" 
                                            value="{{ old('nama_paket', $package->nama_paket) }}" 
                                            required 
                                            class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm"
                                        >
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="price_{{ $package->id }}" class="block text-sm font-medium text-slate-700 mb-1">Harga (Rupiah) <span class="text-rose-500">*</span></label>
                                            <div class="relative rounded-lg shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-slate-400 text-sm">Rp</span>
                                                </div>
                                                <input 
                                                    type="number" 
                                                    id="price_{{ $package->id }}" 
                                                    name="harga" 
                                                    value="{{ old('harga', $package->harga) }}" 
                                                    required 
                                                    min="0"
                                                    class="block w-full border border-slate-200 rounded-lg py-2 pl-9 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm"
                                                >
                                            </div>
                                        </div>

                                        <div>
                                            <label for="status_{{ $package->id }}" class="block text-sm font-medium text-slate-700 mb-1">Status Keaktifan <span class="text-rose-500">*</span></label>
                                            <select 
                                                id="status_{{ $package->id }}" 
                                                name="status" 
                                                class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm bg-white"
                                            >
                                                <option value="Aktif" {{ $package->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Nonaktif" {{ $package->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="description_{{ $package->id }}" class="block text-sm font-medium text-slate-700 mb-1">Keterangan & Fasilitas</label>
                                        <textarea 
                                            id="description_{{ $package->id }}" 
                                            name="deskripsi" 
                                            rows="3" 
                                            class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm"
                                        >{{ old('deskripsi', $package->deskripsi) }}</textarea>
                                    </div>
                                </div>

                                <div class="mt-6 sm:flex sm:flex-row-reverse gap-2">
                                    <x-button typeHtml="submit" type="primary">Simpan Perubahan</x-button>
                                    <x-button type="button" @click="$dispatch('close-modal', 'modal-paket-edit-{{ $package->id }}')" type="secondary">Batal</x-button>
                                </div>
                            </form>
                        </x-modal>

                        <!-- ========================================== -->
                        <!-- 3. MODAL HAPUS UNTUK PAKET INI -->
                        <!-- ========================================== -->
                        <x-modal name="modal-paket-delete-{{ $package->id }}" title="Hapus Paket Penerbitan">
                            <form action="{{route('paket.destroy', $package)}}" method="POST">
                                @csrf
                                @method('DELETE')

                                <div class="space-y-2">
                                    <p class="text-sm text-slate-600">Apakah Anda yakin ingin menghapus paket <strong class="text-slate-900">{{ $package->name }}</strong>?</p>
                                    <p class="text-xs text-rose-600 bg-rose-50 border border-rose-100 p-2 rounded-lg">
                                        Menghapus paket ini akan menonaktifkannya dari sistem. Pastikan tidak ada pengajuan tertunda (*pending*) yang sedang menggunakan paket ini.
                                    </p>
                                </div>

                                <div class="mt-6 sm:flex sm:flex-row-reverse gap-2">
                                    <x-button typeHtml="submit" type="danger">Hapus Permanen</x-button>
                                    <x-button type="button" @click="$dispatch('close-modal', 'modal-paket-delete-{{ $package->id }}')" type="secondary">Batal</x-button>
                                </div>
                            </form>
                        </x-modal>

                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">
                                Belum ada paket yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    <!-- ========================================== -->
    <!-- 4. MODAL TAMBAH PAKET (DI LUAR LOOPING) -->
    <!-- ========================================== -->
    <x-modal name="modal-paket-tambah" title="Tambah Paket Baru">
        <form action="{{route('paket.store')}}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Paket <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="nama_paket" 
                        required 
                        placeholder="Contoh: Paket Gold Cetak"
                        class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm"
                    >
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-slate-700 mb-1">Harga (Rupiah)</label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-400 text-sm">Rp</span>
                            </div>
                            <input 
                                type="number" 
                                id="price" 
                                name="harga" 
                                required 
                                min="0"
                                placeholder="0"
                                class="block w-full border border-slate-200 rounded-lg py-2 pl-9 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm"
                            >
                        </div>
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select 
                            id="status" 
                            name="status" 
                            class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm bg-white"
                        >
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea 
                        id="description" 
                        name="deskripsi" 
                        rows="3" 
                        placeholder="Tulis deskripsi paket..."
                        class="block w-full border border-slate-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm"
                    ></textarea>
                </div>
            </div>
            
            <div class="mt-6 sm:flex sm:flex-row-reverse gap-2">
                <x-button typeHtml="submit" type="primary">Simpan</x-button>
                <x-button type="button" @click="$dispatch('close-modal', 'modal-paket-tambah')" type="secondary">Batal</x-button>
            </div>
        </form>
    </x-modal>

</div>
@endsection
