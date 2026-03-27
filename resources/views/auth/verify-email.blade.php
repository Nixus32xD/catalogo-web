@extends('layouts.auth')

@section('title', 'Verificar email')
@section('auth_title', 'Verificar email')
@section('auth_intro', 'Gracias por registrarte. Revisa tu correo y luego volve a este panel cuando confirmes tu direccion.')

@section('content')
    <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
        @csrf
        <button type="submit" class="btn-primary w-full">Reenviar enlace de verificacion</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="btn-secondary w-full">Cerrar sesion</button>
    </form>
@endsection
