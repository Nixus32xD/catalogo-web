@props([
    'title',
    'description',
    'actionUrl' => null,
    'actionLabel' => null,
])

<div class="card-panel px-6 py-10 text-center sm:px-10">
    <span class="badge-soft">Sin resultados</span>
    <h3 class="mt-4 text-2xl font-semibold text-slate-900">{{ $title }}</h3>
    <p class="mx-auto mt-3 max-w-2xl text-sm leading-6 text-slate-600">{{ $description }}</p>

    @if ($actionUrl && $actionLabel)
        <div class="mt-6">
            <a href="{{ $actionUrl }}" class="btn-secondary">{{ $actionLabel }}</a>
        </div>
    @endif
</div>
