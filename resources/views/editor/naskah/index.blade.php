@extends('layouts.editor')

@section('title', 'Penyuntingan Naskah Editor')
@section('page_title', 'Penyuntingan Naskah')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Daftar Naskah untuk Editor</h3>
            <p class="text-sm text-slate-500 mt-1">Naskah yang sudah disetujui dan perlu disunting sebelum dikirim kembali ke author.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select class="block rounded-lg border border-slate-200 py-2 px-3 text-sm focus:ring-teal-600 focus:border-teal-600">
                <option>Semua status edit</option>
                <option>Menunggu Edit</option>
                <option>Sedang Disunting</option>
                <option>Dikirim ke Author</option>
            </select>
            <input type="search" class="block rounded-lg border border-slate-200 py-2 px-3 text-sm focus:ring-teal-600 focus:border-teal-600" placeholder="Cari judul naskah">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-medium">Judul Naskah</th>
                    <th class="px-6 py-4 font-medium">Penulis</th>
                    <th class="px-6 py-4 font-medium">Status Edit</th>
                    <th class="px-6 py-4 font-medium">File Editor</th>
                    <th class="px-6 py-4 font-medium">Terakhir Update</th>
                    <th class="px-6 py-4 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">Dasar Logika Matematika</div>
                        <div class="text-xs text-slate-500 mt-0.5">Buku Ajar</div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">Dr. Budi Santoso</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-teal-50 text-teal-700 ring-1 ring-inset ring-teal-600/20">Menunggu Edit</span>
                    </td>
                    <td class="px-6 py-4 text-slate-600">Belum diunggah</td>
                    <td class="px-6 py-4 text-slate-600">08 Jun 2026</td>
                    <td class="px-6 py-4">
                        <a href="/editor/naskah/1" class="text-sm font-medium text-teal-700 hover:text-teal-800">Sunting</a>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">Pengantar Ilmu Komunikasi</div>
                        <div class="text-xs text-slate-500 mt-0.5">Buku Referensi</div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">Dr. Maya Larasati</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-600/20">Sedang Disunting</span>
                    </td>
                    <td class="px-6 py-4 text-slate-600">Draft editor v1</td>
                    <td class="px-6 py-4 text-slate-600">04 Jun 2026</td>
                    <td class="px-6 py-4">
                        <a href="/editor/naskah/2" class="text-sm font-medium text-teal-700 hover:text-teal-800">Lanjutkan</a>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">Manajemen Risiko Organisasi Publik</div>
                        <div class="text-xs text-slate-500 mt-0.5">Monograf</div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">Prof. Ratna Wiradewi</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Dikirim ke Author</span>
                    </td>
                    <td class="px-6 py-4 text-slate-600">Terkirim</td>
                    <td class="px-6 py-4 text-slate-600">31 Mei 2026</td>
                    <td class="px-6 py-4">
                        <a href="/editor/naskah/3" class="text-sm font-medium text-teal-700 hover:text-teal-800">Lihat</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
