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
                                <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? '/admin/dashboard' : '/author/dashboard') : '/auth/login' }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-700 hover:bg-green-800 md:py-4 md:text-lg md:px-10">
                                    {{ auth()->check() ? 'Buka Dashboard' : 'Mulai Terbitkan' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
@endsection