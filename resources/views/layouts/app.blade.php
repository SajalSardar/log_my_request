<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="This website is about manage events.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Event Metro') }}</title>

    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <!-- Style css  !-->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/datatable/dataTables.dataTables.min.css') }}">
    @yield('style')
</head>

<!-- Sidenav start -->
@include('layouts.partials.sidebar')
<!-- Sidenav end -->

<main class="w-full bg-white md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">
    <!-- Navbar Start -->
    @include('layouts.partials.navbar')
    <!-- Navbar End -->
    <div class="pt-8 px-10">

        <!-- Breadcrumb Start -->
        @include('layouts.partials.breadcrumb')
        <!-- Breadcrumb End -->

        <div class=" mt-2">
            {{ $slot }}
        </div>
    </div>

</main>
@livewireScripts
{{-- <script src="https://unpkg.com/@popperjs/core@2"></script> --}}
<!-- <script src="{{ asset('assets/js/jquery-3.7.1.slim.min.js') }}"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="{{ asset('vendor/datatable/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

@yield('script')


</body>

</html>
