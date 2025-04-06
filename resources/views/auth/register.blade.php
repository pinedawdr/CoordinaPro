<x-guest-layout>
    <div class="p-6 sm:p-8">
        <h1 class="text-2xl font-bold text-center text-neutral-900 mb-6">Crear Cuenta</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nombre')" class="block text-sm font-medium text-neutral-800" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                        <i class="bi bi-person"></i>
                    </div>
                    <x-text-input id="name" class="block w-full pl-10 rounded-xl border-neutral-200 shadow-sm focus:border-primary-400 focus:ring focus:ring-primary-200/50" 
                        type="text" 
                        name="name" 
                        :value="old('name')" 
                        required 
                        autofocus 
                        autocomplete="name" 
                        placeholder="Tu nombre" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-danger-600" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
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
                        autocomplete="username" 
                        placeholder="tu@email.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-danger-600" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" class="block text-sm font-medium text-neutral-800" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                        <i class="bi bi-lock"></i>
                    </div>
                    <x-text-input id="password" class="block w-full pl-10 rounded-xl border-neutral-200 shadow-sm focus:border-primary-400 focus:ring focus:ring-primary-200/50"
                                    type="password"
                                    name="password"
                                    required 
                                    autocomplete="new-password"
                                    placeholder="Mínimo 8 caracteres" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-danger-600" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="block text-sm font-medium text-neutral-800" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                        <i class="bi bi-lock-fill"></i>
                    </div>
                    <x-text-input id="password_confirmation" class="block w-full pl-10 rounded-xl border-neutral-200 shadow-sm focus:border-primary-400 focus:ring focus:ring-primary-200/50"
                                    type="password"
                                    name="password_confirmation"
                                    required 
                                    autocomplete="new-password"
                                    placeholder="Repite tu contraseña" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-danger-600" />
            </div>

            <div class="mt-6 flex flex-col gap-3">
                <x-primary-button class="w-full justify-center py-3">
                    {{ __('Registrarse') }}
                </x-primary-button>

                <div class="text-center text-sm text-neutral-600">
                    {{ __('¿Ya tienes una cuenta?') }}
                    <a class="text-sm text-primary-600 hover:text-primary-800 font-medium" href="{{ route('login') }}">
                        {{ __('Inicia sesión') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
