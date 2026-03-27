@props([
    'src' => null,
    'alt' => '',
    'label' => 'Insertar imagen aqui',
])

<div {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-[1.75rem] border border-dashed border-slate-300']) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="h-full w-full object-cover">
    @else
        <div class="placeholder-surface flex h-full w-full items-center justify-center p-6 text-center">
            <div class="space-y-3">
                <span class="badge-soft">Placeholder</span>
                <p class="mx-auto max-w-xs text-sm font-semibold text-slate-700">{{ $label }}</p>
            </div>
        </div>
    @endif
</div>
