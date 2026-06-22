@extends('layouts.author')

@section('page_title', 'Detail Naskah')

@section('content')
<div class="mb-6">
    <a href="{{ route('author.naskah.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke halaman Naskah
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <x-card>
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $naskah->title }}</h2>
                    <p class="text-slate-500 mt-1">Diajukan oleh {{ $naskah->user->name }}</p>
                </div>
                <x-badge status="{{ $naskah->status_label }}" />
            </div>
            
            <div class="space-y-5 border-t border-slate-100 pt-5">
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kategori & Paket</h4>
                    <p class="text-slate-900 text-sm font-medium">
                        Kategori: <span class="text-emerald-700 font-semibold">{{ $naskah->category->nama_kategori ?? '-' }}</span> | 
                        Paket: <span class="text-emerald-700 font-semibold">{{ $naskah->package->nama_paket ?? '-' }}</span>
                    </p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Daftar Penulis</h4>
                    <p class="text-slate-900 text-sm leading-relaxed">
                        <strong class="font-semibold">{{ $naskah->user->name }}</strong> (Penulis Utama)
                        @if(!empty($naskah->co_author))
                            @foreach($naskah->co_author as $co)
                                <br>
                                <span class="text-slate-600">— {{ $co['name'] ?? '-' }} ({{ $co['affiliation'] ?? '-' }}) <span class="text-slate-400">&lt;{{ $co['email'] ?? '-' }}&gt;</span></span>
                            @endforeach
                        @endif
                    </p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Abstrak / Sinopsis</h4>
                    <p class="text-slate-700 leading-relaxed text-sm whitespace-pre-line">{{ $naskah->description }}</p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">File Terkirim</h4>
                    @if($naskah->document_path)
                        <a href="{{ asset('storage/' . $naskah->document_path) }}" target="_blank" class="mt-2 inline-flex items-center px-4 py-2 border border-slate-200 shadow-sm rounded-lg text-sm text-slate-700 bg-white hover:bg-slate-50 hover:text-emerald-700 transition-colors">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            {{ $naskah->document_name ?? basename($naskah->document_path) }}
                        </a>
                        @if($naskah->document_size)
                            <p class="text-xs text-slate-500 mt-2">Ukuran file: {{ $naskah->document_size }}</p>
                        @endif
                    @else
                        <p class="text-sm text-slate-500 mt-1">File tidak tersedia.</p>
                    @endif
                </div>
            </div>
        </x-card>
    </div>

    <div class="lg:col-span-1">
        <x-card class="bg-slate-50/50">
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-slate-900">Kronologi</h3>
            </x-slot>
            <div class="relative mt-2">
                <div class="absolute top-2 bottom-2 left-[11px] w-px bg-slate-200"></div>
                
                @if($naskah->status !== 'diajukan')
                    <div class="flex gap-4 mb-6 relative">
                        <div class="w-6 h-6 rounded-full bg-blue-500 ring-4 ring-white flex-shrink-0 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ $naskah->status_label }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $naskah->updated_at->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                @endif

                <div class="flex gap-4 relative">
                    <div class="w-6 h-6 rounded-full bg-emerald-500 ring-4 ring-white flex-shrink-0 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-900">Berhasil Diajukan</p>
                        @php $date = $naskah->submitted_at ?? $naskah->created_at; @endphp
                        <p class="text-xs text-slate-500 mt-1">{{ $date ? $date->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection
