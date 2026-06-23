    @extends('layouts.reviewer')

    @section('title', 'Reviewer Dashboard')
    @section('page_title', 'Dashboard')

    @section('content')
   <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
         <x-card class="border-l-4 border-l-indigo-400">
             <div class="text-indigo-500 text-sm font-medium tracking-wide">Menunggu Review</div>
             <div class="text-4xl font-bold text-indigo-900 mt-3 tracking-tight">{{ $assignedCount ?? 0 }}</div>
         </x-card>
     <x-card class="border-l-4 border-l-emerald-400">
             <div class="text-emerald-700 text-sm font-medium tracking-wide">Selesai Review</div>
             <div class="text-4xl font-bold text-emerald-900 mt-3 tracking-tight">{{ $completedCount ?? 0 }}</div>
     </x-card>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-base font-semibold text-slate-800">Tugas Review Terkini</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-medium">Judul Naskah</th>
                        <th class="px-6 py-4 font-medium">Tanggal Tugas</th>
                        <th class="px-6 py-4 font-medium">Deadline</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium ">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @if(isset($recent) && $recent->isNotEmpty())
                        @foreach($recent as $naskah)
                            @php $review = $naskah->activeReviewAssignment; @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $naskah->title }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">Oleh: {{ $naskah->user->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $naskah->created_at ? $naskah->created_at->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 font-medium">
                                    {{ $naskah->created_at ? $naskah->created_at->addDays(14)->copy()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($review && $review->reviewed_at)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                            Selesai Review
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                            Perlu Review
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ url('/reviewer/naskah/'.$naskah->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                        Lihat
                                    </a>
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