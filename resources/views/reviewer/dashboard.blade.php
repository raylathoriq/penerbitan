    @extends('layouts.reviewer')

    @section('title', 'Reviewer Dashboard')
    @section('page_title', 'Dashboard')

    @section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center">
            <div class="bg-indigo-50 text-indigo-600 rounded-lg p-3 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Menunggu Review</p>
                <p class="text-2xl font-bold text-slate-900">2</p>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center">
            <div class="bg-emerald-50 text-emerald-600 rounded-lg p-3 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Selesai Direview</p>
                <p class="text-2xl font-bold text-slate-900">12</p>
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