<x-guest-layout>
    <div class="p-6 sm:p-8">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <h1 class="text-2xl font-bold text-center text-neutral-900 mb-6">Iniciar Sesión</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-neutral-800" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <x-text-input id="email" class="block w-full pl-10 rounded-xl border-neutral-200 shadow-sm focus:border-primary-400 focus:ring focus:ring-primary-200/50" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" 
                        placeholder="tu@email.com"/>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-danger-600" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <x-input-label for="password" :value="__('Contraseña')" class="block text-sm font-medium text-neutral-800" />
                    @if (Route::has('password.request'))
                        <a class="text-sm text-primary-600 hover:text-primary-800 font-medium" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif
                </div>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                        <i class="bi bi-lock"></i>
                    </div>
                    <x-text-input id="password" class="block w-full pl-10 rounded-xl border-neutral-200 shadow-sm focus:border-primary-400 focus:ring focus:ring-primary-200/50"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password"
                                    placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-danger-600" />
            </div>

            <!-- Remember Me -->
            <div class="mt-4 flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-neutral-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200/50 focus:ring-opacity-50" name="remember">
                <label for="remember_me" class="ml-2 text-sm text-neutral-600">
                    {{ __('Recordarme') }}
                </label>
            </div>

            <div class="mt-6 flex flex-col gap-3">
                <x-primary-button class="w-full justify-center py-3">
                    {{ __('Iniciar Sesión') }}
                </x-primary-button>
                
                @if (Route::has('register'))
                    <div class="text-center text-sm text-neutral-600">
                        {{ __('¿No tienes una cuenta?') }}
                        <a class="text-sm text-primary-600 hover:text-primary-800 font-medium" href="{{ route('register') }}">
                            {{ __('Regístrate') }}
                        </a>
                    </div>
                @endif
            </div>
        </form>
    </div>
</x-guest-layout>
