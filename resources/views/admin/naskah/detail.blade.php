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
                        <p class="text-slate-500 mt-1">Diajukan oleh {{ $naskah->user->name ?? '-' }}</p>
                        @php $detailDate = $naskah->submitted_at ?? $naskah->created_at; @endphp
                        <p class="text-xs text-slate-400 mt-0.5">Diajukan pada: {{ $detailDate ? $detailDate->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') . ' WIB' : '-' }}</p>
                    </div>
                    <x-badge :status="$naskah->status" />
                </div>

                <div class="mb-5 text-sm">
                    <span class="text-slate-500">Kategori:</span> <span class="font-semibold text-emerald-800">{{ $naskah->category->nama_kategori ?? '-' }}</span>
                    <span class="mx-2 text-slate-300">|</span>
                    <span class="text-slate-500">Paket:</span> <span class="font-semibold text-emerald-800">{{ $naskah->package->nama_paket ?? '-' }}</span>
                </div>

                @if(!empty($naskah->co_author))
                    <div class="mb-5 text-sm p-4 bg-slate-50/50 border border-slate-100 rounded-xl">
                        <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Penulis Pendamping</h4>
                        <div class="space-y-1">
                            @foreach($naskah->co_author as $co)
                                <p class="text-slate-700">— {{ $co['name'] ?? '-' }} ({{ $co['affiliation'] ?? '-' }}) <span class="text-slate-400">&lt;{{ $co['email'] ?? '-' }}&gt;</span></p>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="prose prose-slate max-w-none text-sm border-t border-slate-100 pt-5">
                    <p>{{ $naskah->description ?? 'Tidak ada deskripsi yang tersedia untuk naskah ini.' }}</p>
                </div>

                <div class="mt-8 border-t border-slate-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 mb-3">Dokumen Naskah</h4>
                    @if($naskah->document_path)
                        <a href="{{ asset('storage/' . $naskah->document_path) }}" target="_blank" class="inline-flex items-center p-3 border border-slate-200 rounded-lg hover:bg-slate-50 hover:border-slate-300 transition-colors group">
                            <div class="bg-rose-100 text-rose-600 p-2 rounded mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900 group-hover:text-emerald-700 transition-colors">{{ $naskah->document_name ?? 'Dokumen tidak tersedia' }}</p>
                                <p class="text-xs text-slate-500">{{ $naskah->document_size ?? '-' }}</p>
                            </div>
                        </a>
                    @else
                        <p class="text-sm text-slate-500">File tidak tersedia.</p>
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
                    <p class="text-sm text-slate-500 mb-4">Pilih tindakan yang ingin diambil untuk naskah ini berdasarkan hasil pengecekan Anda atau Dewan Redaksi.</p>

                    <button type="button" @click="showReviewerModal = true"
                        class="w-full relative flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors">
                        Kirim ke Reviewer
                    </button>

                    <button type="button" @click="showStatusModal = true"
                        class="w-full relative flex justify-center py-2.5 px-4 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 shadow-sm transition-colors">
                        Ubah Status Naskah
                    </button>

                    @if($naskah->reviewer_id)
                        <div class="mt-4 pt-4 border-t border-slate-100 text-sm">
                            <span class="text-slate-400 font-semibold text-xs uppercase tracking-wider block mb-1">Reviewer Ditugaskan</span>
                            <div class="font-medium text-slate-800">
                                {{ $naskah->reviewer->name ?? $naskah->reviewer_name }}
                            </div>
                        </div>
                    @endif
                </div>
            </x-card>
        </div>

        {{-- Modal Kirim ke Reviewer (Tabel `reviews`) --}}
        <div x-show="showReviewerModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="showReviewerModal" x-transition.opacity class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showReviewerModal" x-transition.opacity @click.away="showReviewerModal = false"
                        class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <form action="{{ route('admin.naskah.assignReviewer', $naskah->id) }}" method="POST">
                            @csrf
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-semibold text-slate-900" id="modal-title">Tugaskan Reviewer Baru</h3>
                                        <div class="mt-4 space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Reviewer</label>
                                                <select name="reviewer_id" class="block w-full border border-slate-200 rounded-lg text-sm py-2 px-3 focus:ring-emerald-500 focus:border-emerald-500">
                                                    <option disabled selected>-- Pilih Reviewer --</option>
                                                    @foreach($reviewers as $reviewer)
                                                        <option value="{{ $reviewer->id }}" {{ $naskah->reviewer_id === $reviewer->id ? 'selected' : '' }}>
                                                            {{ $reviewer->name }} ({{ $reviewer->afiliasi ?? 'Reviewer' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Instruksi Khusus (Opsional)</label>
                                                <textarea name="note" rows="3" class="block w-full border border-slate-200 rounded-lg text-sm p-3 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Mohon perhatikan bagian metodologi statistiknya..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                                <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto">Tugaskan Sekarang</button>
                                <button type="button" @click="showReviewerModal = false" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Ubah Status --}}
        <div x-show="showStatusModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="showStatusModal" x-transition.opacity class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
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
                                        <h3 class="text-lg leading-6 font-semibold text-slate-900" id="modal-title">Ubah Status & Catatan Penulis</h3>
                                        <div class="mt-4 space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Status Naskah Terbaru</label>
                                                <select name="status" class="block w-full border border-slate-200 rounded-lg text-sm py-2 px-3 focus:ring-emerald-500 focus:border-emerald-500">
                                                    <option disabled {{ $naskah->status ? '' : 'selected' }}>-- Pilih Keputusan --</option>
                                                    <option value="revisi" {{ $naskah->status === 'revisi' ? 'selected' : '' }}>Butuh Revisi (Kembalikan ke Penulis)</option>
                                                    <option value="diterima" {{ $naskah->status === 'diterima' ? 'selected' : '' }}>Diterima (Lanjut Publikasi)</option>
                                                    <option value="ditolak" {{ $naskah->status === 'ditolak' ? 'selected' : '' }}>Ditolak (Naskah Invalid)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Tambahan (Notes)</label>
                                                <textarea name="note" rows="4" class="block w-full border border-slate-200 rounded-lg text-sm p-3 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Catatan ini akan masuk ke riwayat (Status Histories) dan dapat dibaca oleh penulis..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                                <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-800 sm:ml-3 sm:w-auto">Simpan Keputusan</button>
                                <button type="button" @click="showStatusModal = false" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection