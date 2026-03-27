@extends('layouts.public')

@section('title', 'Landing')

@section('content')
    @php
        $profile = $profile ?? $businessProfile;
        $locations = $profile->locations ?? collect();
        $primaryLocation = $locations->firstWhere('is_primary', true) ?? $locations->first();
        $displayAddress = $primaryLocation?->address ?: $profile->address;
        $displayHours = $primaryLocation?->business_hours ?: $profile->business_hours;
        $displayPhone = $primaryLocation?->whatsapp ?: $primaryLocation?->phone ?: $profile->whatsapp ?: $profile->phone;
        $displayEmail = $primaryLocation?->email ?: $profile->email;
        $contactUrl = $profile->contactWhatsappUrl($primaryLocation) ?? route('contact');
        $contactTarget = str_starts_with($contactUrl, 'http') ? '_blank' : '_self';
        $contactRel = $contactTarget === '_blank' ? 'noreferrer' : null;
    @endphp

    <section class="section-shell">
        <div class="container-shell grid items-center gap-10 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)]">
            <div class="space-y-8">
                <div class="space-y-4">
                    <span class="badge-soft">Landing lista para personalizar</span>
                    <h1 class="max-w-3xl text-4xl font-semibold leading-tight text-slate-900 sm:text-5xl">
                        {{ $profile->business_name }}
                    </h1>
                    <p class="max-w-2xl text-lg leading-8 text-slate-600">
                        {{ $profile->welcome_text }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('catalog.index') }}" class="btn-primary">Ver catalogo</a>
                    <a href="#ubicacion" class="btn-secondary">Donde estamos</a>
                    <a href="{{ $contactUrl }}" class="btn-secondary" target="{{ $contactTarget }}" rel="{{ $contactRel }}">
                        Contactar / WhatsApp
                    </a>
                </div>

                <dl class="grid gap-4 sm:grid-cols-3">
                    <div class="card-panel px-5 py-4">
                        <dt class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Direccion</dt>
                        <dd class="mt-2 text-sm font-medium text-slate-900">{{ $displayAddress }}</dd>
                    </div>
                    <div class="card-panel px-5 py-4">
                        <dt class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Contacto</dt>
                        <dd class="mt-2 text-sm font-medium text-slate-900">{{ $displayPhone ?: 'Telefono / WhatsApp' }}</dd>
                    </div>
                    <div class="card-panel px-5 py-4">
                        <dt class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Horario</dt>
                        <dd class="mt-2 text-sm font-medium text-slate-900">{{ $displayHours }}</dd>
                    </div>
                </dl>
            </div>

            <div class="relative">
                <div class="absolute inset-x-10 top-8 -z-10 h-full rounded-[2rem] bg-brand-gradient opacity-20 blur-3xl"></div>
                <div class="card-panel overflow-hidden p-4">
                    <x-media-placeholder
                        :src="$profile->hero_image_url"
                        alt="Imagen principal del comercio"
                        label="Insertar imagen del local aqui"
                        class="aspect-[4/3] border-slate-200"
                    />

                    <div class="grid gap-4 p-4 sm:grid-cols-2">
                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Logo</p>
                            <div class="mt-3 flex items-center gap-3">
                                @if ($profile->logo_url)
                                    <div class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-white p-2">
                                        <img src="{{ $profile->logo_url }}" alt="{{ $profile->business_name }}" class="h-full w-full object-contain">
                                    </div>
                                @else
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-white text-[10px] font-semibold uppercase tracking-[0.24em] text-slate-500">
                                        Insertar logo aqui
                                    </div>
                                @endif
                                <p class="text-sm text-slate-600">Espacio pensado para logo, isotipo o foto de marca.</p>
                            </div>
                        </div>
                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Descripcion breve</p>
                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $profile->short_description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell pt-0">
        <div class="container-shell">
            <div class="card-panel overflow-hidden">
                <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-3">
                    <div>
                        <span class="badge-soft">Por que elegirnos</span>
                        <h2 class="mt-4 text-3xl font-semibold text-slate-900">Una presentacion simple, clara y profesional</h2>
                        <p class="mt-4 text-sm leading-7 text-slate-600">
                            Esta seccion funciona como argumento comercial para cualquier rubro y se adapta rapido cambiando textos, imagenes y colores.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-[1.5rem] border border-slate-200 p-5">
                            <h3 class="text-lg font-semibold text-slate-900">Atencion cercana</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Texto placeholder para destacar acompanamiento, asesoria y trato personalizado.</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-slate-200 p-5">
                            <h3 class="text-lg font-semibold text-slate-900">Propuesta clara</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Espacio para resumir beneficios concretos del negocio en pocas lineas.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-[1.5rem] border border-slate-200 p-5">
                            <h3 class="text-lg font-semibold text-slate-900">Canal de contacto rapido</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Ideal para llevar al cliente a WhatsApp, reservas, consultas o pedidos en segundos.</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-slate-200 p-5">
                            <h3 class="text-lg font-semibold text-slate-900">Catalogo ordenado</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Categorias, destacados y buscador listos para mostrar productos sin friccion.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell pt-0">
        <div class="container-shell space-y-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <span class="badge-soft">Productos destacados</span>
                    <h2 class="mt-4 text-3xl font-semibold text-slate-900">Una seleccion lista para mostrar al instante</h2>
                </div>
                <a href="{{ route('catalog.index') }}" class="btn-secondary">Ir al catalogo completo</a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @forelse ($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="md:col-span-2 xl:col-span-4">
                        <x-empty-state
                            title="No hay productos destacados cargados"
                            description="La demo esta preparada para mostrar destacados apenas actives productos desde el panel."
                            :action-url="route('catalog.index')"
                            action-label="Ver catalogo"
                        />
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="contacto" class="section-shell pt-0">
        <div class="container-shell grid gap-6 lg:grid-cols-[minmax(0,1fr)_380px]">
            <div class="card-panel p-6 sm:p-8">
                <span class="badge-soft">Contacto</span>
                <h2 class="mt-4 text-3xl font-semibold text-slate-900">Canales listos para consultas, pedidos o reservas</h2>
                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-[1.5rem] border border-slate-200 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">WhatsApp / telefono</p>
                        <p class="mt-3 text-sm font-medium text-slate-900">{{ $displayPhone ?: 'Telefono / WhatsApp' }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-slate-200 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Email</p>
                        <p class="mt-3 text-sm font-medium text-slate-900">{{ $displayEmail ?: 'Email del comercio' }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-slate-200 p-5 sm:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Mensaje de bienvenida</p>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $profile->welcome_text }}</p>
                    </div>
                </div>
            </div>

            <div id="ubicacion" class="card-panel p-6 sm:p-8">
                <span class="badge-soft">Ubicacion</span>
                <h2 class="mt-4 text-3xl font-semibold text-slate-900">
                    {{ $locations->count() > 1 ? 'Sucursales y ubicacion' : 'Donde estamos' }}
                </h2>
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
                        <x-media-placeholder label="Insertar mapa o vista del local aqui" class="aspect-[4/3] border-slate-200" />
                    @endif
                </div>

                @if ($primaryLocation?->maps_url)
                    <a href="{{ $primaryLocation->maps_url }}" target="_blank" rel="noreferrer" class="mt-4 inline-flex text-sm font-semibold text-brand">
                        Abrir ubicacion en mapa
                    </a>
                @endif

                @if ($locations->isNotEmpty())
                    <div class="mt-6 grid gap-3">
                        @foreach ($locations as $location)
                            <article class="rounded-[1.5rem] border border-slate-200 p-4">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <p class="text-sm font-semibold text-slate-900">{{ $location->name }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @if ($location->is_primary)
                                            <span class="badge-soft">Principal</span>
                                        @endif
                                        @if (! $location->is_active)
                                            <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">Inactiva</span>
                                        @endif
                                    </div>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $location->address }}</p>
                                @if ($location->business_hours)
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $location->business_hours }}</p>
                                @endif
                                @if ($location->maps_url)
                                    <a href="{{ $location->maps_url }}" target="_blank" rel="noreferrer" class="mt-3 inline-flex text-sm font-semibold text-brand">
                                        Ver sucursal
                                    </a>
                                @endif
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if ($locations->count() > 1)
        <section class="section-shell pt-0">
            <div class="container-shell">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <span class="badge-soft">Red de sucursales</span>
                        <h2 class="mt-4 text-3xl font-semibold text-slate-900">La demo ya contempla negocios con mas de un punto de venta</h2>
                    </div>
                    <a href="{{ route('contact') }}" class="btn-secondary">Ver datos completos</a>
                </div>

                <div @class([
                    'mt-8 grid gap-4',
                    'lg:grid-cols-2' => $locations->count() === 2,
                    'lg:grid-cols-3' => $locations->count() >= 3,
                ])>
                    @foreach ($locations as $location)
                        @php
                            $locationWhatsappUrl = $profile->contactWhatsappUrl($location);
                        @endphp

                        <article class="card-panel p-6">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-lg font-semibold text-slate-900">{{ $location->name }}</h3>
                                @if ($location->is_primary)
                                    <span class="badge-soft">Principal</span>
                                @endif
                            </div>
                            <p class="mt-4 text-sm leading-6 text-slate-600">{{ $location->address }}</p>
                            @if ($location->business_hours)
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $location->business_hours }}</p>
                            @endif
                            <div class="mt-4 flex flex-wrap gap-3 text-sm font-semibold text-brand">
                                @if ($locationWhatsappUrl)
                                    <a href="{{ $locationWhatsappUrl }}" target="_blank" rel="noreferrer">WhatsApp</a>
                                @endif
                                @if ($location->maps_url)
                                    <a href="{{ $location->maps_url }}" target="_blank" rel="noreferrer">Mapa</a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
