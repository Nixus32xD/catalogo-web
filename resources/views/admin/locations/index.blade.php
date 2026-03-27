@extends('layouts.admin')

@section('title', 'Sucursales')
@section('admin_title', 'Sucursales')
@section('admin_kicker', 'Ubicaciones')

@section('admin_actions')
    <a href="{{ route('admin.locations.create') }}" class="btn-primary">Nueva sucursal</a>
@endsection

@section('content')
    <div class="space-y-6">
        <div class="card-panel p-5 sm:p-6">
            <form method="GET" action="{{ route('admin.locations.index') }}" class="flex flex-wrap gap-3">
                <div class="min-w-[260px] flex-1">
                    <label for="search" class="field-label">Buscar sucursal</label>
                    <input id="search" name="search" type="text" value="{{ $search }}" class="field-input" placeholder="Nombre o direccion">
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="btn-primary">Buscar</button>
                    <a href="{{ route('admin.locations.index') }}" class="btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>

        @if ($locations->count())
            <div class="grid gap-5 lg:grid-cols-2">
                @foreach ($locations as $location)
                    <article class="card-panel p-6">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h2 class="text-2xl font-semibold text-slate-900">{{ $location->name }}</h2>
                                    @if ($location->is_primary)
                                        <span class="badge-soft">Principal</span>
                                    @endif
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $location->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                        {{ $location->is_active ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </div>
                                <p class="mt-4 text-sm leading-6 text-slate-600">{{ $location->address }}</p>
                                @if ($location->business_hours)
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $location->business_hours }}</p>
                                @endif
                                @if ($location->notes)
                                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $location->notes }}</p>
                                @endif
                            </div>

                            <div class="space-y-1 text-right text-sm text-slate-500">
                                <p>Orden {{ $location->sort_order }}</p>
                                <p>{{ $location->map_embed_url ? 'Mapa embebido listo' : 'Sin mapa embebido' }}</p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-3 rounded-[1.5rem] border border-slate-200 p-4 sm:grid-cols-2">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">WhatsApp / telefono</p>
                                <p class="mt-2 text-sm font-medium text-slate-900">{{ $location->whatsapp ?: $location->phone ?: 'Sin contacto directo' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Email</p>
                                <p class="mt-2 text-sm font-medium text-slate-900">{{ $location->email ?: 'Sin email cargado' }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-2">
                            <a href="{{ route('admin.locations.edit', $location) }}" class="btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" onsubmit="return confirm('Eliminar esta sucursal?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">Eliminar</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            {{ $locations->links() }}
        @else
            <x-empty-state
                title="Todavia no hay sucursales cargadas"
                description="Crea al menos una sucursal para mostrar direccion, horarios y mapa editable en el sitio publico."
                :action-url="route('admin.locations.create')"
                action-label="Crear sucursal"
            />
        @endif
    </div>
@endsection
