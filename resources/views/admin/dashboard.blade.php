@extends('layouts.admin')

@section('page_title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <!-- Card Naskah Masuk -->
    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
        <div class="flex justify-between items-start">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 tracking-wider uppercase">Naskah Masuk</span>
                <p class="text-xs text-slate-400 leading-snug">Total usulan masuk</p>
            </div>
            <div class="text-slate-400 flex items-center justify-center">
                <i class="bi bi-journal-text text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-baseline gap-1.5">
            <span class="text-3xl font-bold text-slate-800 tracking-tight">{{ $total ?? 0 }}</span>
            <span class="text-[11px] font-medium text-slate-400">Naskah</span>
        </div>
    </div>

    <!-- Card Ditolak -->
    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
        <div class="flex justify-between items-start">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-rose-500 tracking-wider uppercase">Ditolak</span>
                <p class="text-xs text-slate-400 leading-snug">Tidak lolos kriteria</p>
            </div>
            <div class="text-rose-400 flex items-center justify-center">
                <i class="bi bi-x-circle text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-baseline gap-1.5">
            <span class="text-3xl font-bold text-rose-600 tracking-tight">{{ $rejected ?? 0 }}</span>
            <span class="text-[11px] font-medium text-rose-400">Naskah</span>
        </div>
    </div>

    <!-- Card Dalam Review -->
    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
        <div class="flex justify-between items-start">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-amber-600 tracking-wider uppercase">Dalam Review</span>
                <p class="text-xs text-slate-400 leading-snug">Sedang dinilai reviewer</p>
            </div>
            <div class="text-amber-500 flex items-center justify-center">
                <i class="bi bi-eye text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-baseline gap-1.5">
            <span class="text-3xl font-bold text-amber-600 tracking-tight">{{ $inReview ?? 0 }}</span>
            <span class="text-[11px] font-medium text-amber-600">Naskah</span>
        </div>
    </div>

    <!-- Card Proses Editing -->
    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
        <div class="flex justify-between items-start">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-sky-600 tracking-wider uppercase">Proses Editing</span>
                <p class="text-xs text-slate-400 leading-snug">Penyuntingan draf</p>
            </div>
            <div class="text-sky-500 flex items-center justify-center">
                <i class="bi bi-pencil-square text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-baseline gap-1.5">
            <span class="text-3xl font-bold text-sky-600 tracking-tight">{{ $editing ?? 0 }}</span>
            <span class="text-[11px] font-medium text-sky-600">Naskah</span>
        </div>
    </div>

    <!-- Card Diterima -->
    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
        <div class="flex justify-between items-start">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-emerald-600 tracking-wider uppercase">Diterima</span>
                <p class="text-xs text-slate-400 leading-snug">Siap dipublikasikan</p>
            </div>
            <div class="text-emerald-500 flex items-center justify-center">
                <i class="bi bi-check-circle text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-baseline gap-1.5">
            <span class="text-3xl font-bold text-emerald-600 tracking-tight">{{ $published ?? 0 }}</span>
            <span class="text-[11px] font-medium text-emerald-400">Naskah</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-slate-900">Aktivitas Terbaru</h3>
            </x-slot>
            <div class="space-y-6">
                @forelse($recent ?? [] as $item)
                    <div class="flex gap-4">
                        <div class="relative mt-1">
                            <div class="absolute top-0 bottom-0 left-1.5 w-px bg-slate-200"></div>
                            <div class="relative w-3 h-3 bg-blue-500 rounded-full ring-4 ring-white"></div>
                        </div>
                        <div class="flex-1 pb-2">
                            <p class="text-sm font-medium text-slate-900">Pengajuan Naskah Baru: "{{ $item->title }}"</p>
                            <p class="text-sm text-slate-500 mt-0.5">Oleh {{ $item->author_name }}</p>
                            <p class="text-xs text-slate-400 mt-1.5">{{ $item->submitted_at ? $item->submitted_at->copy()->setTimezone('Asia/Jakarta')->locale('id')->diffForHumans() : '—' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada aktivitas terbaru.</p>
                @endforelse
            </div>
        </x-card>
    </div>
</div>
@endsection