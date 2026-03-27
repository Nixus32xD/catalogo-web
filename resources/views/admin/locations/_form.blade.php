@php
    $mapEmbedUrl = old('map_embed_url', $location->map_embed_url);
@endphp

<div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
    <div class="space-y-6">
        <div class="card-panel p-6">
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="field-label">Nombre de la sucursal</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $location->name) }}" class="field-input" required>
                    @error('name') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="field-label">Direccion</label>
                    <input id="address" name="address" type="text" value="{{ old('address', $location->address) }}" class="field-input" required>
                    @error('address') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="whatsapp" class="field-label">WhatsApp</label>
                    <input id="whatsapp" name="whatsapp" type="text" value="{{ old('whatsapp', $location->whatsapp) }}" class="field-input">
                    @error('whatsapp') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="field-label">Telefono</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $location->phone) }}" class="field-input">
                    @error('phone') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="field-label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $location->email) }}" class="field-input">
                    @error('email') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="business_hours" class="field-label">Horario de atencion</label>
                    <input id="business_hours" name="business_hours" type="text" value="{{ old('business_hours', $location->business_hours) }}" class="field-input">
                    @error('business_hours') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="map_embed_url" class="field-label">URL del mapa embebido</label>
                    <input id="map_embed_url" name="map_embed_url" type="url" value="{{ $mapEmbedUrl }}" class="field-input" placeholder="https://www.google.com/maps?q=...&output=embed">
                    <p class="field-help">Pega una URL embebible de Google Maps, Maps o un proveedor similar para mostrar el mapa dentro del sitio.</p>
                    @error('map_embed_url') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="maps_url" class="field-label">Link externo al mapa</label>
                    <input id="maps_url" name="maps_url" type="url" value="{{ old('maps_url', $location->maps_url) }}" class="field-input" placeholder="https://maps.google.com/...">
                    <p class="field-help">Se usa para el boton "Ver mapa" o "Abrir ubicacion".</p>
                    @error('maps_url') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="notes" class="field-label">Notas internas o texto visible</label>
                    <textarea id="notes" name="notes" class="field-textarea">{{ old('notes', $location->notes) }}</textarea>
                    <p class="field-help">Sirve para aclarar si la sucursal es deposito, showroom, pickup o cualquier detalle comercial.</p>
                    @error('notes') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sort_order" class="field-label">Orden de visualizacion</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $location->sort_order ?? 0) }}" class="field-input">
                    @error('sort_order') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-wrap items-center gap-6 pt-8">
                    <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-0" @checked(old('is_active', $location->is_active))>
                        Sucursal activa
                    </label>

                    <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                        <input type="hidden" name="is_primary" value="0">
                        <input type="checkbox" name="is_primary" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-0" @checked(old('is_primary', $location->is_primary))>
                        Marcar como principal
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="card-panel p-6">
            <p class="text-sm font-semibold text-slate-900">Vista previa del mapa</p>
            <p class="mt-2 text-sm leading-6 text-slate-600">Si cargas una URL embebida valida, se mostrara en la landing y en la pagina de contacto.</p>

            <div class="mt-5">
                @if ($mapEmbedUrl)
                    <div class="overflow-hidden rounded-[1.75rem] border border-slate-200">
                        <iframe
                            src="{{ $mapEmbedUrl }}"
                            class="aspect-[4/3] h-full w-full"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen
                        ></iframe>
                    </div>
                @else
                    <x-media-placeholder label="Insertar mapa embebido aqui" class="aspect-[4/3] border-slate-200" />
                @endif
            </div>
        </div>

        <div class="card-panel p-6">
            <p class="text-sm font-semibold text-slate-900">Buenas practicas</p>
            <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-600">
                <li>Deja una sola sucursal principal para que el sitio tenga un punto de referencia claro.</li>
                <li>Usa un link externo al mapa para abrir Google Maps o Waze desde el celular.</li>
                <li>Podes crear varias sucursales y ordenarlas segun prioridad comercial.</li>
            </ul>
        </div>
    </div>
</div>
