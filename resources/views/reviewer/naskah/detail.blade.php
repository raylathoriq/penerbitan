@extends('layouts.reviewer')

@section('title', 'Review Naskah')
@section('page_title', 'Form Penilaian Naskah')

@section('content')
<div class="mb-6">
    <a href="/reviewer/naskah" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
        Kembali ke Daftar Penugasan
    </a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    {{-- Info Naskah --}}
    <div class="xl:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-sm font-semibold text-slate-900 mb-4 uppercase tracking-wider">Detail Naskah</h3>
            
            <div class="space-y-4">
                <div>
                    <h4 class="text-slate-500 text-xs font-medium">Judul Naskah</h4>
                    <p class="text-sm font-medium text-slate-900 mt-1">{{ $naskah->title }}</p>
                </div>
                <div>
                    <h4 class="text-slate-500 text-xs font-medium">Abstrak / Sinopsis</h4>
                    <p class="text-sm text-slate-700 mt-1 line-clamp-4">{{ $naskah->description ?? '-' }}</p>
                </div>
                <div class="pt-4 border-t border-slate-100">
                    <h4 class="text-slate-500 text-xs font-medium mb-2">Instruksi Khusus dari Redaksi</h4>
                    <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3 text-sm text-indigo-800">
                        "Mohon perhatikan bagian metodologi statistiknya, apakah sudah sesuai dengan kaidah penelitian kuantitatif."
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-100">
                    <h4 class="text-slate-500 text-xs font-medium mb-3">Unduh Dokumen Naskah</h4>
                    @if($naskah->document_path)
                        <a href="{{ asset('storage/'.$naskah->document_path) }}" target="_blank" rel="noreferrer" class="inline-flex items-center w-full justify-between p-3 border border-slate-200 rounded-lg hover:bg-slate-50 hover:border-slate-300 transition-colors group">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                <span class="text-sm font-medium text-slate-900">{{ $naskah->document_name ?? basename($naskah->document_path) }}</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        </a>
                    @else
                        <p class="text-sm text-slate-500">Tidak ada dokumen terlampir.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Form Review --}}
    <div class="xl:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-1">Form Pengisian Review</h3>
            <p class="text-sm text-slate-500 mb-6">Silakan berikan penilaian objektif Anda terhadap naskah ini. Hasil review akan diteruskan ke tim redaksi untuk ditindaklanjuti ke penulis.</p>

            <form action="{{ route('reviewer.naskah.submitReview', $naskah->id) }}" method="POST" class="space-y-6">
                @csrf
                <!-- Status Rekomendasi (Sesuai kolom `status` di tabel `reviews`) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Rekomendasi Reviewer <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <label class="relative flex cursor-pointer rounded-lg border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:bg-slate-50">
                            <input type="radio" name="status" value="diterima" class="peer sr-only">
                            <span class="peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 absolute inset-0 rounded-lg border-2 border-transparent pointer-events-none" aria-hidden="true"></span>
                            <div class="flex flex-col text-sm text-center w-full">
                                <span class="font-semibold text-slate-900">Diterima</span>
                                <span class="text-slate-500 mt-1">Layak cetak / publikasi.</span>
                            </div>
                        </label>
                        <label class="relative flex cursor-pointer rounded-lg border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:bg-slate-50">
                            <input type="radio" name="status" value="revisi" class="peer sr-only">
                            <span class="peer-checked:border-amber-500 peer-checked:ring-1 peer-checked:ring-amber-500 absolute inset-0 rounded-lg border-2 border-transparent pointer-events-none" aria-hidden="true"></span>
                            <div class="flex flex-col text-sm text-center w-full">
                                <span class="font-semibold text-slate-900">Revisi</span>
                                <span class="text-slate-500 mt-1">Perlu perbaikan penulis.</span>
                            </div>
                        </label>
                        <label class="relative flex cursor-pointer rounded-lg border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:bg-slate-50">
                            <input type="radio" name="status" value="ditolak" class="peer sr-only">
                            <span class="peer-checked:border-rose-500 peer-checked:ring-1 peer-checked:ring-rose-500 absolute inset-0 rounded-lg border-2 border-transparent pointer-events-none" aria-hidden="true"></span>
                            <div class="flex flex-col text-sm text-center w-full">
                                <span class="font-semibold text-slate-900">Ditolak</span>
                                <span class="text-slate-500 mt-1">Tidak sesuai standar.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Reviewer Notes (Sesuai kolom `reviewer_notes` di tabel `reviews`) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Hasil Review (Reviewer Notes) <span class="text-rose-500">*</span></label>
                    <p class="text-xs text-slate-500 mb-3">Tuliskan analisis, kritik, saran, atau bagian yang perlu direvisi secara mendetail.</p>
                    <textarea name="reviewer_notes" rows="8" class="block w-full border border-slate-200 rounded-lg text-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="1. Bagian metodologi pada bab 3 kurang relevan...&#10;2. Kutipan daftar pustaka terlalu lawas..."></textarea>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Upload Naskah Hasil Coretan (Opsional)</label>
                    <p class="text-xs text-slate-500 mb-2">Jika Anda memiliki file hasil koreksi (coretan/komentar) PDF/Word.</p>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload file PDF/Word</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only" accept=".pdf,.doc,.docx">
                                </label>
                            </div>
                            <p class="text-xs text-slate-500">Maks. ukuran 10MB</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Kirim Hasil Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection