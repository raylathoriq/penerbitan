@extends('layouts.auth')

@section('title', 'Register Author Eksternal - LPPM UPNVJ')

@section('content')
<form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
    @csrf
    <div class="rounded-md space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">Nama Lengkap (dengan Gelar)</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-1 appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
        </div>
        
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email Utama</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-1 appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
        </div>

        <div>
            <label for="afiliasi" class="block text-sm font-medium text-slate-700">Afiliasi/Institusi</label>
            <input id="afiliasi" name="afiliasi" type="text" value="{{ old('afiliasi') }}" required class="mt-1 appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Contoh: Universitas Indonesia">
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <input id="password" name="password" type="password" required class="mt-1 appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
        </div>
    </div>

    <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Daftar Sekarang
        </button>
    </div>
</form>

<div class="mt-6 text-center text-sm text-slate-600">
    <p>Sudah punya akun? <a href="/auth/login" class="font-medium text-green-600 hover:text-green-500">Masuk di sini</a></p>
</div>
@endsection