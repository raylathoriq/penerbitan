@extends('layouts.admin')

@section('page_title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <x-card class="border-l-4 border-l-slate-400">
        <div class="text-slate-500 text-sm font-medium tracking-wide">Naskah Masuk</div>
        <div class="text-4xl font-bold text-slate-900 mt-3 tracking-tight">12</div>
    </x-card>
    <x-card class="border-l-4 border-l-blue-400">
        <div class="text-blue-600 text-sm font-medium tracking-wide">Dalam Review</div>
        <div class="text-4xl font-bold text-blue-900 mt-3 tracking-tight">5</div>
    </x-card>
    <x-card class="border-l-4 border-l-emerald-400">
        <div class="text-emerald-600 text-sm font-medium tracking-wide">Telah Terbit</div>
        <div class="text-4xl font-bold text-emerald-900 mt-3 tracking-tight">34</div>
    </x-card>
    <x-card class="border-l-4 border-l-rose-400">
        <div class="text-rose-600 text-sm font-medium tracking-wide">Ditolak</div>
        <div class="text-4xl font-bold text-rose-900 mt-3 tracking-tight">2</div>
    </x-card>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-slate-900">Aktivitas Terbaru</h3>
            </x-slot>
            <div class="space-y-6">
                {{-- Activity Item --}}
                <div class="flex gap-4">
                    <div class="relative mt-1">
                        <div class="absolute top-0 bottom-0 left-1.5 w-px bg-slate-200"></div>
                        <div class="relative w-3 h-3 bg-blue-500 rounded-full ring-4 ring-white"></div>
                    </div>
                    <div class="flex-1 pb-2">
                        <p class="text-sm font-medium text-slate-900">Pengajuan Naskah Baru: "Dasar Logika"</p>
                        <p class="text-sm text-slate-500 mt-0.5">Oleh Dr. Budi Santoso</p>
                        <p class="text-xs text-slate-400 mt-1.5">10 Menit lalu</p>
                    </div>
                </div>
                {{-- Activity Item --}}
                <div class="flex gap-4">
                    <div class="relative mt-1">
                        <div class="absolute top-0 bottom-0 left-1.5 w-px bg-slate-200"></div>
                        <div class="relative w-3 h-3 bg-emerald-500 rounded-full ring-4 ring-white"></div>
                    </div>
                    <div class="flex-1 pb-2">
                        <p class="text-sm font-medium text-slate-900">Naskah "Kalkulus Lanjut" Berhasil Terbit</p>
                        <p class="text-sm text-slate-500 mt-0.5">ISBN Generated: 978-602-000-0-1</p>
                        <p class="text-xs text-slate-400 mt-1.5">1 Jam lalu</p>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection