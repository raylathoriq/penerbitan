@extends('layouts.author')

@section('page_title', 'Dashboard Author')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <!-- Card Total Diajukan -->
    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
        <div class="flex justify-between items-start">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 tracking-wider uppercase">Total Diajukan</span>
                <p class="text-xs text-slate-400 leading-snug">Total naskah yang diajukan</p>
            </div>
            <div class="text-slate-400 flex items-center justify-center">
                <i class="bi bi-journal-text text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-baseline gap-1.5">
            <span class="text-3xl font-bold text-slate-800 tracking-tight">{{ $total }}</span>
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
            <span class="text-3xl font-bold text-rose-600 tracking-tight">{{ $rejected }}</span>
            <span class="text-[11px] font-medium text-rose-400">Naskah</span>
        </div>
    </div>
    
    <!-- Card Review -->
    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
        <div class="flex justify-between items-start">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-amber-600 tracking-wider uppercase">Proses Review</span>
                <p class="text-xs text-slate-400 leading-snug">Tahap penilaian reviewer</p>
            </div>
            <div class="text-amber-500 flex items-center justify-center">
                <i class="bi bi-eye text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-baseline gap-1.5">
            <span class="text-3xl font-bold text-amber-600 tracking-tight">{{ $inReview }}</span>
            <span class="text-[11px] font-medium text-amber-600">Naskah</span>
        </div>
    </div>
    
    <!-- Card Editing -->
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
            <span class="text-3xl font-bold text-sky-600 tracking-tight">{{ $editing }}</span>
            <span class="text-[11px] font-medium text-sky-600">Naskah</span>
        </div>
    </div>

    <!-- Card Selesai -->
    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
        <div class="flex justify-between items-start">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-emerald-600 tracking-wider uppercase">Selesai / Terbit</span>
                <p class="text-xs text-slate-400 leading-snug">Siap dipublikasikan</p>
            </div>
            <div class="text-emerald-500 flex items-center justify-center">
                <i class="bi bi-check-circle text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-baseline gap-1.5">
            <span class="text-3xl font-bold text-emerald-600 tracking-tight">{{ $completed }}</span>
            <span class="text-[11px] font-medium text-emerald-400">Naskah</span>
        </div>
    </div>
</div>

<x-card>
    <x-slot name="header">
        <h3 class="text-lg font-semibold text-slate-900">Log Aktivitas Anda</h3>
    </x-slot>
    <div class="space-y-6">
        @forelse($recent as $item)
            <div class="flex gap-4">
                <div class="relative mt-1">
                    @if(!$loop->last)
                        <div class="absolute top-3 bottom-0 left-1.5 w-px bg-slate-200"></div>
                    @endif
                    @if($item->status === 'diajukan')
                        <div class="relative w-3 h-3 bg-blue-500 rounded-full ring-4 ring-white"></div>
                    @elseif($item->status === 'dalam review' || $item->status === 'revisi')
                        <div class="relative w-3 h-3 bg-amber-500 rounded-full ring-4 ring-white"></div>
                    @elseif($item->status === 'diterima')
                        <div class="relative w-3 h-3 bg-emerald-500 rounded-full ring-4 ring-white"></div>
                    @else
                        <div class="relative w-3 h-3 bg-slate-500 rounded-full ring-4 ring-white"></div>
                    @endif
                </div>
                <div class="flex-1 pb-2">
                    <p class="text-sm text-slate-700">
                        Naskah <span class="font-semibold text-slate-900">"{{ $item->title }}"</span> saat ini berstatus 
                        <span class="
                            @if($item->status === 'diajukan') text-blue-600
                            @elseif($item->status === 'dalam review' || $item->status === 'revisi') text-amber-600
                            @elseif($item->status === 'diterima') text-emerald-600
                            @else text-slate-600
                            @endif
                            font-semibold
                        ">{{ $item->status_label }}</span>
                    </p>
                    <p class="text-xs text-slate-400 mt-1.5">{{ $item->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-500 text-center py-4">Belum ada aktivitas terekam.</p>
        @endforelse
    </div>
</x-card>
@endsection