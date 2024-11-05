<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Event Metro') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{ asset('build/assets/app-RLrkd56A.css') }}">
    @livewireStyles
</head>

<body class="font-sans text-gray-900">
    <div class="lg:h-screen md:h-screen sm:h-screen sm:pt-0">
        {{ $slot }}
    </div>
    <script src="{{ asset('build/assets/app-DCrXoRMQ.js') }}"></script>
    @livewireScripts
    @stack('script')
</body>

</html>