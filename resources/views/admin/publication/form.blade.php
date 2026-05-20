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
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor ISBN</label>
                    <input type="text" placeholder="Contoh: 978-602-1234-xx-x" class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                </div>

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