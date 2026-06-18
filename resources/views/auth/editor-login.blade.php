@extends('layouts.auth')

@section('title', 'Login Editor - Penerbitan UPNVJ')
@section('subtitle', 'Portal Editor')

@section('content')
<form class="mt-8 space-y-6" action="{{ route('editor.login') }}" method="POST">
    @csrf

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-sm text-rose-600 p-4 rounded-md">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="rounded-md space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email Editor</label>
            <input id="email" name="email" type="email" required class="appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-teal-600 focus:border-teal-600 focus:z-10 sm:text-sm mt-1" placeholder="editor@upnvj.ac.id" value="{{ old('email') }}">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <input id="password" name="password" type="password" required class="appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-teal-600 focus:border-teal-600 focus:z-10 sm:text-sm mt-1" placeholder="Password">
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-teal-700 focus:ring-teal-600 border-slate-300 rounded">
            <label for="remember-me" class="ml-2 block text-sm text-slate-900">
                Ingatkan saya
            </label>
        </div>
    </div>

    <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-teal-700 hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-600 transition-colors active:scale-[0.99]">
            Masuk sebagai Editor
        </button>
    </div>

    <div class="mt-4 text-center text-sm text-slate-500 font-bold">
        LPPM Press
    </div>
</form>
@endsection
