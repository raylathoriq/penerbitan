@extends('layouts.author')

@section('page_title', 'Detail Naskah')

@section('content')
<div class="mb-6">
    <a href="{{ route('author.naskah.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke halaman Naskah
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <x-card>
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $naskah->title }}</h2>
                    <p class="text-slate-500 mt-1">Diajukan oleh {{ $naskah->user->name }}</p>
                </div>
                <x-badge status="{{ $naskah->status_label }}" />
            </div>
            
            <div class="space-y-5 border-t border-slate-100 pt-5">
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kategori & Paket</h4>
                    <p class="text-slate-900 text-sm font-medium">
                        Kategori: <span class="text-emerald-700 font-semibold">{{ $naskah->category->nama_kategori ?? '-' }}</span> | 
                        Paket: <span class="text-emerald-700 font-semibold">{{ $naskah->package->nama_paket ?? '-' }}</span>
                    </p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Daftar Penulis</h4>
                    <p class="text-slate-900 text-sm leading-relaxed">
                        <strong class="font-semibold">{{ $naskah->user->name }}</strong> (Penulis Utama)
                        @if(!empty($naskah->co_author))
                            @foreach($naskah->co_author as $co)
                                <br>
                                <span class="text-slate-600">— {{ $co['name'] ?? '-' }} ({{ $co['affiliation'] ?? '-' }}) <span class="text-slate-400">&lt;{{ $co['email'] ?? '-' }}&gt;</span></span>
                            @endforeach
                        @endif
                    </p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Abstrak / Sinopsis</h4>
                    <p class="text-slate-700 leading-relaxed text-sm whitespace-pre-line">{{ $naskah->description }}</p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">File Terkirim</h4>
                    @php $authorFiles = $naskah->files()->whereIn('jenis_file', ['original', 'revisi'])->orderBy('version')->get(); @endphp
                    @if($authorFiles->isNotEmpty())
                        <div class="space-y-3 mt-2">
                            @foreach($authorFiles as $file)
                                <div class="flex items-center gap-3">
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-slate-200 shadow-sm rounded-lg text-sm text-slate-700 bg-white hover:bg-slate-50 hover:text-emerald-700 transition-colors">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        {{ $file->file_name }}
                                    </a>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                        {{ $file->jenis_file === 'revisi' ? 'Revisi (v' . $file->version . ')' : 'Asli (v1)' }}
                                    </span>
                                    @if($file->file_size)
                                        <span class="text-xs text-slate-400">{{ round($file->file_size / 1024, 1) }} KB</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-500 mt-1">File tidak tersedia.</p>
                    @endif
                </div>

                {{-- Hasil Evaluasi Reviewer --}}
                @if($naskah->reviews->isNotEmpty())
                    <div class="mt-8 border-t border-slate-100 pt-6">
                        <h4 class="text-sm font-semibold text-slate-900 mb-4">Catatan Evaluasi Reviewer</h4>
                        <div class="space-y-4">
                            @foreach($naskah->reviews as $review)
                                @if($review->reviewed_at)
                                    <div class="bg-slate-50/50 border border-slate-200/60 rounded-xl p-5">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-3">
                                            <div>
                                                <span class="font-semibold text-slate-900 text-sm">Reviewer</span>
                                                <span class="text-xs text-slate-400 sm:ml-2">Selesai pada: {{ $review->reviewed_at->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') }} WIB</span>
                                            </div>
                                            <span class="self-start sm:self-auto inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold
                                                @if($review->decision === 'diterima') bg-emerald-100 text-emerald-800
                                                @elseif($review->decision === 'revisi') bg-amber-100 text-amber-800
                                                @else bg-rose-100 text-rose-800
                                                @endif">
                                                {{ ucfirst($review->decision) }}
                                            </span>
                                        </div>

                                        @if($review->comments)
                                            <div class="text-sm text-slate-700 whitespace-pre-line bg-white border border-slate-200 rounded-lg p-3.5 mb-3 leading-relaxed">
                                                {{ $review->comments }}
                                            </div>
                                        @endif

                                        @php $reviewerFile = $naskah->reviewerFile(); @endphp
                                        @if($reviewerFile)
                                            <div class="flex items-center text-xs">
                                                <span class="text-slate-400 mr-2">File Koreksi:</span>
                                                <a href="{{ asset('storage/' . $reviewerFile->file_path) }}" target="_blank" class="inline-flex items-center font-medium text-indigo-600 hover:text-indigo-700 transition-colors">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                                    {{ $reviewerFile->file_name }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </x-card>
    </div>    <div class="lg:col-span-1">
        <x-card class="bg-slate-50/50">
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-slate-900">Kronologi</h3>
            </x-slot>
            @php
                $events = collect();

                // 1. Event: Diajukan (Submitted)
                $submitDate = $naskah->submitted_at ?? $naskah->created_at;
                if ($submitDate) {
                    $events->push([
                        'title' => 'Naskah Diajukan',
                        'date' => $submitDate,
                        'description' => 'Naskah berhasil diajukan oleh Penulis.',
                        'color' => 'bg-blue-500',
                        'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                    ]);
                }

                // 2. Events from reviews
                foreach ($naskah->reviews as $review) {
                    // Assignment Event
                    if ($review->created_at) {
                        $events->push([
                            'title' => 'Ditugaskan ke Reviewer',
                            'date' => $review->created_at,
                            'description' => 'Naskah ditugaskan kepada ' . ($review->reviewer->name ?? 'Reviewer') . ' oleh Redaksi.',
                            'color' => 'bg-indigo-500',
                            'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'
                        ]);
                    }

                    // Review Completed Event
                    if ($review->reviewed_at && $review->decision) {
                        $title = 'Review Selesai: ' . ucwords($review->decision);
                        $desc = 'Reviewer memberikan penilaian dengan keputusan: ' . ucwords($review->decision) . '.';
                        $color = 'bg-blue-500';
                        if ($review->decision === 'diterima') {
                            $color = 'bg-emerald-500';
                            $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0';
                        } elseif ($review->decision === 'revisi') {
                            $color = 'bg-amber-500';
                            $icon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                        } else {
                            $color = 'bg-rose-500';
                            $icon = 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0';
                        }

                        $events->push([
                            'title' => $title,
                            'date' => $review->reviewed_at,
                            'description' => $desc,
                            'color' => $color,
                            'icon' => $icon
                        ]);
                    }
                }

                // 3. Events from uploaded files (revisions)
                $revisions = $naskah->files()->where('jenis_file', 'revisi')->get();
                foreach ($revisions as $revFile) {
                    $events->push([
                        'title' => 'Revisi Dikirim (v' . $revFile->version . ')',
                        'date' => $revFile->uploaded_at ?? $revFile->created_at,
                        'description' => 'Penulis mengirimkan file revisi baru.',
                        'color' => 'bg-purple-500',
                        'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12'
                    ]);
                }

                // Sort events by date descending (latest first)
                $sortedEvents = $events->sortByDesc('date');
            @endphp

            <div class="relative mt-4 pl-2">
                @if($sortedEvents->isNotEmpty())
                    <div class="absolute top-2 bottom-2 left-[13px] w-px bg-slate-200"></div>
                    
                    <div class="space-y-6">
                        @foreach($sortedEvents as $event)
                            <div class="flex gap-4 relative">
                                <div class="w-2.5 h-2.5 rounded-full {{ $event['color'] }} ring-4 ring-white flex-shrink-0 mt-1 z-10"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-slate-900 leading-none">{{ $event['title'] }}</p>
                                    <p class="text-xs text-slate-500 mt-1.5 leading-normal">{{ $event['description'] }}</p>
                                    <p class="text-[10px] text-slate-400 mt-1 font-medium">{{ $event['date']->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') }} WIB</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada kronologi aktivitas.</p>
                @endif
            </div>
        </x-card>
    </div>
</div>
@endsection
