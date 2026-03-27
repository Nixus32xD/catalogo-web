@extends('layouts.admin')

@section('title', 'Mi perfil')
@section('admin_title', 'Mi perfil')
@section('admin_kicker', 'Cuenta')

@section('content')
    <div class="grid gap-6 xl:grid-cols-2">
        <section class="card-panel p-6">
            <h2 class="text-2xl font-semibold text-slate-900">Informacion personal</h2>
            <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="field-label">Nombre</label>
                    <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" class="field-input" required>
                    @error('name') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="field-label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" class="field-input" required>
                    @error('email') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                @if ($mustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                        Tu email aun no fue verificado.
                        <a href="{{ route('verification.notice') }}" class="font-semibold underline">Ir a verificacion</a>
                    </div>
                @endif

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">Guardar cambios</button>
                </div>
            </form>
        </section>

        <section class="card-panel p-6">
            <h2 class="text-2xl font-semibold text-slate-900">Actualizar contrasena</h2>
            <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="field-label">Contrasena actual</label>
                    <input id="current_password" name="current_password" type="password" class="field-input" required>
                    @error('current_password') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="field-label">Nueva contrasena</label>
                    <input id="password" name="password" type="password" class="field-input" required>
                    @error('password') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="field-label">Confirmar nueva contrasena</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="field-input" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">Actualizar contrasena</button>
                </div>
            </form>
        </section>
    </div>

    <section class="card-panel mt-6 p-6">
        <h2 class="text-2xl font-semibold text-slate-900">Eliminar cuenta</h2>
        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600">
            Esta accion elimina tu usuario de acceso. Si es una cuenta de demo o testing, asegurate de conservar otra cuenta administradora antes de continuar.
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6 flex flex-wrap items-end gap-4">
            @csrf
            @method('DELETE')

            <div class="min-w-[280px] flex-1">
                <label for="delete_password" class="field-label">Confirmar contrasena</label>
                <input id="delete_password" name="password" type="password" class="field-input" required>
                @error('password') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="rounded-full border border-rose-200 px-5 py-3 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">
                Eliminar cuenta
            </button>
        </form>
    </section>
@endsection
