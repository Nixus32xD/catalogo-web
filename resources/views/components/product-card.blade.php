@props(['product'])

@php
    $locations = $businessProfile->locations ?? collect();
    $primaryLocation = $locations->firstWhere('is_primary', true) ?? $locations->first();
    $productInquiryUrl = $businessProfile->productInquiryWhatsappUrl($product, $primaryLocation);
@endphp

<article class="card-panel flex h-full flex-col overflow-hidden">
    <div class="aspect-[4/3] p-3">
        <x-media-placeholder
            :src="$product->image_url"
            :alt="$product->name"
            :label="$product->name"
            class="h-full border-slate-200"
        />
    </div>

    <div class="flex flex-1 flex-col gap-4 px-6 pb-6">
        <div class="flex items-start justify-between gap-3">
            <div>
                <span class="badge-soft">{{ $product->category->name }}</span>
                <h3 class="mt-3 text-xl font-semibold text-slate-900">{{ $product->name }}</h3>
            </div>
            @if ($product->is_featured)
                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Destacado</span>
            @endif
        </div>

        <p class="text-sm leading-6 text-slate-600">
            {{ $product->short_description ?: 'Descripcion breve del producto para mostrar beneficios, diferencial y llamada a la accion.' }}
        </p>

        <div class="mt-auto flex items-center justify-between gap-4 pt-2">
            <span class="text-xl font-semibold text-slate-900">${{ number_format((float) $product->price, 0, ',', '.') }}</span>
            <a
                href="{{ $productInquiryUrl ?? route('contact') }}"
                target="{{ $productInquiryUrl ? '_blank' : '_self' }}"
                rel="{{ $productInquiryUrl ? 'noreferrer' : '' }}"
                class="text-sm font-semibold text-brand"
            >
                Consultar
            </a>
        </div>
    </div>
</article>
