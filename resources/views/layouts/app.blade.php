<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('faviconfr.svg') }}?v=1" type="image/svg+xml">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body>
        @yield('content', $slot ?? '')

        @livewireScripts
    </body>
</html>
