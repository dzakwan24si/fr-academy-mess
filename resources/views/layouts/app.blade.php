<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('faviconfr.svg') }}?v=1" type="image/svg+xml">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- TomSelect CSS & JS -->
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

        @livewireStyles
    </head>
    <body>
        @yield('content', $slot ?? '')

        @livewireScripts
        @stack('scripts')
    </body>
</html>
