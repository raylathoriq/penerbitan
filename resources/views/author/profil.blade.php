@extends('layouts.author')

@section('page_title', 'Profil Author')

@section('content')
<div class="max-w-3xl mx-auto">
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Pribadi</h3>
        </x-slot>
        <form action="#">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" value="{{ Auth::user()->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border sm:text-sm" disabled>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border sm:text-sm" disabled>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Afiliasi / Institusi</label>
                    <input type="text" value="{{ Auth::user()->afiliasi ?? '-' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border sm:text-sm" disabled>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis User</label>
                    <input type="text" value="{{ ucfirst(Auth::user()->role) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border bg-gray-50 text-gray-500 sm:text-sm" disabled>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection