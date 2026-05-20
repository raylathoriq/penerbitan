@extends('layouts.admin')

@section('page_title', 'Manajemen Naskah')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex-1 max-w-md relative">
        <input type="text" placeholder="Cari judul naskah atau author..." class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm shadow-sm placeholder-slate-400 transition-all">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <select class="block w-full py-2.5 pl-3 pr-10 border border-slate-200 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm text-slate-600 transition-all bg-white">
            <option>Semua Status</option>
            <option>Diajukan</option>
            <option>Dalam Review</option>
            <option>Revisi</option>
        </select>
    </div>
</div>

<x-card class="!p-0">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead>
                <tr class="bg-slate-50/75">
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-widest">Judul Naskah</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-widest">Author</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-widest">Status</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-slate-900 w-1/3">
                        <div class="truncate max-w-md" title="Dasar Logika Matematika">Dasar Logika Matematika</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">Dr. Budi</td>
                    <td class="px-6 py-4 whitespace-nowrap"><x-badge status="Diajukan" /></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="/admin/naskah/1" class="text-emerald-600 hover:text-emerald-800 transition-colors">Review</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-card>
@endsection