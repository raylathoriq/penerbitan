@extends('layouts.public')

@section('content')
<div class="bg-white">
    <!-- Hero section -->
    <div class="relative bg-slate-50 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-slate-50 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-10 px-4 sm:px-6">
                <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Sistem Penerbitan</span>
                            <span class="block text-green-700 xl:inline">Buku UPNVJ</span>
                        </h1>
                        <p class="mt-3 text-base text-slate-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Fasilitas layanan penerbitan karya buku akademik bagi civitas akademika UPN "Veteran" Jakarta dan penulis eksternal dengan proses terintegrasi Google Scholar.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="/auth/login" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-700 hover:bg-green-800 md:py-4 md:text-lg md:px-10">
                                    Mulai Terbitkan
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="/katalog" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 md:py-4 md:text-lg md:px-10">
                                    Lihat Katalog
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Katalog Buku Terbit</h1>
    <div class="text-right">
        <a href="/katalog" class="text-green-600 font-medium text-right mb-8 inline-block">Lihat semua</a>
    </div>
    
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
</div>
@endsection