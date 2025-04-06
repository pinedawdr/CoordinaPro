<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
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
    
    <!-- Additional Styles -->
    @stack('styles')
    @yield('styles')
</head>
<body class="font-sans antialiased h-full">
    <div class="min-h-screen flex flex-col bg-gradient-to-br from-neutral-50 to-neutral-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow-sm border-b border-neutral-100">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow py-6">
            <div class="container">
                @isset($slot)
                    <div class="animate-fade-in">
                        {{ $slot }}
                    </div>
                @else
                    <div class="animate-fade-in">
                        @yield('content')
                    </div>
                @endisset
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="py-4 text-center text-sm text-neutral-500 border-t border-neutral-200 mt-auto">
            <div class="container">
                &copy; {{ date('Y') }} {{ config('app.name', 'CoordinaPro') }} | Todos los derechos reservados
            </div>
        </footer>
    </div>
    
    <!-- Additional Scripts -->
    @stack('scripts')
    @yield('scripts')
</body>
</html>
