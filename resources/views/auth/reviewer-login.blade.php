@extends('layouts.auth')

@section('title', 'Login Reviewer - Penerbitan UPNVJ')
@section('subtitle', 'Portal Reviewer ')

@section('content')
<form class="mt-8 space-y-6" action="{{ route('reviewer.login') }}" method="POST">
    @csrf
    
    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-sm text-rose-600 p-4 rounded-md">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="rounded-md space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email Reviewer</label>
            <input id="email" name="email" type="email" required class="appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-1" placeholder="reviewer@upnvj.ac.id" value="{{ old('email') }}">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <input id="password" name="password" type="password" required class="appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-1" placeholder="Password">
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
            <label for="remember-me" class="ml-2 block text-sm text-slate-900">
                Ingat sesi ini
            </label>
        </div>
    </div>

    <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            Masuk sebagai Reviewer
        </button>
    </div>
    
    <div class="mt-4 text-center">
        <a href="/auth/login" class="text-sm font-medium text-slate-500 hover:text-slate-700">Dosen / Penulis? <span class="text-emerald-600">Login disini</span></a>
    </div>
</form>
@endsection