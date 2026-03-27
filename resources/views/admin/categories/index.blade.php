@extends('layouts.admin')

@section('title', 'Categorias')
@section('admin_title', 'Categorias')
@section('admin_kicker', 'Organizacion')

@section('admin_actions')
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">Nueva categoria</a>
@endsection

@section('content')
    <div class="space-y-6">
        <div class="card-panel p-5 sm:p-6">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-wrap gap-3">
                <div class="min-w-[260px] flex-1">
                    <label for="search" class="field-label">Buscar categoria</label>
                    <input id="search" name="search" type="text" value="{{ $search }}" class="field-input" placeholder="Nombre de la categoria">
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="btn-primary">Buscar</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>

        @if ($categories->count())
            <div class="grid gap-5 lg:grid-cols-2">
                @foreach ($categories as $category)
                    <article class="card-panel p-6">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h2 class="text-2xl font-semibold text-slate-900">{{ $category->name }}</h2>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $category->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                        {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $category->description ?: 'Sin descripcion cargada.' }}</p>
                            </div>
                            <div class="text-right text-sm text-slate-500">
                                <p>Orden {{ $category->sort_order }}</p>
                                <p class="mt-1">{{ $category->products_count }} producto{{ $category->products_count === 1 ? '' : 's' }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Eliminar esta categoria?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">Eliminar</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            {{ $categories->links() }}
        @else
            <x-empty-state
                title="No hay categorias para mostrar"
                description="Crea categorias para ordenar el catalogo publico y simplificar la carga de productos."
                :action-url="route('admin.categories.create')"
                action-label="Crear categoria"
            />
        @endif
    </div>
@endsection
