@extends('layouts.auth')

@section('title', 'Registro')
@section('auth_title', 'Crear cuenta')
@section('auth_intro', 'Podes registrar un usuario administrador adicional para seguir usando esta demo como base comercial.')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="field-label">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="field-input">
            @error('name') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="field-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="field-input">
            @error('email') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="field-label">Contrasena</label>
            <input id="password" name="password" type="password" required class="field-input">
            @error('password') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="field-label">Confirmar contrasena</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="field-input">
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-brand">Ya tengo cuenta</a>
            <button type="submit" class="btn-primary">Crear cuenta</button>
        </div>
    </form>
@endsection
