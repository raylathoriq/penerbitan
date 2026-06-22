@extends('layouts.author')

@section('page_title', 'Dashboard Author')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <x-card class="border-l-4 border-l-slate-400">
        <div class="text-slate-500 text-sm font-medium tracking-wide">Total Naskah Diajukan</div>
        <div class="text-4xl font-bold text-slate-900 mt-3 tracking-tight">{{ $totalSubmissions }}</div>
    </x-card>
    <x-card class="border-l-4 border-l-amber-400">
        <div class="text-amber-700 text-sm font-medium tracking-wide">Proses Review</div>
        <div class="text-4xl font-bold text-amber-900 mt-3 tracking-tight">{{ $inReview }}</div>
    </x-card>
    <x-card class="border-l-4 border-l-emerald-400">
        <div class="text-emerald-600 text-sm font-medium tracking-wide">Selesai/Terbit</div>
        <div class="text-4xl font-bold text-emerald-900 mt-3 tracking-tight">{{ $published }}</div>
    </x-card>
</div>

<x-card>
    <x-slot name="header">
        <h3 class="text-lg font-semibold text-slate-900">Log Aktivitas Anda</h3>
    </x-slot>
    <div class="space-y-6">
        @forelse($activities as $activity)
            <div class="flex gap-4">
                <div class="relative mt-1">
                    @if(!$loop->last)
                        <div class="absolute top-3 bottom-0 left-1.5 w-px bg-slate-200"></div>
                    @endif
                    @if($activity->status === 'Diajukan')
                        <div class="relative w-3 h-3 bg-blue-500 rounded-full ring-4 ring-white"></div>
                    @elseif($activity->status === 'Dalam Review' || $activity->status === 'Revisi')
                        <div class="relative w-3 h-3 bg-amber-500 rounded-full ring-4 ring-white"></div>
                    @elseif($activity->status === 'Terbit')
                        <div class="relative w-3 h-3 bg-emerald-500 rounded-full ring-4 ring-white"></div>
                    @else
                        <div class="relative w-3 h-3 bg-slate-500 rounded-full ring-4 ring-white"></div>
                    @endif
                </div>
                <div class="flex-1 pb-2">
                    <p class="text-sm text-slate-700">
                        Naskah <span class="font-semibold text-slate-900">"{{ $activity->title }}"</span> saat ini berstatus 
                        <span class="
                            @if($activity->status === 'Diajukan') text-blue-600
                            @elseif($activity->status === 'Dalam Review' || $activity->status === 'Revisi') text-amber-600
                            @elseif($activity->status === 'Terbit') text-emerald-600
                            @else text-slate-600
                            @endif
                            font-semibold
                        ">{{ $activity->status }}</span>
                    </p>
                    <p class="text-xs text-slate-400 mt-1.5">{{ $activity->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-500 text-center py-4">Belum ada aktivitas terekam.</p>
        @endforelse
    </div>
</x-card>
@endsection