@extends('layouts.author')

@section('page_title', 'Form Pengajuan Naskah')

@section('content')
<div class="max-w-3xl" x-data="{ coAuthors: [], fileName: '' }">
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-slate-900">Detail Publikasi</h3>
            <p class="text-sm text-slate-500 mt-1">Lengkapi informasi naskah buku yang akan diajukan ke Dewan Redaksi.</p>
        </x-slot>
        
        <form action="{{ route('author.naskah.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Dropdown Kategori -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori Naskah <span class="text-rose-500">*</span></label>
                    <select name="category_id" class="block w-full rounded-lg border-slate-200 py-2.5 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all focus:outline-none" required>
                        <option value="" disabled selected>Pilih Kategori Bidang Ilmu...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dropdown Paket -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Paket Penerbitan <span class="text-rose-500">*</span></label>
                    <select name="package_id" class="block w-full rounded-lg border-slate-200 py-2.5 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all focus:outline-none" required>
                        <option value="" disabled selected>Pilih Paket Penerbitan...</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>{{ $package->nama_paket }} (Rp {{ number_format($package->harga, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                    @error('package_id')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Judul Buku -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Buku <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="block w-full rounded-lg border-slate-200 py-2.5 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all focus:outline-none" required>
                    @error('title')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penulis Utama & Co-Authors -->
                <div class="p-5 bg-white border border-slate-200 rounded-xl shadow-sm">
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Penulis Utama</label>
                        <input type="text" value="{{ auth()->user()->name }}" class="block w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500 py-2.5 px-3 sm:text-sm border shadow-sm" readonly>
                    </div>

                    <div class="flex justify-between items-center mb-3">
                        <label class="text-sm font-medium text-slate-700">Penulis Pendamping (Opsional)</label>
                        <button type="button" @click="coAuthors.push({ name: '', email: '', affiliation: '' })" class="text-sm text-emerald-600 hover:bg-emerald-50 px-2.5 py-1 rounded transition-colors font-medium">
                            + Tambah Penulis
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(author, index) in coAuthors" :key="index">
                            <div class="relative p-4 bg-slate-50 border border-slate-100 rounded-lg">
                                <button type="button" @click="coAuthors.splice(index, 1)" class="absolute top-3 right-3 text-slate-400 hover:text-rose-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                                
                                <div class="pr-10 space-y-3">
                                    <div>
                                        <input type="text" :name="'co_authors['+index+'][name]'" x-model="author.name" placeholder="Nama Lengkap dengan Gelar" class="block w-full rounded-lg border-slate-200 py-2 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all focus:outline-none" required>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <input type="email" :name="'co_authors['+index+'][email]'" x-model="author.email" placeholder="Alamat Email" class="block w-full rounded-lg border-slate-200 py-2 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all focus:outline-none" required>
                                        <input type="text" :name="'co_authors['+index+'][affiliation]'" x-model="author.affiliation" placeholder="Afiliasi/Institusi" class="block w-full rounded-lg border-slate-200 py-2 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all focus:outline-none" required>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="coAuthors.length === 0" class="text-center text-sm text-slate-400 border border-dashed border-slate-200 rounded-lg p-4 bg-slate-50/50">
                        Belum ada penulis pendamping.
                    </div>
                </div>

                <!-- Sinopsis -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Abstrak / Sinopsis Singkat <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="5" class="block w-full rounded-lg border-slate-200 p-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all focus:outline-none" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload File -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Upload File Naskah (PDF/DOC/DOCX) <span class="text-rose-500">*</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl bg-slate-50/50 hover:bg-slate-50 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none">
                                    <span>Pilih file</span>
                                    <input type="file" name="document" accept=".pdf,.doc,.docx" class="sr-only" required @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <div x-show="fileName" class="text-xs text-emerald-600 font-semibold mt-2 animate-pulse" x-text="'File terpilih: ' + fileName"></div>
                        </div>
                    </div>
                    @error('document')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Persyaratan -->
                <div class="flex items-start bg-slate-50 p-4 rounded-lg border border-slate-100">
                    <div class="flex items-center h-5">
                        <input id="persyaratan" type="checkbox" class="focus:ring-emerald-500 h-4 w-4 text-emerald-600 border-slate-300 rounded focus:outline-none" required>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="persyaratan" class="font-medium text-slate-700">Pernyataan Orisinalitas</label>
                        <p class="text-slate-500 mt-0.5">Saya menyatakan bahwa naskah ini adalah karya asli dan mematuhi seluruh syarat etika akademik LPPM UPNVJ.</p>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <x-button type="secondary" onclick="window.history.back()">Batal</x-button>
                    <x-button type="primary" typeHtml="submit">Submit Naskah</x-button>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection