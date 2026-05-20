@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Katalog Buku Terbit</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @for($i = 1; $i <= 4; $i++)
        <x-card>
            <div class="h-48 bg-slate-200 mb-4 rounded-md flex items-center justify-center text-slate-400 overflow-hidden">
                <img src="{{ asset('img/buku.jpg') }}" alt="Sampul Buku {{ $i }}" class="w-full h-full object-cover">
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-1">Judul Buku {{ $i }}</h3>
            <p class="text-sm text-slate-500 mb-2">Penulis</p>
            <p class="text-xs text-slate-400 mb-4">ISBN: 978-000-000-00-{{ $i }}</p>
            <a href="/buku/{{ $i }}" class="text-green-600 hover:text-green-800 text-sm font-medium">Baca Selengkapnya </a>
        </x-card>
        @endfor
    </div>
</div>
@endsection