@extends('layouts.author')

@section('page_title', 'Dashboard Author')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <x-card class="border-l-4 border-l-slate-400">
        <div class="text-slate-500 text-sm font-medium tracking-wide">Total Naskah Diajukan</div>
        <div class="text-4xl font-bold text-slate-900 mt-3 tracking-tight">{{ $total ?? 0 }}</div>
    </x-card>
    <x-card class="border-l-4 border-l-amber-400">
        <div class="text-amber-700 text-sm font-medium tracking-wide">Proses Review</div>
        <div class="text-4xl font-bold text-amber-900 mt-3 tracking-tight">{{ $inReview ?? 0 }}</div>
    </x-card>
    <x-card class="border-l-4 border-l-emerald-400">
        <div class="text-emerald-600 text-sm font-medium tracking-wide">Selesai/Terbit</div>
        <div class="text-4xl font-bold text-emerald-900 mt-3 tracking-tight">{{ $published ?? 0 }}</div>
    </x-card>
</div>

<x-card>
    <x-slot name="header">
        <h3 class="text-lg font-semibold text-slate-900">Log Aktivitas Anda</h3>
    </x-slot>
        <div class="space-y-6">
            @forelse($recent ?? [] as $item)
                <div class="flex gap-4">
                    <div class="relative mt-1">
                        <div class="absolute top-0 bottom-0 left-1.5 w-px bg-slate-200"></div>
                        <div class="relative w-3 h-3 bg-amber-500 rounded-full ring-4 ring-white"></div>
                    </div>
                    <div class="flex-1 pb-2">
                        <p class="text-sm font-medium text-slate-900">Naskah "{{ $item->title }}" diubah menjadi <span class="text-amber-600">{{ $item->status_label }}</span></p>
                        <p class="text-xs text-slate-400 mt-1.5">{{ $item->submitted_at ? $item->submitted_at->copy()->setTimezone('Asia/Jakarta')->locale('id')->diffForHumans() : '—' }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada aktivitas.</p>
            @endforelse
        </div>
</x-card>
@endsection