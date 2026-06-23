@extends('layouts.author')

@section('page_title', 'Perbaikan Naskah')

@section('content')
<div class="mb-6">
    <a href="/author/naskah" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
        Kembali
    </a>
</div>

<div class="max-w-3xl">
    <x-card>
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-5 mb-8">
            <h4 class="text-sm font-bold text-orange-800 flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Catatan Revisi dari Reviewer
            </h4>
            <p class="text-orange-700 text-sm leading-relaxed {{ $naskah->reviewerFile() ? 'mb-3' : '' }}">
                {{ $naskah->reviews->first()->comments ?? 'Harap perbaiki naskah sesuai catatan reviewer.' }}
            </p>
            @php $reviewerFile = $naskah->reviewerFile(); @endphp
            @if($reviewerFile)
                <div class="pt-3 border-t border-orange-200/70 flex items-center">
                    <span class="text-xs text-orange-800 font-semibold mr-2">File Coretan Koreksi:</span>
                    <a href="{{ asset('storage/' . $reviewerFile->file_path) }}" target="_blank" class="inline-flex items-center text-xs font-semibold text-indigo-700 hover:text-indigo-900 bg-white px-2.5 py-1.5 rounded-lg border border-orange-200 shadow-sm transition-colors">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        {{ $reviewerFile->file_name }}
                    </a>
                </div>
            @endif
        </div>

        <form action="{{ route('author.naskah.storeRevisi', $naskah->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jurnal Perbaikan (Opsional)</label>
                    <textarea name="jurnal_revisi" rows="4" class="block w-full border-slate-200 rounded-lg text-sm p-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm border transition-all" placeholder="Jelaskan bagian mana saja yang telah direvisi berdasarkan catatan reviewer..."></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Upload File Naskah Revisi (PDF / Word)</label>
                    <input type="file" name="document_revisi" accept=".pdf,.doc,.docx" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors cursor-pointer" required>
                </div>
                
                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <x-button type="secondary" onclick="window.history.back()">Batal</x-button>
                    <x-button type="primary" typeHtml="submit">Kirim Revisi ke Reviewer</x-button>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection