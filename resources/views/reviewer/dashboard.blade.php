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
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">Dasar Logika Matematika</div>
                            <div class="text-xs text-slate-500 mt-0.5">Oleh: Dr. Budi Santoso</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">01 Jun 2026</td>
                        <td class="px-6 py-4 text-rose-600 font-medium">14 Jun 2026</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                Perlu Review
                            </span>
                        </td>
                        <td class="px-6 py-4 ">
                            <a href="/reviewer/naskah/1" class="inline-flex items-center justify-center  text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                Lihat
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endsection