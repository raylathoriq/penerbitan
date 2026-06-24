@extends('layouts.editor')

@section('title', 'Editor Dashboard')
@section('page_title', 'Dashboard Editor')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-[1.4fr_0.8fr] gap-8">
    <div class="space-y-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <x-card class="border-l-4 border-l-teal-500">
                <div class="text-teal-700 text-sm font-medium tracking-wide">Menunggu Edit</div>
                <div class="text-4xl font-bold text-slate-900 mt-3 tracking-tight">{{ $waitingCount }}</div>
                <p class="text-xs text-slate-500 mt-2">Naskah disetujui yang perlu dirapikan.</p>
            </x-card>
            <x-card class="border-l-4 border-l-sky-500">
                <div class="text-sky-700 text-sm font-medium tracking-wide">Sedang Disunting</div>
                <div class="text-4xl font-bold text-slate-900 mt-3 tracking-tight">{{ $editingCount }}</div>
                <p class="text-xs text-slate-500 mt-2">Naskah sedang diperbaiki bahasa dan formatnya.</p>
            </x-card>
            <x-card class="border-l-4 border-l-emerald-500">
                <div class="text-emerald-700 text-sm font-medium tracking-wide">Selesai Disunting</div>
                <div class="text-4xl font-bold text-slate-900 mt-3 tracking-tight">{{ $completedCount }}</div>
                <p class="text-xs text-slate-500 mt-2">File hasil edit sudah dikirim untuk admin/author.</p>
            </x-card>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-slate-50/50">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Antrean Penyuntingan</h3>
                    <p class="text-sm text-slate-500 mt-1">Naskah yang sudah disetujui dan perlu dirapikan sebelum dikirim ke author.</p>
                </div>
                <a href="/editor/naskah" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-teal-700 hover:bg-teal-800 transition-colors active:scale-[0.98]">
                    Kelola Edit
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-medium">Judul Naskah</th>
                            <th class="px-6 py-4 font-medium">Status Edit</th>
                            <th class="px-6 py-4 font-medium">Deadline perkiraan</th>
                            <th class="px-6 py-4 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recent as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $item->title }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $item->user->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium 
                                        @if($item->status === 'perlu_edit') bg-teal-50 text-teal-700 ring-1 ring-teal-600/20
                                        @elseif($item->status === 'editing') bg-sky-50 text-sky-700 ring-1 ring-sky-600/20
                                        @else bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20
                                        @endif">
                                        {{ $item->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $item->submitted_at ? $item->submitted_at->copy()->addDays(14)->translatedFormat('d M Y') : $item->created_at->copy()->addDays(14)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="/editor/naskah/{{ $item->id }}" class="text-sm font-medium text-teal-700 hover:text-teal-800">
                                        @if($item->status === 'perlu_edit')
                                            Mulai Edit
                                        @else
                                            Buka
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                    Tidak ada antrean naskah yang memerlukan penyuntingan saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-slate-900 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="text-xs font-semibold uppercase tracking-wider text-teal-200">Fokus Minggu Ini</div>
                <h3 class="text-xl font-semibold text-white mt-3">Rapikan naskah yang sudah disetujui sebelum dikembalikan ke author.</h3>
                <p class="text-sm text-slate-300 mt-3 leading-relaxed">Editor memperbaiki bahasa, konsistensi format, struktur penulisan, dan catatan teknis agar author menerima file yang sudah dibenarkan.</p>
            </div>
            <div class="border-t border-white/10 px-6 py-4 text-sm text-slate-300">
                4 naskah perlu dikirim kembali ke author hari ini.
            </div>
        </div>

        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-slate-900">Tahap Kerja Editor</h3>
            </x-slot>
            <div class="space-y-4">
                <div class="flex gap-3">
                    <div class="mt-1 h-2.5 w-2.5 rounded-full bg-teal-600"></div>
                    <div>
                        <div class="text-sm font-medium text-slate-900">Terima naskah disetujui</div>
                        <p class="text-xs text-slate-500 mt-1">Editor menerima naskah yang sudah lolos keputusan admin/reviewer.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="mt-1 h-2.5 w-2.5 rounded-full bg-sky-600"></div>
                    <div>
                        <div class="text-sm font-medium text-slate-900">Sunting dan rapikan</div>
                        <p class="text-xs text-slate-500 mt-1">Perbaiki tata bahasa, format, konsistensi istilah, dan susunan naskah.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-600"></div>
                    <div>
                        <div class="text-sm font-medium text-slate-900">Kirim ke author</div>
                        <p class="text-xs text-slate-500 mt-1">Unggah file hasil edit dan kirim catatan perbaikan kepada author.</p>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection
