@extends('layouts.admin')

@section('page_title', 'Review & Validasi Naskah')

@section('content')
    <div class="mb-6">
        <a href="/admin/naskah"
            class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <div x-data="{ showStatusModal: false, showReviewerModal: false }" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $naskah->title }}</h2>
                        <p class="text-slate-500 mt-1">Diajukan oleh {{ $naskah->author_name }}</p>
                        @php $detailDate = $naskah->submitted_at ?? $naskah->created_at; @endphp
                        <p class="text-xs text-slate-400 mt-0.5">Diajukan pada:
                            {{ $detailDate ? $detailDate->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') . ' WIB' : '-' }}
                        </p>
                    </div>
                    
                    {{-- Badge Status Dinamis Mengikuti Data Database --}}
                    <div>
                        @if($naskah->status === 'diajukan')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200">
                                Diajukan
                            </span>
                        @elseif($naskah->status === 'dalam review')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-800 border border-blue-200">
                                Dalam Review
                            </span>
                        @elseif($naskah->status === 'revisi')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-800 border border-orange-200">
                                Revisi
                            </span>
                        @elseif($naskah->status === 'diterima')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200">
                                Diterima
                            </span>
                        @elseif($naskah->status === 'ditolak')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-800 border border-rose-200">
                                Ditolak
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-50 text-slate-800 border border-slate-200">
                                {{ ucfirst($naskah->status) }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="prose prose-slate max-w-none text-sm">
                    <p>{{ $naskah->description ?? 'Tidak ada deskripsi yang tersedia untuk naskah ini.' }}</p>
                </div>

                {{-- Blok Unduh Dokumen Naskah Sinkron Lokal --}}
                <div class="mt-8 border-t border-slate-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 mb-3">Dokumen Naskah</h4>
                    @if ($naskah->document_path)
                        <a href="{{ asset('storage/' . $naskah->document_path) }}" target="_blank" rel="noreferrer" class="mt-2 inline-flex items-center px-4 py-2 border border-slate-200 shadow-sm rounded-lg text-sm text-slate-700 bg-white hover:bg-slate-50 hover:text-emerald-700 transition-colors">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            {{ $naskah->document_name }}
                        </a>
                    @else
                        <p class="text-sm text-slate-500 italic">Berkas berkas dokumen belum diunggah oleh author.</p>
                    @endif
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-1">
            <x-card class="sticky top-6">
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-slate-900">Aksi Admin</h3>
                </x-slot>

                <div class="space-y-4">
                    <p class="text-sm text-slate-500 mb-4">Pilih tindakan yang ingin diambil untuk naskah ini berdasarkan
                        hasil pengecekan Anda atau Dewan Redaksi.</p>

                    <button type="button" @click="showReviewerModal = true"
                        class="w-full relative flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors">
                        Kirim ke Reviewer
                    </button>

                    <button type="button" @click="showStatusModal = true"
                        class="w-full relative flex justify-center py-2.5 px-4 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 shadow-sm transition-colors">
                        Ubah Status Naskah
                    </button>
                </div>
            </x-card>
        </div>

        {{-- Modal Kirim ke Reviewer (Tabel `reviews`) --}}
        <div x-show="showReviewerModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div x-show="showReviewerModal" x-transition.opacity class="fixed inset-0 bg-slate-900/75 transition-opacity">
            </div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showReviewerModal" x-transition.opacity @click.away="showReviewerModal = false"
                        class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <form action="{{ route('admin.naskah.assignReviewer', $naskah->id) }}" method="POST">
                            @csrf
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-semibold text-slate-900" id="modal-title">Tugaskan
                                            Reviewer Baru</h3>
                                        <div class="mt-4 space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Reviewer</label>
                                                <select name="reviewer_id"
                                                    class="block w-full border border-slate-200 rounded-lg text-sm py-2 px-3 focus:ring-emerald-500 focus:border-emerald-500">
                                                    <option disabled selected>-- Pilih Reviewer --</option>
                                                    @foreach($reviewers as $reviewer)
                                                        <option value="{{ $reviewer->id }}" {{ $naskah->reviewer_id === $reviewer->id ? 'selected' : '' }}>
                                                            {{ $reviewer->name }} ({{ $reviewer->afiliasi ?? 'Reviewer' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Instruksi
                                                    Khusus (Opsional)</label>
                                                <textarea name="note" rows="3"
                                                    class="block w-full border border-slate-200 rounded-lg text-sm p-3 focus:ring-emerald-500 focus:border-emerald-500"
                                                    placeholder="Contoh: Mohon perhatikan bagian metodologi statistiknya..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto">Tugaskan
                                    Sekarang</button>
                                <button type="button" @click="showReviewerModal = false"
                                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Ubah Status (Tabel `status_histories`) --}}
        <div x-show="showStatusModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div x-show="showStatusModal" x-transition.opacity class="fixed inset-0 bg-slate-900/75 transition-opacity">
            </div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showStatusModal" x-transition.opacity @click.away="showStatusModal = false"
                        class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <form action="{{ route('admin.naskah.update', $naskah->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-semibold text-slate-900" id="modal-title">Ubah
                                            Status & Catatan Penulis</h3>
                                        <div class="mt-4 space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Status Naskah
                                                    Terbaru</label>
                                                <select name="status"
                                                    class="block w-full border border-slate-200 rounded-lg text-sm py-2 px-3 focus:ring-emerald-500 focus:border-emerald-500">
                                                    <option disabled {{ $naskah->status ? '' : 'selected' }}>-- Pilih Keputusan --</option>
                                                    <option value="revisi" {{ $naskah->status === 'revisi' ? 'selected' : '' }}>Butuh Revisi (Kembalikan ke Penulis)</option>
                                                    <option value="diterima" {{ $naskah->status === 'diterima' ? 'selected' : '' }}>Diterima (Lanjut Publikasi)</option>
                                                    <option value="ditolak" {{ $naskah->status === 'ditolak' ? 'selected' : '' }}>Ditolak (Naskah Invalid)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Catatan
                                                    Tambahan (Notes)</label>
                                                <textarea name="note" rows="4"
                                                    class="block w-full border border-slate-200 rounded-lg text-sm p-3 focus:ring-emerald-500 focus:border-emerald-500"
                                                    placeholder="Catatan ini akan masuk ke riwayat (Status Histories) dan dapat dibaca oleh penulis..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-800 sm:ml-3 sm:w-auto">Simpan
                                    Keputusan</button>
                                <button type="button" @click="showStatusModal = false"
                                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection