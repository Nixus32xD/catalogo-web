@extends('layouts.auth')

@section('title', 'Confirmar contrasena')
@section('auth_title', 'Confirmar contrasena')
@section('auth_intro', 'Por seguridad, confirma tu contrasena antes de continuar.')

@section('content')
    <form method="POST" action="{{ url('/confirm-password') }}" class="space-y-5">
        @csrf

        <div>
            <label for="password" class="field-label">Contrasena</label>
            <input id="password" name="password" type="password" required autofocus class="field-input">
            @error('password') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Confirmar</button>
        </div>
    </form>
@endsection
