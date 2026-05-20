@extends('layouts.author')

@section('page_title', 'Daftar Naskah Saya')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <p class="text-slate-500 text-sm">Berikut adalah seluruh portofolio naskah yang pernah Anda ajukan ke UPNVJ Press.</p>
    <a href="/author/upload" class="inline-flex justify-center items-center px-4 py-2.5 text-sm font-medium rounded-lg text-white bg-slate-900 hover:bg-slate-800 transition-all active:scale-95 shadow-sm">
        Ajukan Naskah Baru
    </a>
</div>

<x-card class="!p-0">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead>
                <tr class="bg-slate-50/75">
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-widest">Judul Buku</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-widest">Tanggal Pengajuan</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-widest">Status Terkini</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">Analisis Struktur Basis Data</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">10 Mei 2026</td>
                    <td class="px-6 py-4 whitespace-nowrap"><x-badge status="Dalam Review" /></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                        <a href="/author/naskah/1" class="text-slate-500 hover:text-slate-900 transition-colors">Detail</a>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">Kalkulus Lanjut</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">01 Mei 2026</td>
                    <td class="px-6 py-4 whitespace-nowrap"><x-badge status="Revisi" /></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                        <a href="/author/revisi/2" class="text-orange-600 hover:text-orange-800 transition-colors">Kirim Revisi</a>
                        <a href="/author/naskah/2" class="text-slate-500 hover:text-slate-900 transition-colors">Detail</a>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">Panduan Laravel Dasar</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">05 Apr 2026</td>
                    <td class="px-6 py-4 whitespace-nowrap"><x-badge status="Terbit" /></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                        <a href="/author/naskah/3" class="text-slate-500 hover:text-slate-900 transition-colors">Detail</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-card>
@endsection