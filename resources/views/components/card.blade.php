<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-slate-200/75 shadow-sm block relative overflow-hidden transition-all']) }}>
    @if(isset($header))
        <div class="px-6 py-5 border-b border-slate-100 bg-white/50">
            {{ $header }}
        </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 mt-auto">
            {{ $footer }}
        </div>
    @endif
</div>