<div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
    <div class="card-panel p-6">
        <div class="grid gap-5">
            <div>
                <label for="name" class="field-label">Nombre de la categoria</label>
                <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" class="field-input" required>
                @error('name') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="field-label">Descripcion breve</label>
                <textarea id="description" name="description" class="field-textarea">{{ old('description', $category->description) }}</textarea>
                @error('description') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="sort_order" class="field-label">Orden</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="field-input">
                    @error('sort_order') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center pt-8">
                    <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-0" @checked(old('is_active', $category->is_active))>
                        Categoria activa
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card-panel p-6">
        <p class="text-sm font-semibold text-slate-900">Sugerencias</p>
        <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-600">
            <li>Mantene nombres claros y faciles de entender desde el catalogo publico.</li>
            <li>Usa el orden para decidir que categoria aparece primero.</li>
            <li>Podes desactivar una categoria sin borrar productos historicos.</li>
        </ul>
    </div>
</div>
