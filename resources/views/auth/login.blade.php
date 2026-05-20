@extends('layouts.auth')

@section('title', 'Login - LPPM UPNVJ Press')

@section('content')
<form class="mt-8 space-y-6" action="#" method="POST" onsubmit="event.preventDefault(); window.location.href='/admin/dashboard';">
    <div class="rounded-md shadow-sm space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email Address / SSO ID</label>
            <input id="email" name="email" type="email" required class="appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm mt-1" placeholder="Email Anda">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <input id="password" name="password" type="password" required class="appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm mt-1" placeholder="Password">
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-slate-300 rounded">
            <label for="remember-me" class="ml-2 block text-sm text-slate-900">
                Ingatkan saya
            </label>
        </div>

        <div class="text-sm">
            <a href="#" class="font-medium text-green-600 hover:text-green-500">
                Lupa password?
            </a>
        </div>
    </div>

    <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Masuk
        </button>
    </div>
    
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-slate-500">
                    Atau masuk sebagai
                </span>
            </div>
        </div>

        <div class="mt-6">
            <button type="button" onclick="window.location.href='/author/dashboard';" class="w-full flex justify-center py-2 px-4 border border-slate-300 rounded-md shadow-sm bg-white text-sm font-medium text-slate-700 hover:bg-slate-50">
                Author (Eksternal)
            </button>
        </div>
    </div>
</form>

<div class="mt-6 text-center text-sm text-slate-600">
    <p>Belum punya akun? <a href="/auth/register" class="font-medium text-green-600 hover:text-green-500">Daftar sekarang</a></p>
</div>
@endsection