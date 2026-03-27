@extends('layouts.auth')

@section('title', 'Ingresar')
@section('auth_title', 'Ingresar al panel')
@section('auth_intro', 'Accede al panel admin para editar la demo, cargar productos y personalizar el comercio.')

@section('content')
    <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
        Demo lista para usar: <span class="font-semibold text-slate-900">admin@demo.local</span> / <span class="font-semibold text-slate-900">password</span>
    </div>

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <label for="email" class="field-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="field-input">
            @error('email') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="field-label">Contrasena</label>
            <input id="password" name="password" type="password" required class="field-input">
            @error('password') <p class="field-help text-rose-600">{{ $message }}</p> @enderror
        </div>

        <label class="inline-flex items-center gap-3 text-sm text-slate-700">
            <input id="remember" name="remember" type="checkbox" class="rounded border-slate-300 text-slate-900 focus:ring-0">
            Recordarme
        </label>

        <div class="flex flex-wrap items-center justify-between gap-3">
            @if ($canResetPassword)
                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-brand">Olvide mi contrasena</a>
            @endif
            <button type="submit" class="btn-primary">Ingresar</button>
        </div>
    </form>
@endsection
