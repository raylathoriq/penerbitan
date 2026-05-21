@extends('layouts.auth')

@section('title', 'Admin Login - LPPM UPNVJ Press')
@section('subtitle', 'Workspace Management (Admin)')

@section('content')
<form class="mt-8 space-y-6" action="{{ url('/admin/login') }}" method="POST">
    @csrf
    <div class="rounded-md space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Institutional Email</label>
            <input id="email" name="email" type="email" required class="appearance-none relative block w-full px-3 py-2 border border-slate-300 placeholder-slate-500 text-slate-900 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm mt-1" placeholder="admin.@upnvj.ac.id">
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
    </div>

    <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
            Login
        </button>
    </div>
    
</form>
@endsection