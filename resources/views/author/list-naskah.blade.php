@extends('layouts.author')

@section('page_title', 'Daftar Naskah Saya')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <p class="text-slate-500 text-sm">Berikut adalah seluruh portofolio naskah yang pernah Anda ajukan ke UPNVJ Press.</p>
    <a href="{{ route('author.naskah.create') }}" class="inline-flex justify-center items-center px-4 py-2.5 text-sm font-medium rounded-lg text-white bg-slate-900 hover:bg-slate-800 transition-all active:scale-95 shadow-sm">
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
                @forelse($naskahs as $naskah)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                            {{ $naskah->title }}
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                Kategori: {{ $naskah->category->nama_kategori ?? '-' }} | Paket: {{ $naskah->package->nama_paket ?? '-' }}
                            </div>
                        </td>
                        @php $date = $naskah->submitted_at ?? $naskah->created_at; @endphp
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $date ? $date->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') . ' WIB' : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-badge status="{{ $naskah->status_label }}" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                            @if($naskah->status === 'revisi')
                                <a href="{{ url('/author/revisi/' . $naskah->id) }}" class="text-orange-600 hover:text-orange-800 transition-colors">Kirim Revisi</a>
                            @endif
                            <a href="{{ route('author.naskah.show', $naskah->id) }}" class="text-slate-500 hover:text-slate-900 transition-colors">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">
                            Belum ada naskah yang diajukan. Silakan ajukan naskah baru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection