@extends('layouts.reviewer')

@section('title', 'Penugasan Naskah')
@section('page_title', 'Penugasan Naskah')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-semibold text-slate-900">Daftar Naskah yang Ditugaskan</h3>
        <p class="text-sm text-slate-500 mt-1">Lakukan penilaian dan berikan catatan review pada naskah-naskah berikut.</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-medium">Judul Naskah</th>
                    <th class="px-6 py-4 font-medium">Instruksi Redaksi</th>
                    <th class="px-6 py-4 font-medium">Status Penilaian</th>
                    <th class="px-6 py-4 font-medium">Tgl Selesai</th>
                    <th class="px-6 py-4 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @if(isset($assignments) && $assignments->count())
                    @foreach($assignments as $naskah)
                        @php $review = $naskah->activeReviewAssignment; @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $naskah->title }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">Oleh: {{ $naskah->user->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 max-w-xs truncate" title="{{ $review->assignment_note ?? '-' }}">
                                {{ $review->assignment_note ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($review && $review->reviewed_at)
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Selesai Review</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">Perlu Review</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $review && $review->reviewed_at ? $review->reviewed_at->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') : '-' }}</td>
                            <td class="px-6 py-4 ">
                                <a href="{{ url('/reviewer/naskah/'.$naskah->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Mulai Review</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-sm text-slate-500 text-center">Belum ada tugas review.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection