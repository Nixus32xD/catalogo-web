@extends('layouts.auth')

@section('title', 'Nueva contrasena')
@section('auth_title', 'Definir nueva contrasena')

@section('content')
    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="field-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $email) }}" required autofocus class="field-input">
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

        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Restablecer</button>
        </div>
    </form>
@endsection
