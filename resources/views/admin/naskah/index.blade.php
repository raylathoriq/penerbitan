@extends('layouts.admin')

@section('page_title', 'Manajemen Naskah')

@section('content')
<form action="{{ route('admin.naskah.index') }}" method="GET" class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex-1 max-w-md relative">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul naskah atau author..." class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm shadow-sm placeholder-slate-400 transition-all focus:outline-none">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <select name="status" onchange="this.form.submit()" class="block w-full py-2.5 pl-3 pr-10 border border-slate-200 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm text-slate-600 transition-all bg-white focus:outline-none">
            <option value="Semua Status" {{ request('status') == 'Semua Status' ? 'selected' : '' }}>Semua Status</option>
            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
            <option value="dalam review" {{ request('status') == 'dalam review' ? 'selected' : '' }}>Dalam Review</option>
            <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>Revisi</option>
            <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
    </div>
</form>

<x-card class="!p-0">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead>
                <tr class="bg-slate-50/75">
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-widest">Judul Naskah</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-widest">Author</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-widest">Tanggal</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-widest">Status</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                @forelse($naskahs as $naskah)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 w-1/3">
                            <div class="truncate max-w-md" title="{{ $naskah->title }}">{{ $naskah->title }}</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                Kategori: {{ $naskah->category->nama_kategori ?? '-' }} | Paket: {{ $naskah->package->nama_paket ?? '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $naskah->user->name ?? '-' }}
                        </td>
                        @php $admDate = $naskah->submitted_at ?? $naskah->created_at; @endphp
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $admDate ? $admDate->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') . ' WIB' : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-badge :status="$naskah->status" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.naskah.show', $naskah->id) }}" class="text-emerald-600 hover:text-emerald-800 transition-colors">Review</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">
                            Belum ada naskah yang diajukan oleh Author.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection