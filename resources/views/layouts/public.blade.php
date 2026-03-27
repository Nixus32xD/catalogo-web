@extends('layouts.base')

@section('body')
    @php
        $locations = $businessProfile->locations ?? collect();
        $primaryLocation = $locations->firstWhere('is_primary', true) ?? $locations->first();
        $footerAddress = $primaryLocation?->address ?: $businessProfile->address;
        $footerHours = $primaryLocation?->business_hours ?: $businessProfile->business_hours;
        $footerPhone = $primaryLocation?->whatsapp ?: $primaryLocation?->phone ?: $businessProfile->whatsapp ?: $businessProfile->phone;
    @endphp

    <div class="relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 -z-10 h-[520px] bg-[radial-gradient(circle_at_top,_rgba(15,118,110,0.08),_transparent_48%)]"></div>

        <header class="border-b border-slate-200/80 bg-white/85 backdrop-blur">
            <div class="container-shell">
                <nav class="flex flex-col items-center gap-4 py-4 lg:flex-row lg:justify-between">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 text-center lg:text-left">
                        @if ($businessProfile->logo_url)
                            <img src="{{ $businessProfile->logo_url }}" alt="{{ $businessProfile->business_name }}" class="h-12 w-12 rounded-2xl border border-slate-200 bg-white p-1 object-contain">
                        @else
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-100 text-[10px] font-semibold uppercase tracking-[0.22em] text-slate-500">
                                Logo
                            </div>
                        @endif

                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-slate-500">Demo generica</p>
                            <p class="text-base font-semibold text-slate-900">{{ $businessProfile->business_name }}</p>
                        </div>
                    </a>

                    <div class="action-group-centered w-full text-sm font-medium text-slate-600 lg:w-auto lg:justify-end">
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-brand' : 'hover:text-slate-900' }}">Inicio</a>
                        <a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.index') ? 'text-brand' : 'hover:text-slate-900' }}">Catalogo</a>
                        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-brand' : 'hover:text-slate-900' }}">Contacto</a>
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn-secondary w-full sm:w-auto">Panel admin</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-secondary w-full sm:w-auto">Ingresar</a>
                        @endauth
                    </div>
                </nav>
            </div>
        </header>

        <main>@yield('content')</main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="container-shell grid gap-10 py-10 lg:grid-cols-[minmax(0,1fr)_auto_auto]">
                <div class="space-y-4">
                    <p class="text-sm font-semibold uppercase tracking-[0.28em] text-slate-500">Comercio demo</p>
                    <h2 class="text-2xl font-semibold text-slate-900">{{ $businessProfile->business_name }}</h2>
                    <p class="max-w-xl text-sm leading-6 text-slate-600">{{ $businessProfile->short_description }}</p>
                </div>

                <div class="space-y-3 text-sm text-slate-600">
                    <p class="font-semibold text-slate-900">Accesos</p>
                    <a href="{{ route('home') }}" class="block hover:text-slate-900">Landing</a>
                    <a href="{{ route('catalog.index') }}" class="block hover:text-slate-900">Catalogo</a>
                    <a href="{{ route('contact') }}" class="block hover:text-slate-900">Contacto</a>
                </div>

                <div class="space-y-3 text-sm text-slate-600">
                    <p class="font-semibold text-slate-900">Datos del comercio</p>
                    <p>{{ $footerAddress }}</p>
                    <p>{{ $footerHours }}</p>
                    <p>{{ $footerPhone ?: 'Telefono / WhatsApp' }}</p>
                </div>
            </div>
        </footer>
    </div>
@endsection
