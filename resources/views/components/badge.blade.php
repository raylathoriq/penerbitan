@props(['status'])

@php
    $normalized = strtolower(trim($status));
    $statusClasses = match($normalized) {
        'diajukan' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        'dalam review' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
        'revisi' => 'bg-orange-50 text-orange-700 ring-orange-600/20',
        'diterima', 'terbit' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'ditolak' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
        'perlu_edit', 'menunggu edit' => 'bg-sky-50 text-sky-700 ring-sky-600/20',
        'editing', 'sedang disunting', 'proses editing' => 'bg-sky-50 text-sky-700 ring-sky-600/20',
        'selesai', 'selesai disunting' => 'bg-teal-50 text-teal-700 ring-teal-600/20',
        'pengajuan_isbn', 'pengajuan isbn' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
        default => 'bg-slate-50 text-slate-700 ring-slate-600/20',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold tracking-wide ring-1 ring-inset {{ $statusClasses }}">
    {{ ucfirst($status) }}
</span>