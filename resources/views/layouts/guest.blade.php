<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CoordinaPro') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-neutral-900 antialiased bg-gradient-to-br from-neutral-50 to-neutral-100/80">
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-10 sm:py-0 px-4 sm:px-6">
            <div class="w-full sm:max-w-md mb-8">
                <div class="flex justify-center">
                    <a href="/" class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-primary-500 text-white rounded-full flex items-center justify-center mb-4 shadow-lg">
                            <i class="fa-solid fa-calendar-check text-3xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-primary-600 text-center">
                            {{ config('app.name', 'CoordinaPro') }}
                        </span>
                    </a>
                </div>
            </div>

            <div class="w-full sm:max-w-md">
                <div class="bg-white shadow-xl rounded-xl border border-neutral-200/60 overflow-hidden backdrop-blur-sm backdrop-filter">
                    {{ $slot }}
                </div>
                
                <div class="mt-8 text-center text-sm text-neutral-500">
                    &copy; {{ date('Y') }} {{ config('app.name', 'CoordinaPro') }} | Todos los derechos reservados
                </div>
            </div>
        </div>
    </body>
</html>