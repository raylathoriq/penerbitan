@extends('layouts.editor')

@section('title', 'Editor Dashboard')
@section('page_title', 'Dashboard Editor')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-[1.4fr_0.8fr] gap-8">
    <div class="space-y-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <!-- Card Menunggu Edit -->
            <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
                <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold text-teal-600 tracking-wider uppercase">Menunggu Edit</span>
                        <p class="text-xs text-slate-400 leading-snug">Antrean sunting baru</p>
                    </div>
                    <div class="text-teal-500 flex items-center justify-center">
                        <i class="bi bi-journal-text text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline gap-1.5">
                    <span class="text-3xl font-bold text-teal-600 tracking-tight">{{ $waitingCount }}</span>
                    <span class="text-[11px] font-medium text-teal-500">Naskah</span>
                </div>
            </div>

            <!-- Card Sedang Disunting -->
            <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
                <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold text-sky-600 tracking-wider uppercase">Sedang Disunting</span>
                        <p class="text-xs text-slate-400 leading-snug">Dalam proses editing</p>
                    </div>
                    <div class="text-sky-500 flex items-center justify-center">
                        <i class="bi bi-pencil-square text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline gap-1.5">
                    <span class="text-3xl font-bold text-sky-600 tracking-tight">{{ $editingCount }}</span>
                    <span class="text-[11px] font-medium text-sky-500">Naskah</span>
                </div>
            </div>

            <!-- Card Selesai Disunting -->
            <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
                <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold text-emerald-600 tracking-wider uppercase">Selesai Disunting</span>
                        <p class="text-xs text-slate-400 leading-snug">Sudah difinalisasi</p>
                    </div>
                    <div class="text-emerald-500 flex items-center justify-center">
                        <i class="bi bi-check-circle text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline gap-1.5">
                    <span class="text-3xl font-bold text-emerald-600 tracking-tight">{{ $completedCount }}</span>
                    <span class="text-[11px] font-medium text-emerald-500">Naskah</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-slate-50/50">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Antrean Penyuntingan</h3>
                    <p class="text-sm text-slate-500 mt-1">Daftar naskah dalam proses penyuntingan.</p>
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
