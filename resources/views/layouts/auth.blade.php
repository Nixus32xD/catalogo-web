@extends('layouts.base')

@section('body')
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(15,118,110,0.08),_transparent_42%)]">
        <div class="container-shell flex min-h-screen flex-col justify-center py-10">
            <a href="{{ route('home') }}" class="mb-8 text-sm font-semibold text-slate-600 hover:text-slate-900">Volver al sitio publico</a>

            <div class="mx-auto w-full max-w-lg card-panel px-6 py-8 sm:px-8">
                <div class="mb-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.28em] text-slate-500">@yield('auth_kicker', 'Acceso')</p>
                    <h1 class="mt-2 text-3xl font-semibold text-slate-900">@yield('auth_title')</h1>
                    @hasSection('auth_intro')
                        <p class="mt-3 text-sm leading-6 text-slate-600">@yield('auth_intro')</p>
                    @endif
                </div>

                <x-flash-messages />
                <div class="mt-6">@yield('content')</div>
            </div>
        </div>
    </div>
@endsection
