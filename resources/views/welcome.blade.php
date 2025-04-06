<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CoordinaPro</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-neutral-50 to-neutral-100 text-neutral-800 flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/home') }}"
                            class="inline-block px-5 py-1.5 bg-primary-600 hover:bg-primary-700 text-white border border-transparent rounded-lg text-sm leading-normal shadow-sm transition-colors"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 text-neutral-700 border-neutral-200 hover:border-neutral-300 border bg-white hover:bg-neutral-50 rounded-lg text-sm leading-normal shadow-sm transition-colors"
                        >
                            Iniciar sesión
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 bg-primary-600 hover:bg-primary-700 text-white border border-transparent rounded-lg text-sm leading-normal shadow-sm transition-colors">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        
        <!-- Resto del contenido de bienvenida -->
        <div class="flex flex-col items-center justify-center w-full max-w-4xl">
            <div class="flex items-center flex-col mb-8">
                <div class="w-24 h-24 bg-primary-600 text-white rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class="fa-solid fa-calendar-check text-4xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-primary-600">CoordinaPro</h1>
                <p class="text-xl text-neutral-600 mt-2">Sistema de coordinación y gestión de actividades</p>
            </div>
            
            <div class="w-full max-w-3xl bg-white rounded-2xl shadow-card border border-neutral-100/50 p-8">
                <div class="text-center">
                    <h2 class="text-2xl font-semibold text-neutral-800 mb-4">Bienvenido a CoordinaPro</h2>
                    <p class="text-neutral-600 mb-6">Optimiza la coordinación de actividades y mejora la gestión de tu equipo con nuestra plataforma intuitiva y eficiente.</p>
                    
                    <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
                        @auth
                            <a href="{{ url('/home') }}" class="btn btn-primary">
                                <i class="bi bi-speedometer2 mr-2"></i>
                                Ir al Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right mr-2"></i>
                                Iniciar Sesión
                            </a>
                            
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline border-primary-300 text-primary-600">
                                    <i class="bi bi-person-plus mr-2"></i>
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            
            <footer class="mt-8 text-sm text-neutral-500 text-center">
                &copy; {{ date('Y') }} CoordinaPro | Todos los derechos reservados
            </footer>
        </div>
    </body>
</html>
