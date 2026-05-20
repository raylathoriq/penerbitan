@extends('layouts.admin')

@section('page_title', 'Review & Validasi Naskah')

@section('content')
<div class="mb-6">
    <a href="/admin/naskah" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Daftar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <x-card>
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Dasar Logika Matematika</h2>
                    <p class="text-slate-500 mt-1">Diajukan oleh Dr. Budi Santoso</p>
                </div>
                <x-badge status="Diajukan" />
            </div>
            
            <div class="prose prose-slate max-w-none text-sm">
                <p>Naskah ini membahas secara komprehensif terkait struktur bla bla bla...</p>
            </div>

            <div class="mt-8 border-t border-slate-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 mb-3">Dokumen Naskah</h4>
                <a href="#" class="inline-flex items-center p-3 border border-slate-200 rounded-lg hover:bg-slate-50 hover:border-slate-300 transition-colors group">
                    <div class="bg-rose-100 text-rose-600 p-2 rounded mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-900 group-hover:text-emerald-700 transition-colors">Naskah_Logika_Final.pdf</p>
                        <p class="text-xs text-slate-500">2.4 MB</p>
                    </div>
                </a>
            </div>
        </x-card>
    </div>

    <div class="lg:col-span-1">
        <x-card class="sticky top-6">
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-slate-900">Keputusan Review</h3>
            </x-slot>
            <form action="#">
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Ubah Status</label>
                        <select class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm bg-white">
                            <option>Pilih Status Baru...</option>
                            <option>Dalam Review</option>
                            <option>Revisi</option>
                            <option>Diterima</option>
                            <option>Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan untuk Author</label>
                        <textarea rows="5" class="block w-full border border-slate-200 rounded-lg text-sm p-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" placeholder="Tulis instruksi revisi atau alasan penolakan..."></textarea>
                    </div>
                    <div class="pt-2">
                        <x-button type="primary" class="w-full">Simpan Keputusan</x-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection