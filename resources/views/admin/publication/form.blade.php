@extends('layouts.admin')

@section('page_title', 'Rilis Publikasi Buku')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-slate-900">Form Publikasi</h3>
            <p class="text-sm text-slate-500 mt-1">Masukkan ISBN dan file final untuk ditampilkan di Katalog Publik.</p>
        </x-slot>
        <form action="#" method="POST" onsubmit="event.preventDefault(); window.location.href='/admin/naskah';">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Pilih Naskah (Status Diterima)</label>
                    <select class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm bg-white">
                        <option>Dasar Logika Matematika (Dr. Budi) - ID: #101</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor ISBN</label>
                        <input type="text" placeholder="Contoh: 978-602-1234-xx-x" class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Terbit Pustaka</label>
                        <input type="date" class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                    </div>
                </div>

                <div x-data="{ metadata: [{ key: 'citation_pages', value: '' }] }" class="pt-4 border-t border-slate-100">
                    <div class="flex justify-between items-center mb-3">
                        <label class="block text-sm font-medium text-slate-700">Metadata Buku (Scholar)</label>
                        <button type="button" @click="metadata.push({ key: '', value: '' })" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">
                            + Tambah Meta
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(meta, index) in metadata" :key="index">
                            <div class="flex gap-3 items-center">
                                <input type="text" x-model="meta.key" placeholder="Meta Key (cnth: harga)" class="w-1/3 border border-slate-200 rounded-lg text-sm py-2 px-3 focus:ring-emerald-500 focus:border-emerald-500">
                                <input type="text" x-model="meta.value" placeholder="Nilai Meta..." class="flex-1 border border-slate-200 rounded-lg text-sm py-2 px-3 focus:ring-emerald-500 focus:border-emerald-500">
                                <button type="button" @click="metadata.splice(index, 1)" class="text-rose-500 hover:text-rose-700 p-2">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Data metadata tambahan ini akan dirender secara dinamis untuk tabel publication_metadata.</p>
                </div>

                <div class="pt-2">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Cetak PDF (Versi Publik)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl cover bg-slate-50/50 hover:bg-slate-50 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500 px-1">
                                    <span>Upload a file</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-slate-500">PDF up to 10MB</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <x-button type="primary" typeHtml="submit">Terbitkan </x-button>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection