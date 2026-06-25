@extends('layouts.reviewer')

    @section('title', 'Reviewer Dashboard')
    @section('page_title', 'Dashboard')

    @section('content')
   <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <!-- Card Menunggu Review -->
          <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
              <div class="flex justify-between items-start">
                  <div class="space-y-1">
                      <span class="text-xs font-semibold text-indigo-600 tracking-wider uppercase">Menunggu Review</span>
                      <p class="text-xs text-slate-400 leading-snug">Antrean peninjauan baru</p>
                  </div>
                  <div class="text-indigo-500 flex items-center justify-center">
                      <i class="bi bi-journal-text text-xl"></i>
                  </div>
              </div>
              <div class="mt-4 flex items-baseline gap-1.5">
                  <span class="text-3xl font-bold text-indigo-600 tracking-tight">{{ $assignedCount ?? 0 }}</span>
                  <span class="text-[11px] font-medium text-indigo-500">Naskah</span>
              </div>
          </div>

          <!-- Card Selesai Review -->
          <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[140px]">
              <div class="flex justify-between items-start">
                  <div class="space-y-1">
                      <span class="text-xs font-semibold text-emerald-600 tracking-wider uppercase">Selesai Review</span>
                      <p class="text-xs text-slate-400 leading-snug">Sudah dinilai</p>
                  </div>
                  <div class="text-emerald-500 flex items-center justify-center">
                      <i class="bi bi-check-circle text-xl"></i>
                  </div>
              </div>
              <div class="mt-4 flex items-baseline gap-1.5">
                  <span class="text-3xl font-bold text-emerald-600 tracking-tight">{{ $completedCount ?? 0 }}</span>
                  <span class="text-[11px] font-medium text-emerald-500">Naskah</span>
              </div>
          </div>
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
                                    {{ $naskah->created_at ? $naskah->created_at->copy()->addDays(14)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') : '-' }}
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