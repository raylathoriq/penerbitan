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
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Buku</label>
                    <input type="text" class="block w-full rounded-lg border-slate-200 py-2.5 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Daftar Penulis</label>
                    <input type="text" placeholder="Contoh: Dr. Budi, Prof. Andi" class="block w-full rounded-lg border-slate-200 py-2.5 px-3 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm border shadow-sm transition-all" required>
                    <p class="text-xs text-slate-500 mt-1.5">Gunakan koma untuk memisahkan antar penulis.</p>
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