@extends('layouts.admin')

@section('page_title', 'Manajemen User')

@section('content')
<x-card>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-slate-800">Daftar Pengguna</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @for($i = 1; $i <= 5; $i++)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $i }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-slate-900">Author  {{ $i }}</div>
                        <div class="text-sm text-slate-500">{{ $i % 2 == 0 ? 'Internal (Dosen)' : 'Eksternal' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">author{{ $i }}@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                        {{ $i == 1 ? 'Admin' : 'Author' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</x-card>
@endsection