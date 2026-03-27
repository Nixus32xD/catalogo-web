@extends('layouts.base')

@section('body_class', 'bg-slate-100 text-slate-900')

@section('body')
    <div class="min-h-screen lg:grid lg:grid-cols-[280px_minmax(0,1fr)]">
        <aside class="border-b border-slate-200 bg-white lg:min-h-screen lg:border-b-0 lg:border-r">
            <div class="space-y-8 p-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-gradient text-sm font-semibold text-white">ADM</div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-slate-500">Panel demo</p>
                        <p class="text-base font-semibold text-slate-900">{{ $businessProfile->business_name }}</p>
                    </div>
                </a>

                <nav class="space-y-2 text-sm font-medium">
                    <a href="{{ route('admin.dashboard') }}" @class(['block rounded-2xl px-4 py-3 transition','bg-slate-900 text-white' => request()->routeIs('admin.dashboard'),'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => ! request()->routeIs('admin.dashboard')])>Resumen</a>
                    <a href="{{ route('admin.products.index') }}" @class(['block rounded-2xl px-4 py-3 transition','bg-slate-900 text-white' => request()->routeIs('admin.products.*'),'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => ! request()->routeIs('admin.products.*')])>Productos</a>
                    <a href="{{ route('admin.categories.index') }}" @class(['block rounded-2xl px-4 py-3 transition','bg-slate-900 text-white' => request()->routeIs('admin.categories.*'),'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => ! request()->routeIs('admin.categories.*')])>Categorias</a>
                    <a href="{{ route('admin.locations.index') }}" @class(['block rounded-2xl px-4 py-3 transition','bg-slate-900 text-white' => request()->routeIs('admin.locations.*'),'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => ! request()->routeIs('admin.locations.*')])>Sucursales</a>
                    <a href="{{ route('admin.business-profile.edit') }}" @class(['block rounded-2xl px-4 py-3 transition','bg-slate-900 text-white' => request()->routeIs('admin.business-profile.*'),'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => ! request()->routeIs('admin.business-profile.*')])>Configuracion</a>
                    <a href="{{ route('home') }}" class="block rounded-2xl px-4 py-3 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Ver sitio publico</a>
                    <a href="{{ route('profile.edit') }}" class="block rounded-2xl px-4 py-3 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Mi perfil</a>
                </nav>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-secondary w-full">Cerrar sesion</button>
                </form>
            </div>
        </aside>

        <div class="min-w-0">
            <header class="border-b border-slate-200 bg-white">
                <div class="container-shell flex flex-wrap items-center justify-between gap-4 py-5">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">@yield('admin_kicker', 'Administracion')</p>
                        <h1 class="mt-1 text-3xl font-semibold text-slate-900">@yield('admin_title')</h1>
                    </div>

                    @hasSection('admin_actions')
                        <div class="flex flex-wrap items-center gap-3">@yield('admin_actions')</div>
                    @endif
                </div>
            </header>

            <main class="container-shell py-8">
                <x-flash-messages />
                <div class="mt-6">@yield('content')</div>
            </main>
        </div>
    </div>
@endsection
