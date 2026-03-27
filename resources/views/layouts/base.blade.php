@php
    $profile = $businessProfile ?? new \App\Models\BusinessProfile(\App\Models\BusinessProfile::defaultAttributes());
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            @hasSection('title')
                @yield('title') | {{ $profile->business_name }}
            @else
                {{ $profile->business_name }}
            @endif
        </title>
        <meta name="description" content="@yield('meta_description', $profile->short_description)">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=fraunces:600,700|manrope:400,500,600,700,800&display=swap" rel="stylesheet" />

        @unless (app()->runningUnitTests())
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endunless
        @stack('head')
    </head>
    <body
        class="@yield('body_class', 'bg-slate-50 text-slate-900')"
        style="--color-primary: {{ $profile->primary_color ?: '#0f766e' }}; --color-secondary: {{ $profile->secondary_color ?: '#f59e0b' }};"
    >
        @yield('body')
    </body>
</html>
