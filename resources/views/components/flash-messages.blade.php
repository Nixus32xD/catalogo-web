@php
    $messages = collect([
        ['type' => 'success', 'text' => session('success')],
        ['type' => 'error', 'text' => session('error')],
        ['type' => 'status', 'text' => session('status')],
    ])->filter(fn ($message) => filled($message['text']));
@endphp

@if ($messages->isNotEmpty())
    <div class="space-y-3">
        @foreach ($messages as $message)
            <div @class([
                'rounded-2xl border px-4 py-3 text-sm font-medium',
                'border-emerald-200 bg-emerald-50 text-emerald-700' => $message['type'] === 'success',
                'border-rose-200 bg-rose-50 text-rose-700' => $message['type'] === 'error',
                'border-sky-200 bg-sky-50 text-sky-700' => $message['type'] === 'status',
            ])>
                {{ $message['text'] }}
            </div>
        @endforeach
    </div>
@endif
