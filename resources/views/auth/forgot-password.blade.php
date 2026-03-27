@extends('layouts.auth')

@section('title', 'Recuperar contrasena')
@section('auth_title', 'Recuperar contrasena')
@section('auth_intro', 'Ingresa tu email y te enviaremos un enlace para restablecer el acceso.')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="field-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="field-input">
            @error('email') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Enviar enlace</button>
        </div>
    </form>
@endsection
