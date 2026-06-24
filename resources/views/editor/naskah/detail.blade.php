@extends('layouts.editor')

@section('title', 'Penyuntingan Naskah')
@section('page_title', 'Penyuntingan Naskah')

@section('content')
<div class="mb-6">
    <a href="/editor/naskah" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
        Kembali ke Daftar Naskah
    </a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-[0.9fr_1.4fr] gap-8" x-data="{ editingStatus: 'draft', fileName: '', coverFileName: '' }">
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">{{ $naskah->title }}</h2>
                    <p class="text-sm text-slate-500 mt-1">{{ $naskah->user->name ?? '-' }} · {{ $naskah->category->nama_kategori ?? '-' }}</p>
                </div>
                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium 
                    @if($naskah->status === 'perlu_edit') bg-teal-50 text-teal-700 ring-1 ring-teal-600/20
                    @elseif($naskah->status === 'editing') bg-sky-50 text-sky-700 ring-1 ring-sky-600/20
                    @else bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20
                    @endif">
                    {{ $naskah->status_label }}
                </span>
            </div>

            <div class="mt-6 space-y-4">
                <div>
                    <h4 class="text-slate-500 text-xs font-medium">Abstrak / Sinopsis</h4>
                    <p class="text-sm text-slate-700 mt-1 leading-relaxed">{{ $naskah->description ?? 'Tidak ada deskripsi yang tersedia.' }}</p>
                </div>
                <div class="pt-4 border-t border-slate-100">
                    <h4 class="text-slate-500 text-xs font-medium mb-3">Dokumen Penulis Terbaru</h4>
                    @php $authorFile = $naskah->latestAuthorFile(); @endphp
                    @if($authorFile)
                        <a href="{{ asset('storage/' . $authorFile->file_path) }}" target="_blank" class="inline-flex items-center w-full justify-between p-3 border border-slate-200 rounded-lg hover:bg-slate-50 hover:border-slate-300 transition-colors group">
                            <div class="flex items-center min-w-0">
                                <svg class="w-5 h-5 text-teal-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                <span class="text-sm font-medium text-slate-900 truncate">{{ $authorFile->file_name }}</span>
                            </div>
                            <span class="text-xs text-slate-500">
                                @if($authorFile->file_size)
                                    {{ round($authorFile->file_size / 1024, 1) }} KB
                                @endif
                                ({{ $authorFile->jenis_file === 'revisi' ? 'Revisi v' . $authorFile->version : 'Orisinil' }})
                            </span>
                        </a>
                    @else
                        <p class="text-sm text-slate-500">Berkas belum diunggah.</p>
                    @endif
                </div>

                @php $edFile = $naskah->editorFile(); @endphp
                @if($edFile)
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-slate-500 text-xs font-medium mb-3">Dokumen Hasil Suntingan Terakhir</h4>
                        <a href="{{ asset('storage/' . $edFile->file_path) }}" target="_blank" class="inline-flex items-center w-full justify-between p-3 border border-slate-200 rounded-lg hover:bg-slate-50 hover:border-slate-300 transition-colors group bg-teal-50/50">
                            <div class="flex items-center min-w-0">
                                <svg class="w-5 h-5 text-emerald-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="text-sm font-medium text-slate-900 truncate">{{ $edFile->file_name }}</span>
                            </div>
                            <span class="text-xs text-slate-500">
                                v{{ $edFile->version }} (Unduh)
                            </span>
                        </a>
                    </div>
                @endif

                @php $covFile = $naskah->editorCoverFile(); @endphp
                @if($covFile)
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-slate-500 text-xs font-medium mb-3">Cover Naskah Terakhir</h4>
                        <div class="relative rounded-lg overflow-hidden border border-slate-200 bg-slate-50 p-2 max-w-[200px]">
                            <a href="{{ asset('storage/' . $covFile->file_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $covFile->file_path) }}" alt="Cover Naskah" class="w-full h-auto rounded hover:opacity-90 transition-opacity">
                            </a>
                            <div class="mt-2 text-center text-xs text-slate-500 truncate" title="{{ $covFile->file_name }}">{{ $covFile->file_name }}</div>
                        </div>
                    </div>
                @endif

                @php 
                    $assignmentLog = $naskah->editorLogs()
                        ->where('id_user', auth()->id())
                        ->where('decision', 'perlu_edit')
                        ->latest()
                        ->first();
                @endphp
                @if($assignmentLog && $assignmentLog->comments)
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-slate-500 text-xs font-medium mb-2">Instruksi Khusus dari Redaksi</h4>
                        <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3 text-sm text-indigo-800">
                            "{{ $assignmentLog->comments }}"
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-sm font-semibold text-slate-900 mb-4 uppercase tracking-wider">Acuan Penyuntingan (Evaluasi Reviewer)</h3>
            <div class="space-y-4">
                @php 
                    $reviews = $naskah->reviews()
                        ->whereHas('reviewer', function($q) { 
                            $q->where('role', 'reviewer'); 
                        })
                        ->get(); 
                @endphp
                @forelse($reviews as $rev)
                    <div class="p-4 rounded-lg border 
                        @if($rev->decision === 'diterima') border-emerald-100 bg-emerald-50/50
                        @elseif($rev->decision === 'revisi') border-amber-100 bg-amber-50/50
                        @else border-rose-100 bg-rose-50/50
                        @endif">
                        <div class="flex items-center justify-between gap-3">
                            <div class="text-sm font-semibold text-slate-900">{{ $rev->reviewer->name ?? 'Reviewer' }}</div>
                            <span class="text-xs font-medium 
                                @if($rev->decision === 'diterima') text-emerald-700
                                @elseif($rev->decision === 'revisi') text-amber-700
                                @else text-rose-700
                                @endif">
                                {{ $rev->decision ? ucfirst($rev->decision) : 'Catatan reviewer' }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mt-2 leading-relaxed">{{ $rev->comments ?? 'Tidak ada komentar tertulis.' }}</p>
                        
                        @php $coretanFile = $naskah->files()->where('jenis_file', 'reviewer_coretan')->first(); @endphp
                        @if($coretanFile)
                            <div class="mt-3 text-xs flex items-center">
                                <span class="text-slate-400 mr-2">File Koreksi:</span>
                                <a href="{{ asset('storage/' . $coretanFile->file_path) }}" target="_blank" class="font-medium text-teal-700 hover:text-teal-800 transition-colors inline-flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                    {{ $coretanFile->file_name }}
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-slate-500 italic">Belum ada evaluasi reviewer formal yang tersedia.</p>
                @endforelse
            </div>
        </div>

        {{-- Riwayat Penyuntingan Editor --}}
        @if($naskah->editorLogs->isNotEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-semibold text-slate-900 mb-4 uppercase tracking-wider">Riwayat Catatan Editor</h3>
                <div class="space-y-4">
                    @foreach($naskah->editorLogs as $log)
                        <div class="p-4 rounded-lg border border-slate-200 bg-slate-50/50">
                            <div class="flex items-center justify-between gap-3 text-xs text-slate-400 mb-2">
                                <span class="font-semibold text-slate-700 text-sm">{{ $log->editor->name ?? '-' }}</span>
                                <span>{{ $log->tanggal_edit->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y H:i') }} WIB</span>
                            </div>
                            <p class="text-sm text-slate-600 mt-1 leading-relaxed">{{ $log->comments }}</p>
                            <div class="mt-2 text-xs">
                                <span class="text-slate-400">Keputusan: </span>
                                <span class="font-semibold text-teal-700">
                                    {{ [
                                        'perlu_edit' => 'Ditugaskan ke Editor',
                                        'draft' => 'Draft Disimpan',
                                        'perlu_cek' => 'Perlu Cek Author',
                                        'siap_dikirim' => 'Siap Dikirim',
                                    ][$log->decision] ?? $log->decision }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-1">Form Hasil Penyuntingan</h3>
        <p class="text-sm text-slate-500 mb-6">Unggah naskah yang sudah dibenarkan dan kirimkan catatan hasil edit kepada author.</p>

        @if ($errors->any())
            <div class="mb-5 p-4 bg-rose-50 border border-rose-200 rounded-lg text-sm text-rose-600">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('editor.naskah.submitEdit', $naskah->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status Penyuntingan <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <label class="relative flex cursor-pointer rounded-lg border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:bg-slate-50">
                        <input type="radio" name="editing_status" value="draft" x-model="editingStatus" class="peer sr-only">
                        <span class="peer-checked:border-sky-500 peer-checked:ring-1 peer-checked:ring-sky-500 absolute inset-0 rounded-lg border-2 border-transparent pointer-events-none" aria-hidden="true"></span>
                        <div class="flex flex-col text-sm text-center w-full">
                            <span class="font-semibold text-slate-900">Simpan Draft</span>
                            <span class="text-slate-500 mt-1">Edit belum final.</span>
                        </div>
                    </label>
                    <label class="relative flex cursor-pointer rounded-lg border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:bg-slate-50">
                        <input type="radio" name="editing_status" value="perlu_cek" x-model="editingStatus" class="peer sr-only">
                        <span class="peer-checked:border-amber-500 peer-checked:ring-1 peer-checked:ring-amber-500 absolute inset-0 rounded-lg border-2 border-transparent pointer-events-none" aria-hidden="true"></span>
                        <div class="flex flex-col text-sm text-center w-full">
                            <span class="font-semibold text-slate-900">Perlu Cek Author</span>
                            <span class="text-slate-500 mt-1">Ada bagian perlu konfirmasi.</span>
                        </div>
                    </label>
                    <label class="relative flex cursor-pointer rounded-lg border border-slate-200 bg-white p-4 shadow-sm focus:outline-none hover:bg-slate-50">
                        <input type="radio" name="editing_status" value="siap_dikirim" x-model="editingStatus" class="peer sr-only">
                        <span class="peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 absolute inset-0 rounded-lg border-2 border-transparent pointer-events-none" aria-hidden="true"></span>
                        <div class="flex flex-col text-sm text-center w-full">
                            <span class="font-semibold text-slate-900">Siap Dikirim</span>
                            <span class="text-slate-500 mt-1">File sudah dibenarkan.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Upload Naskah Hasil Edit</label>
                <p class="text-xs text-slate-500 mb-2">Unggah file naskah yang sudah dirapikan oleh editor dalam format PDF, DOC, atau DOCX. (Maks. 10MB)</p>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M7 33V13a4 4 0 014-4h13l10 10v14a4 4 0 01-4 4H11a4 4 0 01-4-4zM24 9v10h10M16 29h16M16 23h5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-slate-600 justify-center mt-2">
                            <label for="edited-file" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-700 hover:text-teal-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-600">
                                <span x-text="fileName ? 'Ganti file: ' + fileName : 'Pilih file hasil edit'">Pilih file hasil edit</span>
                                <input id="edited-file" name="edited_file" type="file" class="sr-only" accept=".pdf,.doc,.docx" @change="fileName = $event.target.files[0]?.name || ''">
                            </label>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">PDF, DOC, DOCX up to 10MB</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Upload Cover Naskah (Opsional)</label>
                <p class="text-xs text-slate-500 mb-2">Unggah gambar sampul naskah dalam format JPEG, JPG, atau PNG. (Maks. 5MB)</p>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div class="flex text-sm text-slate-600 justify-center mt-2">
                            <label for="cover-file" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-700 hover:text-teal-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-600">
                                <span x-text="coverFileName ? 'Ganti cover: ' + coverFileName : 'Pilih file cover'">Pilih file cover</span>
                                <input id="cover-file" name="cover_file" type="file" class="sr-only" accept=".jpeg,.jpg,.png" @change="coverFileName = $event.target.files[0]?.name || ''">
                            </label>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">JPEG, JPG, PNG up to 5MB</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Hasil Edit <span class="text-rose-500">*</span></label>
                <p class="text-xs text-slate-500 mb-3">Jelaskan perbaikan tata bahasa/format yang telah dilakukan atau konfirmasi revisi yang diperlukan.</p>
                <textarea name="editor_notes" rows="6" required class="block w-full border border-slate-200 rounded-lg text-sm p-3 focus:ring-teal-600 focus:border-teal-600 shadow-sm" placeholder="Contoh:&#10;1. Mengoreksi kesalahan pengetikan (typo) di bab 1 dan 2.&#10;2. Menyelaraskan format penulisan tabel.&#10;3. Menambahkan daftar isi dan daftar pustaka."></textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-teal-700 hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-600 transition-colors active:scale-[0.98]">
                    Simpan & Kirim
                </button>
            </div>
        </form>
    </div>
</div>>
@endsection
