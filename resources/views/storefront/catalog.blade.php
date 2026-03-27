@extends('layouts.public')

@section('title', 'Catalogo')

@section('content')
    <section class="section-shell">
        <div class="container-shell space-y-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <span class="badge-soft">Catalogo publico</span>
                    <h1 class="mt-4 text-4xl font-semibold text-slate-900">Productos para explorar, filtrar y consultar</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                        La estructura esta pensada para navegar rapido desde celular o escritorio, con filtros simples y destacados visibles.
                    </p>
                </div>
                <a href="{{ route('contact') }}" class="btn-secondary">Contacto rapido</a>
            </div>

            <div class="card-panel p-5 sm:p-6">
                <form method="GET" action="{{ route('catalog.index') }}" class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_220px_auto]">
                    <div>
                        <label for="search" class="field-label">Buscar por nombre</label>
                        <input id="search" name="search" type="text" value="{{ $search }}" placeholder="Ej. producto premium" class="field-input">
                    </div>

                    <div>
                        <label for="category" class="field-label">Categoria</label>
                        <select id="category" name="category" class="field-input">
                            <option value="">Todas las categorias</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected(optional($selectedCategory)->is($category))>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-3">
                        <button type="submit" class="btn-primary w-full sm:w-auto">Aplicar filtros</button>
                        <a href="{{ route('catalog.index') }}" class="btn-secondary w-full sm:w-auto">Limpiar</a>
                    </div>
                </form>
            </div>

            @if ($featuredProducts->isNotEmpty())
                <div class="space-y-5">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-2xl font-semibold text-slate-900">Destacados</h2>
                        <p class="text-sm text-slate-500">Ideal para resaltar productos clave o promociones.</p>
                    </div>
                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                        @foreach ($featuredProducts as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="space-y-5">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-semibold text-slate-900">Todos los productos</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $products->total() }} resultado{{ $products->total() === 1 ? '' : 's' }}
                            @if ($selectedCategory)
                                en {{ $selectedCategory->name }}
                            @endif
                        </p>
                    </div>
                </div>

                @if ($products->count())
                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="pt-2">{{ $products->links() }}</div>
                @else
                    <x-empty-state
                        title="No encontramos productos con esos filtros"
                        description="Proba limpiar la busqueda o cambiar la categoria para volver a mostrar el catalogo completo."
                        :action-url="route('catalog.index')"
                        action-label="Ver todo el catalogo"
                    />
                @endif
            </div>
        </div>
    </section>
@endsection
