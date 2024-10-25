<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if($sidebarCollapsed) class="sc" @endif>
    <head>
        <!-- Meta tags -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @env('local')<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">@endenv
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        <!-- JavaScript y CSS compilados -->
        @vite(['resources/css/app.css', 'resources/js/app.ts'])

        {{-- Acceso a las rutas de laravel desde javascipt --}}
        @routes

        <!-- Icons -->
        <link rel="icon" href="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/favicon.ico') }}">
    </head>

    <body class="bg-gray-50 antialiased dark:bg-gray-900">

        <!-- Navbar -->
        <x-navbar.full/>
{{--        <x-navbar.full-old/>--}}

        <!-- Sidebar -->
        <x-sidebar.full/>

        <!-- Wrapper -->
        <div class="h-auto p-4 pt-20 md:ml-64 md:sc:ml-20 md:transition-all">

            <!-- Main -->
            @php($mainClass = config('hexagonal.blade_show_main_border') ? 'border-2 border-dashed border-gray-300 p-2 dark:border-gray-600' : null)
            <main class="{{ $mainClass }}">

                <!-- Page breadcrumb -->
                {{ $breadcrumb ?? '' }}

                <!-- Page mensajes -->
                <x-messages/>

                <!-- Page content -->
                {{ $slot }}

            </main>

            <!-- Footer -->
            <x-footer/>
        </div>

    </body>
</html>
