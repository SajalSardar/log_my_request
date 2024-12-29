<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-Df1BPbl3.css') }}">
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