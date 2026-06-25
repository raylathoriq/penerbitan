@extends('layouts.admin')

@section('page_title', 'Review & Validasi Naskah')

@section('content')
    <div class="mb-6">
        <a href="/admin/naskah"
            class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors uppercase tracking-wider">
            Kembali ke Daftar
        </a>
    </div>

    <div x-data="{ showStatusModal: false, showReviewerModal: false, showEditorModal: false }" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Detail Dokumen & Riwayat --}}
        <div class="lg:col-span-2 space-y-6">
            <x-card class="shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-200/50">
                {{-- Header Naskah --}}
                <div class="border-b border-slate-100 pb-5 mb-5">
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                        <div class="space-y-2">
                            <h2 class="text-2xl font-bold text-slate-900 tracking-tight leading-snug">{{ $naskah->title }}</h2>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500">
                                <span class="font-medium text-slate-700">{{ $naskah->user->name ?? '-' }}</span>
                                @if(!empty($naskah->user->afiliasi))
                                    <span class="text-slate-400">({{ $naskah->user->afiliasi }})</span>
                                @endif
                                <span class="text-slate-300">|</span>
                                <span class="font-mono text-slate-400">{{ $naskah->user->email ?? '-' }}</span>
                                <span class="text-slate-300">|</span>
                                @php $detailDate = $naskah->submitted_at ?? $naskah->created_at; @endphp
                                <span>Diajukan: {{ $detailDate ? $detailDate->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') . ' WIB' : '-' }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <x-badge :status="$naskah->status_label" />
                        </div>
                    </div>
                </div>

                {{-- Detail Metadata Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-slate-50/75 border border-slate-200/40 rounded-xl mb-6">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Kategori Naskah</span>
                        <span class="text-xs font-semibold text-slate-700 mt-1 block">{{ $naskah->category->nama_kategori ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Paket Layanan</span>
                        <span class="text-xs font-semibold text-emerald-700 mt-1 block">{{ $naskah->package->nama_paket ?? '-' }}</span>
                    </div>
                </div>

                {{-- Penulis Pendamping --}}
                @if(!empty($naskah->co_author))
                    <div class="mb-6">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Penulis Pendamping (Co-Authors)</span>
                        <div class="text-xs text-slate-600 space-y-1">
                            @foreach($naskah->co_author as $co)
                                <p class="font-semibold">{{ $co['name'] ?? '-' }} <span class="text-slate-450 font-normal">({{ $co['affiliation'] ?? '-' }} · {{ $co['email'] ?? '-' }})</span></p>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Abstrak / Sinopsis --}}
                <div class="mb-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2.5">Abstrak / Sinopsis</h4>
                    <div class="text-xs text-slate-600 leading-relaxed border-l-2 border-slate-200 pl-4 py-0.5 whitespace-pre-line font-light">
                        {{ $naskah->description ?? 'Tidak ada deskripsi yang tersedia untuk naskah ini.' }}
                    </div>
                </div>

                {{-- Dokumen Naskah --}}
                <div class="mb-6 border-t border-slate-100 pt-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Dokumen Naskah</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php $authorFiles = $naskah->files()->whereIn('jenis_file', ['original', 'revisi'])->orderBy('version')->get(); @endphp
                        @forelse($authorFiles as $file)
                            <div class="flex items-center justify-between p-3 bg-slate-50 border border-slate-200/60 rounded-xl hover:bg-slate-50 transition-colors group">
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-700 truncate" title="{{ $file->file_name }}">{{ $file->file_name }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[9px] font-bold text-rose-600 bg-rose-50 px-1.5 py-0.5 rounded border border-rose-100 uppercase">PDF</span>
                                        @if($file->file_size)
                                            <span class="text-[10px] text-slate-400">{{ round($file->file_size / 1024, 1) }} KB</span>
                                        @endif
                                        <span class="text-[10px] text-slate-300">•</span>
                                        <span class="text-[10px] text-slate-500 font-medium">{{ $file->jenis_file === 'revisi' ? 'Revisi v' . $file->version : 'Asli' }}</span>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-[11px] font-semibold text-slate-500 hover:text-slate-800 hover:underline flex-shrink-0 ml-4">
                                    Unduh
                                </a>
                            </div>
                        @empty
                            <div class="sm:col-span-2 py-4 text-center border border-dashed border-slate-200 rounded-xl">
                                <p class="text-xs text-slate-400 font-light">Berkas penulis belum diunggah.</p>
                            </div>
                        @endforelse

                        @php $coverFile = $naskah->editorCoverFile(); @endphp
                        @if($coverFile)
                            <div class="flex items-center justify-between p-3 bg-indigo-50/30 border border-indigo-100 rounded-xl hover:bg-indigo-50/50 transition-colors group">
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-indigo-950 truncate" title="{{ $coverFile->file_name }}">{{ $coverFile->file_name }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[9px] font-bold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-100 uppercase">Cover</span>
                                        @if($coverFile->file_size)
                                            <span class="text-[10px] text-indigo-400">{{ round($coverFile->file_size / 1024, 1) }} KB</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $coverFile->file_path) }}" target="_blank" class="text-[11px] font-semibold text-indigo-600 hover:text-indigo-800 hover:underline flex-shrink-0 ml-4">
                                    Unduh
                                </a>
                            </div>
                        @endif

                        @php $editorFile = $naskah->editorFile(); @endphp
                        @if($editorFile)
                            <div class="flex items-center justify-between p-3 bg-teal-50/30 border border-teal-100 rounded-xl hover:bg-teal-50/50 transition-colors group">
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-teal-955 truncate" title="{{ $editorFile->file_name }}">{{ $editorFile->file_name }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[9px] font-bold text-teal-600 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-100 uppercase">Draft</span>
                                        @if($editorFile->file_size)
                                            <span class="text-[10px] text-teal-400">{{ round($editorFile->file_size / 1024, 1) }} KB</span>
                                        @endif
                                        <span class="text-[10px] text-teal-300">•</span>
                                        <span class="text-[10px] text-teal-500 font-medium">Editor v{{ $editorFile->version }}</span>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $editorFile->file_path) }}" target="_blank" class="text-[11px] font-semibold text-teal-600 hover:text-teal-800 hover:underline flex-shrink-0 ml-4">
                                    Unduh
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Riwayat Evaluasi & Penyuntingan --}}
                <div class="mb-2 border-t border-slate-100 pt-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Riwayat Evaluasi & Penyuntingan</h4>
                    
                    @php
                        $hasReviews = $naskah->reviews->isNotEmpty();
                        $hasEditorLogs = $naskah->editorLogs->isNotEmpty();
                    @endphp

                    @if(!$hasReviews && !$hasEditorLogs)
                        <div class="p-4 border border-dashed border-slate-200 rounded-xl text-center">
                            <p class="text-xs text-slate-400 font-light">Belum ada riwayat review atau penyuntingan pada naskah ini.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            {{-- Reviewer Section --}}
                            @if($hasReviews)
                                @foreach($naskah->reviews as $review)
                                    <div class="border border-slate-200/60 rounded-xl p-4 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
                                        <div class="flex justify-between items-start gap-4">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[10px] font-bold text-indigo-700 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-100 uppercase">Reviewer</span>
                                                    <span class="text-xs font-bold text-slate-800">{{ $review->reviewer->name ?? '-' }}</span>
                                                </div>
                                                <p class="text-[10px] text-slate-400 mt-1">
                                                    @if($review->reviewed_at)
                                                        Selesai pada: {{ $review->reviewed_at->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') }} WIB
                                                    @else
                                                        Status: Sedang Berjalan
                                                    @endif
                                                </p>
                                            </div>
                                            
                                            <div class="flex-shrink-0">
                                                @if($review->decision)
                                                    <x-badge :status="$review->decision" />
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-semibold bg-slate-50 text-slate-600 border border-slate-200">
                                                        Menunggu Review
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        @if($review->assignment_note)
                                            <div class="mt-3 p-2.5 bg-indigo-50/50 border border-indigo-100/30 rounded-lg text-xs text-indigo-955">
                                                <span class="font-bold text-[10px] uppercase tracking-wider block text-indigo-700">Instruksi Admin:</span>
                                                <p class="mt-0.5 font-light leading-relaxed">"{{ $review->assignment_note }}"</p>
                                            </div>
                                        @endif

                                        @if($review->comments)
                                            <div class="mt-3 p-3 bg-slate-50/60 border border-slate-150 rounded-lg text-xs text-slate-700 whitespace-pre-line leading-relaxed">
                                                {{ $review->comments }}
                                            </div>
                                        @endif

                                        @if($review->reviewed_at)
                                            @php $reviewerFile = $naskah->reviewerFile(); @endphp
                                            @if($reviewerFile)
                                                <div class="mt-3 flex items-center justify-between text-xs bg-slate-50 border border-slate-200/50 p-2.5 rounded-lg">
                                                    <span class="text-slate-500 font-medium">File Koreksi Reviewer:</span>
                                                    <a href="{{ asset('storage/' . $reviewerFile->file_path) }}" target="_blank" class="font-semibold text-indigo-650 hover:text-indigo-800 transition-colors underline truncate max-w-[200px]">
                                                        {{ $reviewerFile->file_name }}
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                            {{-- Editor Section --}}
                            @if($hasEditorLogs)
                                @foreach($naskah->editorLogs as $log)
                                    <div class="border border-slate-200/60 rounded-xl p-4 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
                                        <div class="flex justify-between items-start gap-4">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[10px] font-bold text-teal-700 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-100 uppercase">Editor</span>
                                                    <span class="text-xs font-bold text-slate-800">{{ $log->editor->name ?? '-' }}</span>
                                                </div>
                                                <p class="text-[10px] text-slate-400 mt-1">
                                                    Selesai pada: {{ $log->tanggal_edit->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') }} WIB
                                                </p>
                                            </div>
                                            
                                            @php
                                                $decisionLabel = [
                                                    'perlu_edit' => 'Ditugaskan ke Editor',
                                                    'draft' => 'Draft Disimpan',
                                                    'perlu_cek' => 'Perlu Cek Author',
                                                    'siap_dikirim' => 'Siap Dikirim / Selesai',
                                                ][$log->decision] ?? $log->decision;
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-semibold bg-teal-50 text-teal-700 border border-teal-100/50">
                                                {{ $decisionLabel }}
                                            </span>
                                        </div>

                                        @if($log->comments)
                                            <div class="mt-3 p-3 bg-slate-50/60 border border-slate-150 rounded-lg text-xs text-slate-700 whitespace-pre-line leading-relaxed">
                                                {{ $log->comments }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>
            </x-card>
        </div>

        {{-- Kolom Kanan: Panel Aksi Admin --}}
        <div class="lg:col-span-1">
            <x-card class="sticky top-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-200/50">
                <x-slot name="header">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Panel Kontrol Naskah</h3>
                </x-slot>

                <div class="space-y-4">
                    <p class="text-xs text-slate-450 leading-relaxed">Tugaskan reviewer / editor atau ubah status naskah setelah berdiskusi dengan Dewan Redaksi.</p>

                    <div class="space-y-2 pt-2">
                        <button type="button" @click="showReviewerModal = true"
                            class="w-full text-center py-2.5 px-4 text-xs font-bold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors focus:outline-none tracking-wide">
                            Tugaskan Reviewer
                        </button>

                        <button type="button" @click="showEditorModal = true"
                            {{ ($naskah->status !== 'diterima' && $naskah->status !== 'pengajuan_isbn') ? 'disabled' : '' }}
                            class="w-full text-center py-2.5 px-4 text-xs font-bold rounded-lg text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition-colors focus:outline-none disabled:opacity-40 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-450 tracking-wide">
                            Tugaskan Editor
                        </button>

                        <button type="button" @click="showStatusModal = true"
                            class="w-full text-center py-2.5 px-4 text-xs font-bold rounded-lg text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/80 shadow-sm transition-colors focus:outline-none tracking-wide">
                            Ubah Status Naskah
                        </button>
                    </div>

                    {{-- Staf Ditugaskan --}}
                    <div class="border-t border-slate-100 pt-4 mt-4 space-y-3.5">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Reviewer Ditugaskan</span>
                            @if($naskah->reviewer_id)
                                <div class="p-3 bg-slate-50/75 border border-slate-200 rounded-lg">
                                    <p class="text-xs font-semibold text-slate-700 truncate">{{ $naskah->reviewer->name }}</p>
                                    <p class="text-[10px] text-slate-450 truncate mt-0.5">{{ $naskah->reviewer->afiliasi ?? 'External Reviewer' }}</p>
                                </div>
                            @else
                                <div class="p-3 bg-amber-50/30 border border-amber-100/60 rounded-lg text-amber-800 text-center">
                                    <span class="text-[10px] font-semibold">Belum ditugaskan ke reviewer</span>
                                </div>
                            @endif
                        </div>

                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Editor Ditugaskan</span>
                            @if($naskah->editor_id)
                                <div class="p-3 bg-slate-50/75 border border-slate-200 rounded-lg">
                                    <p class="text-xs font-semibold text-slate-700 truncate">{{ $naskah->editor->name }}</p>
                                    <p class="text-[10px] text-slate-450 truncate mt-0.5">Editor Redaksi</p>
                                </div>
                            @else
                                <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-400 text-center">
                                    <span class="text-[10px]">Belum ditugaskan ke editor</span>
                                </div>
                            @endif
                        </div>
                    </div>
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
                                                    <option value="revisi" {{ $naskah->status === 'revisi' ? 'selected' : '' }}>Butuh Revisi</option>
                                                    <option value="diterima" {{ $naskah->status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                                                    <option value="ditolak" {{ $naskah->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                    <option value="pengajuan_isbn" {{ $naskah->status === 'pengajuan_isbn' ? 'selected' : '' }}>Pengajuan ISBN</option>
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

        {{-- Modal Kirim ke Editor --}}
        <div x-show="showEditorModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="showEditorModal" x-transition.opacity class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showEditorModal" x-transition.opacity @click.away="showEditorModal = false"
                        class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <form action="{{ route('admin.naskah.assignEditor', $naskah->id) }}" method="POST">
                            @csrf
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-semibold text-slate-900" id="modal-title">Kirim Naskah ke Editor</h3>
                                        <div class="mt-4 space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Editor</label>
                                                <select name="editor_id" class="block w-full border border-slate-200 rounded-lg text-sm py-2 px-3 focus:ring-emerald-500 focus:border-emerald-500" required>
                                                    <option disabled selected>-- Pilih Editor --</option>
                                                    @foreach($editors as $editor)
                                                        <option value="{{ $editor->id }}" {{ $naskah->editor_id === $editor->id ? 'selected' : '' }}>
                                                            {{ $editor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-1">Catatan/Instruksi untuk Editor (Opsional)</label>
                                                <textarea name="note" rows="4" class="block w-full border border-slate-200 rounded-lg text-sm p-3 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Tulis instruksi khusus untuk editor di sini..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                                <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-teal-700 sm:ml-3 sm:w-auto">Kirim Sekarang</button>
                                <button type="button" @click="showEditorModal = false" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection