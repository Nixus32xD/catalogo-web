<div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">
    <div class="space-y-6">
        <div class="card-panel p-6">
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="field-label">Nombre del producto</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" class="field-input" required>
                    @error('name') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="field-label">Categoria</label>
                    <select id="category_id" name="category_id" class="field-input" required>
                        <option value="">Seleccionar categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id) === $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="price" class="field-label">Precio</label>
                    <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price) }}" class="field-input" required>
                    @error('price') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sort_order" class="field-label">Orden de visualizacion</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $product->sort_order ?? 0) }}" class="field-input">
                    @error('sort_order') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-6 pt-8">
                    <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-0" @checked(old('is_active', $product->is_active))>
                        Activo
                    </label>

                    <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-0" @checked(old('is_featured', $product->is_featured))>
                        Destacado
                    </label>
                </div>

                <div class="sm:col-span-2">
                    <label for="short_description" class="field-label">Descripcion corta</label>
                    <textarea id="short_description" name="short_description" class="field-textarea">{{ old('short_description', $product->short_description) }}</textarea>
                    @error('short_description') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="card-panel p-6">
            <label for="image" class="field-label">Imagen del producto</label>
            <input id="image" name="image" type="file" accept="image/*" class="field-input">
            <p class="field-help">Subida opcional. Si no cargas una imagen, la demo mostrara un placeholder elegante.</p>
            @error('image') <p class="field-help text-rose-600">{{ $message }}</p> @enderror

            <div class="mt-5">
                <x-media-placeholder
                    :src="$product->image_url"
                    :alt="$product->name"
                    :label="$product->name ?: 'Insertar imagen del producto aqui'"
                    class="aspect-[4/3] border-slate-200"
                />
            </div>
        </div>

        <div class="card-panel p-6">
            <p class="text-sm font-semibold text-slate-900">Consejos para esta demo</p>
            <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-600">
                <li>Usa nombres simples y faciles de adaptar a cualquier rubro.</li>
                <li>Marca productos destacados para nutrir la landing y el catalogo.</li>
                <li>El orden de visualizacion ayuda a priorizar lo mas vendible.</li>
            </ul>
        </div>
    </div>
</div>
