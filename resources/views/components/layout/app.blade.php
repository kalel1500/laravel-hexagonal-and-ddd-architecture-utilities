@use('Thehouseofel\Hexagonal\Infrastructure\Services\Renderer')
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

        <!-- Acceso a las rutas de laravel desde javascipt -->
        @routes

        @if($isFromPackage)
            <!-- JavaScript y CSS del paquete -->
            {!! Renderer::css() !!}
            {!! Renderer::js() !!}
        @else
            <!-- JavaScript y CSS compilados -->
            @if(file_exists(resource_path('js/app.ts')))
                @vite(['resources/css/app.css', 'resources/js/app.ts'])
            @else
                @vite(['resources/css/app.css', 'resources/js/app.js'])
            @endif
        @endif

        <!-- Icons -->
        <link rel="icon" href="@viteAsset('resources/images/favicon.ico')">
    </head>

    <body class="bg-gray-50 antialiased dark:bg-gray-900">

        <!-- Navbar -->
        <x-hexagonal::navbar.full/>
{{--        <x-hexagonal::navbar.full-old/>--}}

        <!-- Sidebar -->
        <x-hexagonal::sidebar.full/>

        <!-- Wrapper -->
        <div class="h-auto p-4 pt-20 md:ml-64 md:sc:ml-20 md:transition-all">

            <!-- Main -->
            @php($mainClass = config('hexagonal.blade_show_main_border') ? 'border-2 border-dashed border-gray-300 p-2 dark:border-gray-600' : null)
            <main class="{{ $mainClass }}">

                <!-- Page breadcrumb -->
                {{ $breadcrumb ?? '' }}

                <!-- Page mensajes -->
                <x-hexagonal::messages/>

                <!-- Page content -->
                {{ $slot }}

            </main>

            <!-- Footer -->
            <x-hexagonal::footer/>
        </div>

    </body>
</html>
