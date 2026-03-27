@extends('layouts.public')

@section('title', 'Contacto')

@section('content')
    @php
        $profile = $profile ?? $businessProfile;
        $locations = $profile->locations ?? collect();
        $primaryLocation = $locations->firstWhere('is_primary', true) ?? $locations->first();
        $displayWhatsapp = $primaryLocation?->whatsapp ?: $profile->whatsapp;
        $displayWhatsappUrl = $profile->contactWhatsappUrl($primaryLocation);
        $displayEmail = $primaryLocation?->email ?: $profile->email;
        $displayAddress = $primaryLocation?->address ?: $profile->address;
        $displayHours = $primaryLocation?->business_hours ?: $profile->business_hours;
    @endphp

    <section class="section-shell">
        <div class="container-shell grid gap-6 lg:grid-cols-[minmax(0,1fr)_420px]">
            <div class="space-y-6">
                <div>
                    <span class="badge-soft">Contacto y ubicacion</span>
                    <h1 class="mt-4 text-4xl font-semibold text-slate-900">Toda la informacion del comercio en una vista clara</h1>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-600">
                        Esta pagina funciona como cierre comercial: deja visibles los datos clave, la sucursal principal y todas las ubicaciones activas del negocio.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="card-panel p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">WhatsApp</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ $displayWhatsapp ?: 'Telefono / WhatsApp' }}</p>
                        @if ($displayWhatsappUrl)
                            <a href="{{ $displayWhatsappUrl }}" target="_blank" rel="noreferrer" class="mt-4 inline-flex text-sm font-semibold text-brand">Escribir ahora</a>
                        @endif
                    </div>

                    <div class="card-panel p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Email</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ $displayEmail ?: 'Email del comercio' }}</p>
                    </div>

                    <div class="card-panel p-6 sm:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Sucursal principal</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ $primaryLocation?->name ?: 'Sucursal principal' }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ $displayAddress }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ $displayHours }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <h2 class="text-2xl font-semibold text-slate-900">
                            {{ $locations->count() > 1 ? 'Sucursales activas' : 'Ubicacion del comercio' }}
                        </h2>
                        @if ($primaryLocation?->maps_url)
                            <a href="{{ $primaryLocation->maps_url }}" target="_blank" rel="noreferrer" class="text-sm font-semibold text-brand">Abrir mapa principal</a>
                        @endif
                    </div>

                    <div class="grid gap-4">
                        @forelse ($locations as $location)
                            @php
                                $locationWhatsappUrl = $profile->contactWhatsappUrl($location);
                            @endphp

                            <article class="card-panel p-6">
                                <div class="flex flex-wrap items-start justify-between gap-4">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-3">
                                            <h3 class="text-xl font-semibold text-slate-900">{{ $location->name }}</h3>
                                            @if ($location->is_primary)
                                                <span class="badge-soft">Principal</span>
                                            @endif
                                        </div>
                                        <p class="mt-4 text-sm leading-6 text-slate-600">{{ $location->address }}</p>
                                        @if ($location->business_hours)
                                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $location->business_hours }}</p>
                                        @endif
                                        @if ($location->notes)
                                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $location->notes }}</p>
                                        @endif
                                    </div>

                                    <div class="space-y-2 text-sm text-slate-600">
                                        @if ($location->whatsapp)
                                            <p>{{ $location->whatsapp }}</p>
                                        @endif
                                        @if ($location->phone)
                                            <p>{{ $location->phone }}</p>
                                        @endif
                                        @if ($location->email)
                                            <p>{{ $location->email }}</p>
                                        @endif
                                        <div class="flex flex-wrap gap-3 pt-2 font-semibold text-brand">
                                            @if ($locationWhatsappUrl)
                                                <a href="{{ $locationWhatsappUrl }}" target="_blank" rel="noreferrer">WhatsApp</a>
                                            @endif
                                            @if ($location->phone_url)
                                                <a href="{{ $location->phone_url }}">Llamar</a>
                                            @endif
                                            @if ($location->maps_url)
                                                <a href="{{ $location->maps_url }}" target="_blank" rel="noreferrer">Ver mapa</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <article class="card-panel p-6">
                                <p class="text-sm leading-6 text-slate-600">Aun no hay sucursales cargadas. La demo usa mientras tanto la direccion general del comercio.</p>
                            </article>
                        @endforelse
                    </div>
                </div>

                @if ($featuredProducts->isNotEmpty())
                    <div class="space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <h2 class="text-2xl font-semibold text-slate-900">Tambien podes destacar productos aqui</h2>
                            <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-brand">Ver catalogo</a>
                        </div>
                        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                            @foreach ($featuredProducts as $product)
                                <x-product-card :product="$product" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="card-panel p-6 sm:p-8">
                <span class="badge-soft">Donde estamos</span>
                <h2 class="mt-4 text-3xl font-semibold text-slate-900">Mapa de la sucursal principal</h2>
                <p class="mt-4 text-sm leading-6 text-slate-600">{{ $displayAddress }}</p>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $displayHours }}</p>
                <div class="mt-6">
                    @if ($primaryLocation?->map_embed_url)
                        <div class="overflow-hidden rounded-[1.75rem] border border-slate-200">
                            <iframe
                                src="{{ $primaryLocation->map_embed_url }}"
                                class="aspect-[4/3] h-full w-full"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen
                            ></iframe>
                        </div>
                    @else
                        <x-media-placeholder label="Insertar mapa, fachada o referencia visual aqui" class="aspect-[4/3] border-slate-200" />
                    @endif
                </div>
                @if ($primaryLocation?->maps_url)
                    <a href="{{ $primaryLocation->maps_url }}" target="_blank" rel="noreferrer" class="mt-4 inline-flex text-sm font-semibold text-brand">Abrir ubicacion</a>
                @endif
            </div>
        </div>
    </section>
@endsection
