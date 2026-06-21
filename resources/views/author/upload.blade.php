@extends('layouts.author')

@section('page_title', 'Form Pengajuan Naskah')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-slate-900">Form Pengajuan Naskah</h3>
            <p class="text-sm text-slate-500 mt-1">
                Lengkapi informasi buku yang akan diajukan ke Dewan Redaksi.
            </p>
        </x-slot>

        <form action="{{ route('author.naskah.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">

                {{-- KATEGORI --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kategori Naskah
                    </label>
                    <select name="category"
                        class="w-full rounded-lg border-slate-200 py-2.5 px-3 text-sm focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                        <option value="" disabled selected>Pilih Kategori...</option>
                        <option>Buku Ajar</option>
                        <option>Buku Referensi</option>
                        <option>Monograf</option>
                        <option>Buku Fiksi / Sastra</option>
                        <option>Panduan / Modul Praktikum</option>
                    </select>
                </div>

                {{-- JUDUL --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Judul Buku
                    </label>
                    <input type="text" name="title"
                        class="w-full rounded-lg border-slate-200 py-2.5 px-3 text-sm focus:border-emerald-500 focus:ring-emerald-500 shadow-sm"
                        required>
                </div>

                {{-- PENULIS --}}
                <div x-data="{ coAuthors: [] }"
                    class="rounded-xl border border-slate-200 p-5 bg-white">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            Penulis Utama
                        </label>
                        <input type="text"
                            value="{{ auth()->user()->name }}"
                            class="w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500 py-2.5 px-3 text-sm"
                            readonly>
                    </div>

                    <div class="flex justify-between items-center mb-3">
                        <label class="text-sm font-medium text-slate-700">
                            Penulis Pendamping (Opsional)
                        </label>

                        <button type="button"
                            @click="coAuthors.push({ name:'', email:'', affiliation:'' })"
                            class="text-sm text-emerald-600 hover:bg-emerald-50 px-2 py-1 rounded">
                            + Tambah
                        </button>
                    </div>

                    <template x-for="(author, index) in coAuthors" :key="index">
                        <div class="relative p-4 mb-3 bg-slate-50 border border-slate-100 rounded-lg">

                            <button type="button"
                                @click="coAuthors.splice(index, 1)"
                                class="absolute top-3 right-3 text-rose-500">
                                ✕
                            </button>

                            <div class="space-y-2">
                                <input type="text" x-model="author.name"
                                    placeholder="Nama Lengkap"
                                    class="w-full rounded-lg border-slate-200 p-2 text-sm">

                                <div class="grid md:grid-cols-2 gap-2">
                                    <input type="email" x-model="author.email"
                                        placeholder="Email"
                                        class="w-full rounded-lg border-slate-200 p-2 text-sm">

                                    <input type="text" x-model="author.affiliation"
                                        placeholder="Institusi"
                                        class="w-full rounded-lg border-slate-200 p-2 text-sm">
                                </div>
                            </div>
                        </div>
                    </template>

                    <div x-show="coAuthors.length === 0"
                        class="text-center text-sm text-slate-500 border border-dashed rounded-lg p-4">
                        Belum ada penulis pendamping
                    </div>
                </div>

                {{-- ABSTRAK --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Abstrak / Sinopsis
                    </label>
                    <textarea name="description" rows="5"
                        class="w-full rounded-lg border-slate-200 p-3 text-sm focus:border-emerald-500 focus:ring-emerald-500 shadow-sm"
                        required></textarea>
                </div>

                {{-- UPLOAD --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Upload File (PDF/DOCX)
                    </label>

                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center bg-slate-50">
                        <input type="file" name="document" class="text-sm">
                    </div>
                </div>

                {{-- CHECKBOX --}}
                <div class="flex items-start gap-3 bg-slate-50 p-4 rounded-lg border">
                    <input type="checkbox" required
                        class="mt-1 h-4 w-4 text-emerald-600">

                    <div class="text-sm">
                        <div class="font-medium text-slate-700">Pernyataan Orisinalitas</div>
                        <p class="text-slate-500">
                            Saya menyatakan naskah ini karya asli.
                        </p>
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <x-button type="secondary" onclick="window.history.back()">
                        Batal
                    </x-button>

                    <x-button typeHtml="submit" type="primary">
                        Submit
                    </x-button>
                </div>

            </div>
        </form>
    </x-card>

</div>
@endsection