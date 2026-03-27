@extends('layouts.admin')

@section('title', 'Configuracion')
@section('admin_title', 'Configuracion del comercio')
@section('admin_kicker', 'Personalizacion')

@section('content')
    <form method="POST" action="{{ route('admin.business-profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-6">
                <div class="card-panel p-6">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="business_name" class="field-label">Nombre del comercio</label>
                            <input id="business_name" name="business_name" type="text" value="{{ old('business_name', $profile->business_name) }}" class="field-input" required>
                            @error('business_name') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="short_description" class="field-label">Descripcion breve del negocio</label>
                            <textarea id="short_description" name="short_description" class="field-textarea" required>{{ old('short_description', $profile->short_description) }}</textarea>
                            @error('short_description') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="welcome_text" class="field-label">Texto de bienvenida</label>
                            <textarea id="welcome_text" name="welcome_text" class="field-textarea" required>{{ old('welcome_text', $profile->welcome_text) }}</textarea>
                            @error('welcome_text') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="whatsapp_message" class="field-label">Mensaje de WhatsApp general</label>
                            <textarea id="whatsapp_message" name="whatsapp_message" class="field-textarea">{{ old('whatsapp_message', $profile->whatsapp_message) }}</textarea>
                            <p class="field-help">Se usa en botones generales de contacto. Placeholders: <code>{business_name}</code>, <code>{location_name}</code>, <code>{location_address}</code>.</p>
                            @error('whatsapp_message') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="product_inquiry_message" class="field-label">Mensaje para consultas de producto</label>
                            <textarea id="product_inquiry_message" name="product_inquiry_message" class="field-textarea">{{ old('product_inquiry_message', $profile->product_inquiry_message) }}</textarea>
                            <p class="field-help">Se usa en el boton "Consultar" de cada producto. Placeholders: <code>{business_name}</code>, <code>{product_name}</code>, <code>{product_price}</code>, <code>{category_name}</code>, <code>{location_name}</code>.</p>
                            @error('product_inquiry_message') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="field-label">Direccion del comercio</label>
                            <input id="address" name="address" type="text" value="{{ old('address', $profile->address) }}" class="field-input" required>
                            @error('address') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="whatsapp" class="field-label">WhatsApp</label>
                            <input id="whatsapp" name="whatsapp" type="text" value="{{ old('whatsapp', $profile->whatsapp) }}" class="field-input">
                            @error('whatsapp') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="phone" class="field-label">Telefono</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone', $profile->phone) }}" class="field-input">
                            @error('phone') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="field-label">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $profile->email) }}" class="field-input">
                            @error('email') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="business_hours" class="field-label">Horario de atencion</label>
                            <input id="business_hours" name="business_hours" type="text" value="{{ old('business_hours', $profile->business_hours) }}" class="field-input" required>
                            @error('business_hours') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="primary_color" class="field-label">Color principal</label>
                            <div class="mt-2 flex items-center gap-3">
                                <input id="primary_color" name="primary_color" type="color" value="{{ old('primary_color', $profile->primary_color) }}" class="h-12 w-16 rounded-2xl border border-slate-300 bg-white">
                                <input type="text" value="{{ old('primary_color', $profile->primary_color) }}" class="field-input mt-0" readonly>
                            </div>
                            @error('primary_color') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="secondary_color" class="field-label">Color secundario</label>
                            <div class="mt-2 flex items-center gap-3">
                                <input id="secondary_color" name="secondary_color" type="color" value="{{ old('secondary_color', $profile->secondary_color) }}" class="h-12 w-16 rounded-2xl border border-slate-300 bg-white">
                                <input type="text" value="{{ old('secondary_color', $profile->secondary_color) }}" class="field-input mt-0" readonly>
                            </div>
                            @error('secondary_color') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card-panel p-6">
                    <div class="flex items-center justify-between gap-3">
                        <p class="field-label">Ubicaciones y mapa</p>
                        <a href="{{ route('admin.locations.index') }}" class="btn-secondary">Editar sucursales</a>
                    </div>
                    <p class="field-help">Cada sucursal puede tener su direccion, horarios, contacto y mapa embebido propio.</p>
                </div>

                <div class="card-panel p-6">
                    <p class="field-label">Logo</p>
                    <input id="logo" name="logo" type="file" accept="image/*" class="field-input">
                    <label class="mt-4 inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                        <input type="hidden" name="remove_logo" value="0">
                        <input type="checkbox" name="remove_logo" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-0">
                        Quitar logo actual
                    </label>
                    @error('logo') <p class="field-help text-rose-600">{{ $message }}</p> @enderror

                    <div class="mt-5">
                        <x-media-placeholder :src="$profile->logo_url" label="Insertar logo aqui" class="aspect-square border-slate-200" />
                    </div>
                </div>

                <div class="card-panel p-6">
                    <p class="field-label">Imagen principal / portada / fachada</p>
                    <input id="hero_image" name="hero_image" type="file" accept="image/*" class="field-input">
                    <label class="mt-4 inline-flex items-center gap-3 text-sm font-medium text-slate-700">
                        <input type="hidden" name="remove_hero_image" value="0">
                        <input type="checkbox" name="remove_hero_image" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-0">
                        Quitar imagen actual
                    </label>
                    @error('hero_image') <p class="field-help text-rose-600">{{ $message }}</p> @enderror

                    <div class="mt-5">
                        <x-media-placeholder :src="$profile->hero_image_url" label="Insertar imagen del local aqui" class="aspect-[4/3] border-slate-200" />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Guardar configuracion</button>
        </div>
    </form>
@endsection
