@props(['type' => 'primary', 'typeHtml' => 'button'])

@php
    $baseClasses = 'inline-flex justify-center items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $typeClasses = match($type) {
        'primary' => 'text-white bg-emerald-800 hover:bg-emerald-900 focus:ring-emerald-800 shadow-sm border border-transparent',
        'secondary' => 'border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 hover:text-slate-900 shadow-sm focus:ring-slate-200',
        'danger' => 'text-white bg-rose-600 hover:bg-rose-700 focus:ring-rose-600 shadow-sm border border-transparent',
        'ghost' => 'text-slate-600 bg-transparent hover:bg-slate-100 hover:text-slate-900 focus:ring-slate-200',
        default => 'text-white bg-emerald-800 hover:bg-emerald-900 focus:ring-emerald-800 shadow-sm border border-transparent',
    };
@endphp

<button type="{{ $typeHtml }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . $typeClasses]) }}>
    {{ $slot }}
</button>