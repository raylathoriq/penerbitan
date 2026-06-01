@extends('layouts.author')

@section('page_title', 'Form Pengajuan Naskah')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-slate-900">Detail Publikasi</h3>
            <p class="text-sm text-slate-500 mt-1">Lengkapi informasi buku yang akan diajukan ke Dewan Redaksi.</p>
        </x-slot>
        <form action="#" method="POST" onsubmit="event.preventDefault(); window.location.href='/author/naskah';">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori Naskah</label>
                    <select class="block w-full rounded-lg border-slate-200 py-2.5 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all" required>
                        <option value="" disabled selected>Pilih Kategori Bidang Ilmu...</option>
                        <option value="1">Buku Ajar</option>
                        <option value="2">Buku Referensi</option>
                        <option value="3">Monograf</option>
                        <option value="4">Buku Fiksi / Sastra</option>
                        <option value="5">Panduan / Modul Praktikum</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Buku</label>
                    <input type="text" class="block w-full rounded-lg border-slate-200 py-2.5 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all" required>
                </div>

                <div x-data="{ coAuthors: [] }" class="p-5 bg-white border border-slate-200 rounded-xl shadow-sm">
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Penulis Utama (Anda)</label>
                        <input type="text" value="Dr. Budi Santoso (Author Login)" class="block w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500 py-2.5 px-3 sm:text-sm border shadow-sm" readonly>
                    </div>

                    <div class="mb-3 flex items-center justify-between">
                        <label class="block text-sm font-medium text-slate-700">Penulis Pendamping (Co-Authors)</label>
                        <button type="button" @click="coAuthors.push({ name: '', email: '', affiliation: '' })" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center hover:bg-emerald-50 px-2 py-1 rounded transition-colors">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Penulis
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(author, index) in coAuthors" :key="index">
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-lg relative">
                                <button type="button" @click="coAuthors.splice(index, 1)" class="absolute top-4 right-4 p-1.5 text-rose-500 hover:bg-rose-100 rounded-md transition-colors" title="Hapus Penulis">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                
                                <div class="pr-10 space-y-3">
                                    <div>
                                        <input type="text" x-model="author.name" placeholder="Nama Lengkap dengan Gelar" class="block w-full rounded-lg border-slate-200 py-2.5 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all" required>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <input type="email" x-model="author.email" placeholder="Alamat Email" class="block w-full rounded-lg border-slate-200 py-2.5 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all" required>
                                        <input type="text" x-model="author.affiliation" placeholder="Afiliasi/Institusi" class="block w-full rounded-lg border-slate-200 py-2.5 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all" required>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        <div x-show="coAuthors.length === 0" class="text-sm text-slate-500 bg-slate-50 p-4 rounded-lg border border-slate-100 border-dashed text-center">
                            Belum ada penulis pendamping. Klik "Tambah Penulis" jika naskah ini ditulis oleh lebih dari 1 orang.
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Abstrak / Sinopsis Singkat</label>
                    <textarea rows="5" class="block w-full rounded-lg border-slate-200 p-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all" required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Upload File Naskah (PDF/DOCX)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl bg-slate-50/50 hover:bg-slate-50 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500">
                                    <span>Pilih file</span>
                                    <input type="file" class="sr-only" required>
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-start bg-slate-50 p-4 rounded-lg border border-slate-100">
                    <div class="flex items-center h-5">
                        <input id="persyaratan" type="checkbox" class="focus:ring-emerald-500 h-4 w-4 text-emerald-600 border-slate-300 rounded" required>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="persyaratan" class="font-medium text-slate-700">Pernyataan Orisinalitas</label>
                        <p class="text-slate-500 mt-0.5">Saya menyatakan bahwa naskah ini adalah karya asli dan mematuhi seluruh syarat etika akademik LPPM UPNVJ.</p>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <x-button type="secondary" onclick="window.history.back()">Batal</x-button>
                    <x-button type="primary" typeHtml="submit">Submit Naskah</x-button>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection