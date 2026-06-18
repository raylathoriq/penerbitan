@extends('layouts.editor')

@section('title', 'Penyuntingan Naskah')
@section('page_title', 'Penyuntingan Naskah')

@section('content')
<div class="mb-6">
    <a href="/editor/naskah" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
        Kembali ke Daftar Naskah
    </a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-[0.9fr_1.4fr] gap-8">
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">Dasar Logika Matematika</h2>
                    <p class="text-sm text-slate-500 mt-1">Dr. Budi Santoso · Buku Ajar</p>
                </div>
                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-teal-50 text-teal-700 ring-1 ring-inset ring-teal-600/20">Menunggu Edit</span>
            </div>

            <div class="mt-6 space-y-4">
                <div>
                    <h4 class="text-slate-500 text-xs font-medium">Abstrak / Sinopsis</h4>
                    <p class="text-sm text-slate-700 mt-1 leading-relaxed">Naskah ini sudah disetujui dan masuk ke tahap penyuntingan. Editor perlu merapikan bahasa, format, dan konsistensi sebelum dikirim kembali ke author.</p>
                </div>
                <div class="pt-4 border-t border-slate-100">
                    <h4 class="text-slate-500 text-xs font-medium mb-3">Dokumen</h4>
                    <a href="#" class="inline-flex items-center w-full justify-between p-3 border border-slate-200 rounded-lg hover:bg-slate-50 hover:border-slate-300 transition-colors group">
                        <div class="flex items-center min-w-0">
                            <svg class="w-5 h-5 text-teal-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            <span class="text-sm font-medium text-slate-900 truncate">naskah_logika_final.pdf</span>
                        </div>
                        <span class="text-xs text-slate-500">2.4 MB</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-sm font-semibold text-slate-900 mb-4 uppercase tracking-wider">Acuan Penyuntingan</h3>
            <div class="space-y-4">
                <div class="p-4 rounded-lg border border-emerald-100 bg-emerald-50/50">
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-sm font-semibold text-slate-900">Reviewer 1</div>
                        <span class="text-xs font-medium text-emerald-700">Sudah disetujui</span>
                    </div>
                    <p class="text-sm text-slate-600 mt-2">Struktur bab sudah kuat. Editor perlu merapikan contoh soal, daftar pustaka, dan konsistensi istilah.</p>
                </div>
                <div class="p-4 rounded-lg border border-amber-100 bg-amber-50/50">
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-sm font-semibold text-slate-900">Reviewer 2</div>
                        <span class="text-xs font-medium text-amber-700">Catatan reviewer</span>
                    </div>
                    <p class="text-sm text-slate-600 mt-2">Bagian latihan perlu dibuat lebih konsisten dengan capaian pembelajaran.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-1">Form Hasil Penyuntingan</h3>
        <p class="text-sm text-slate-500 mb-6">Unggah naskah yang sudah dibenarkan dan kirimkan catatan hasil edit kepada author.</p>

        <form action="#" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status Penyuntingan <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <label class="relative flex cursor-pointer rounded-lg border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:bg-slate-50">
                        <input type="radio" name="editing_status" value="draft" class="peer sr-only">
                        <span class="peer-checked:border-sky-500 peer-checked:ring-1 peer-checked:ring-sky-500 absolute inset-0 rounded-lg border-2 border-transparent pointer-events-none" aria-hidden="true"></span>
                        <div class="flex flex-col text-sm text-center w-full">
                            <span class="font-semibold text-slate-900">Simpan Draft</span>
                            <span class="text-slate-500 mt-1">Edit belum final.</span>
                        </div>
                    </label>
                    <label class="relative flex cursor-pointer rounded-lg border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:bg-slate-50">
                        <input type="radio" name="editing_status" value="perlu_cek" class="peer sr-only">
                        <span class="peer-checked:border-amber-500 peer-checked:ring-1 peer-checked:ring-amber-500 absolute inset-0 rounded-lg border-2 border-transparent pointer-events-none" aria-hidden="true"></span>
                        <div class="flex flex-col text-sm text-center w-full">
                            <span class="font-semibold text-slate-900">Perlu Cek Author</span>
                            <span class="text-slate-500 mt-1">Ada bagian perlu konfirmasi.</span>
                        </div>
                    </label>
                    <label class="relative flex cursor-pointer rounded-lg border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:bg-slate-50">
                        <input type="radio" name="editing_status" value="siap_dikirim" class="peer sr-only">
                        <span class="peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 absolute inset-0 rounded-lg border-2 border-transparent pointer-events-none" aria-hidden="true"></span>
                        <div class="flex flex-col text-sm text-center w-full">
                            <span class="font-semibold text-slate-900">Siap Dikirim</span>
                            <span class="text-slate-500 mt-1">File sudah dibenarkan.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Upload Naskah Hasil Edit <span class="text-rose-500">*</span></label>
                <p class="text-xs text-slate-500 mb-2">Unggah file naskah yang sudah dirapikan oleh editor dalam format PDF, DOC, atau DOCX.</p>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M7 33V13a4 4 0 014-4h13l10 10v14a4 4 0 01-4 4H11a4 4 0 01-4-4zM24 9v10h10M16 29h16M16 23h5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-slate-600 justify-center">
                            <label for="edited-file" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-700 hover:text-teal-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-600">
                                <span>Upload file hasil edit</span>
                                <input id="edited-file" name="edited_file" type="file" class="sr-only" accept=".pdf,.doc,.docx">
                            </label>
                        </div>
                        <p class="text-xs text-slate-500">Maks. ukuran 10MB</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Catatan untuk Author <span class="text-rose-500">*</span></label>
                <p class="text-xs text-slate-500 mb-3">Jelaskan bagian yang sudah dibenarkan dan bagian yang perlu diperiksa author.</p>
                <textarea name="editor_notes" rows="7" class="block w-full border border-slate-200 rounded-lg text-sm p-3 focus:ring-teal-600 focus:border-teal-600 shadow-sm" placeholder="1. Format subbab sudah dirapikan.&#10;2. Istilah pada bab 2 dan bab 4 sudah diseragamkan.&#10;3. Mohon author mengecek kembali tabel 3.1."></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tujuan Pengiriman</label>
                <select name="send_to" class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-teal-600 focus:border-teal-600 shadow-sm">
                    <option value="author">Kirim ke Author</option>
                    <option value="admin">Kirim ke Admin untuk pengecekan</option>
                </select>
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3">
                <button type="button" class="inline-flex items-center justify-center px-5 py-2.5 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-colors active:scale-[0.98]">
                    Simpan Draft
                </button>
                <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-teal-700 hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-600 transition-colors active:scale-[0.98]">
                    Kirim ke Author
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
