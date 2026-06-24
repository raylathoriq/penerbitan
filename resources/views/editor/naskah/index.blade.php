@extends('layouts.editor')

@section('title', 'Penyuntingan Naskah Editor')
@section('page_title', 'Penyuntingan Naskah')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-100 bg-slate-50/50 px-6 pt-4 flex gap-6">
        <a href="{{ route('editor.naskah.index', ['tab' => 'antrean']) }}" class="pb-3 text-sm font-medium border-b-2 transition-colors {{ $tab === 'antrean' ? 'border-teal-700 text-teal-700 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            Antrean Naskah
        </a>
        <a href="{{ route('editor.naskah.index', ['tab' => 'riwayat']) }}" class="pb-3 text-sm font-medium border-b-2 transition-colors {{ $tab === 'riwayat' ? 'border-teal-700 text-teal-700 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            Riwayat Suntingan Saya
        </a>
    </div>

    <div class="p-6 border-b border-slate-100 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">
                {{ $tab === 'riwayat' ? 'Riwayat Suntingan Saya' : 'Daftar Naskah untuk Editor' }}
            </h3>
            <p class="text-sm text-slate-500 mt-1">
                {{ $tab === 'riwayat' ? 'Daftar naskah yang pernah Anda selesaikan atau sedang Anda sunting.' : 'Naskah yang sudah disetujui dan perlu disunting sebelum dikirim kembali ke author.' }}
            </p>
        </div>
        <form method="GET" action="{{ route('editor.naskah.index') }}" class="flex flex-col sm:flex-row gap-3">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <select name="status" onchange="this.form.submit()" class="block rounded-lg border border-slate-200 py-2 px-3 text-sm focus:ring-teal-600 focus:border-teal-600">
                <option value="Semua status edit" {{ request('status') === 'Semua status edit' ? 'selected' : '' }}>Semua status edit</option>
                <option value="Menunggu Edit" {{ request('status') === 'Menunggu Edit' ? 'selected' : '' }}>Menunggu Edit</option>
                <option value="Sedang Disunting" {{ request('status') === 'Sedang Disunting' ? 'selected' : '' }}>Sedang Disunting</option>
                <option value="Selesai Disunting" {{ request('status') === 'Selesai Disunting' ? 'selected' : '' }}>Selesai Disunting</option>
            </select>
            <input type="search" name="search" value="{{ request('search') }}" class="block rounded-lg border border-slate-200 py-2 px-3 text-sm focus:ring-teal-600 focus:border-teal-600" placeholder="Cari judul naskah">
            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-teal-700 hover:bg-teal-800 transition-colors active:scale-[0.98]">
                Cari
            </button>
        </form>
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
                @forelse($naskahs as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $item->title }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $item->category->nama_kategori ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $item->user->name ?? '-' }}</td>
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
                            @php $edFile = $item->editorFile(); @endphp
                            @if($edFile)
                                <a href="{{ asset('storage/' . $edFile->file_path) }}" target="_blank" class="inline-flex items-center text-teal-700 hover:text-teal-800 font-medium">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                    v{{ $edFile->version }} (Unduh)
                                </a>
                            @else
                                <span class="text-slate-400">Belum diunggah</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $item->updated_at ? $item->updated_at->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="/editor/naskah/{{ $item->id }}" class="text-sm font-medium text-teal-700 hover:text-teal-800">
                                @if($item->status === 'perlu_edit')
                                    Sunting
                                @elseif($item->status === 'editing')
                                    Lanjutkan
                                @else
                                    Lihat
                                @endif
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                            Tidak ada naskah yang terdaftar dalam antrean Anda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
