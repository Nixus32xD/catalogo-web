@extends('layouts.admin')

@section('title', 'Productos')
@section('admin_title', 'Productos')
@section('admin_kicker', 'Catalogo interno')

@section('admin_actions')
    <a href="{{ route('admin.products.create') }}" class="btn-primary">Nuevo producto</a>
@endsection

@section('content')
    <div class="space-y-6">
        <div class="card-panel p-5 sm:p-6">
            <form method="GET" action="{{ route('admin.products.index') }}" class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_220px_220px_auto]">
                <div>
                    <label for="search" class="field-label">Buscar</label>
                    <input id="search" name="search" type="text" value="{{ $search }}" placeholder="Nombre del producto" class="field-input">
                </div>
                <div>
                    <label for="category_id" class="field-label">Categoria</label>
                    <select id="category_id" name="category_id" class="field-input">
                        <option value="">Todas</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($selectedCategoryId === $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="field-label">Estado</label>
                    <select id="status" name="status" class="field-input">
                        <option value="">Todos</option>
                        <option value="active" @selected($status === 'active')>Activos</option>
                        <option value="inactive" @selected($status === 'inactive')>Inactivos</option>
                    </select>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="btn-primary w-full sm:w-auto">Filtrar</button>
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary w-full sm:w-auto">Limpiar</a>
                </div>
            </form>
        </div>

        @if ($products->count())
            <div class="grid gap-5 lg:grid-cols-2 2xl:grid-cols-3">
                @foreach ($products as $product)
                    <article class="card-panel overflow-hidden">
                        <div class="grid gap-4 p-4 sm:grid-cols-[120px_minmax(0,1fr)]">
                            <x-media-placeholder :src="$product->image_url" :alt="$product->name" :label="$product->name" class="aspect-square border-slate-200" />

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <span class="badge-soft">{{ $product->category->name }}</span>
                                        <h2 class="mt-3 text-xl font-semibold text-slate-900">{{ $product->name }}</h2>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                        {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>

                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $product->short_description }}</p>

                                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                                    <div class="text-sm text-slate-500">
                                        <span class="font-semibold text-slate-900">${{ number_format((float) $product->price, 0, ',', '.') }}</span>
                                        <span class="mx-2">-</span>
                                        Orden {{ $product->sort_order }}
                                        @if ($product->is_featured)
                                            <span class="mx-2">-</span>
                                            Destacado
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-secondary">Editar</a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Eliminar este producto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-full border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{ $products->links() }}
        @else
            <x-empty-state
                title="Todavia no hay productos cargados"
                description="Crea el primer producto de la demo para empezar a poblar la landing y el catalogo publico."
                :action-url="route('admin.products.create')"
                action-label="Crear producto"
            />
        @endif
    </div>
@endsection
