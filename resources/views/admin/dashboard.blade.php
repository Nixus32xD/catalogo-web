@extends('layouts.admin')

@section('title', 'Panel admin')
@section('admin_title', 'Panel de administracion')
@section('admin_kicker', 'Resumen')

@section('admin_actions')
    <a href="{{ route('admin.products.create') }}" class="btn-primary">Nuevo producto</a>
    <a href="{{ route('home') }}" class="btn-secondary">Ver landing</a>
@endsection

@section('content')
    <div class="space-y-8">
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            <div class="card-panel p-6">
                <p class="text-sm text-slate-500">Productos activos</p>
                <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $stats['active_products'] }}</p>
            </div>
            <div class="card-panel p-6">
                <p class="text-sm text-slate-500">Destacados</p>
                <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $stats['featured_products'] }}</p>
            </div>
            <div class="card-panel p-6">
                <p class="text-sm text-slate-500">Categorias activas</p>
                <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $stats['active_categories'] }}</p>
            </div>
            <div class="card-panel p-6">
                <p class="text-sm text-slate-500">Sucursales activas</p>
                <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $stats['active_locations'] }}</p>
            </div>
            <div class="card-panel p-6">
                <p class="text-sm text-slate-500">Perfil configurado</p>
                <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $stats['profile_completion'] }}%</p>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="card-panel p-6 sm:p-8">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Estado del sitio</p>
                        <h2 class="mt-2 text-3xl font-semibold text-slate-900">{{ $profile->business_name }}</h2>
                    </div>
                    <a href="{{ route('admin.business-profile.edit') }}" class="btn-secondary">Editar datos</a>
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-[1.5rem] border border-slate-200 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Descripcion breve</p>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $profile->short_description }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-slate-200 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Contacto visible</p>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $profile->whatsapp ?: 'Telefono / WhatsApp' }}</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $profile->email ?: 'Email del comercio' }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-slate-200 p-5 sm:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Texto de bienvenida</p>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $profile->welcome_text }}</p>
                    </div>
                </div>
            </div>

            <div class="card-panel p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Acciones rapidas</p>
                <div class="mt-5 space-y-3">
                    <a href="{{ route('admin.products.index') }}" class="block rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 hover:bg-slate-50">Gestionar productos</a>
                    <a href="{{ route('admin.categories.index') }}" class="block rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 hover:bg-slate-50">Gestionar categorias</a>
                    <a href="{{ route('admin.locations.index') }}" class="block rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 hover:bg-slate-50">Gestionar sucursales</a>
                    <a href="{{ route('admin.business-profile.edit') }}" class="block rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 hover:bg-slate-50">Editar comercio demo</a>
                    <a href="{{ route('catalog.index') }}" class="block rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 hover:bg-slate-50">Revisar catalogo publico</a>
                </div>
            </div>
        </section>

        <section class="card-panel p-6 sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Ultimos productos</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-900">Contenido reciente de la demo</h2>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn-secondary">Ver todos</a>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left text-slate-500">
                            <th class="pb-3 font-semibold">Producto</th>
                            <th class="pb-3 font-semibold">Categoria</th>
                            <th class="pb-3 font-semibold">Precio</th>
                            <th class="pb-3 font-semibold">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentProducts as $product)
                            <tr>
                                <td class="py-4 font-medium text-slate-900">{{ $product->name }}</td>
                                <td class="py-4 text-slate-600">{{ $product->category->name }}</td>
                                <td class="py-4 text-slate-600">${{ number_format((float) $product->price, 0, ',', '.') }}</td>
                                <td class="py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                        {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-500">Todavia no hay productos cargados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
