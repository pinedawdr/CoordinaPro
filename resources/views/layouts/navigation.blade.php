<nav x-data="{ open: false }" class="bg-white border-b border-neutral-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <div class="w-10 h-10 bg-primary-600 text-white rounded-full flex items-center justify-center mr-2 shadow-sm">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <span class="text-xl font-bold text-primary-600 hover:text-primary-700 transition">
                            {{ config('app.name', 'CoordinaPro') }}
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="flex items-center">
                        <i class="bi bi-house-door mr-2"></i>
                        {{ __('Inicio') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('activities.index')" :active="request()->routeIs('activities.index')" class="flex items-center">
                        <i class="bi bi-list-check mr-2"></i>
                        {{ __('Actividades') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('activities.calendar')" :active="request()->routeIs('activities.calendar')" class="flex items-center">
                        <i class="bi bi-calendar-event mr-2"></i>
                        {{ __('Calendario') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-neutral-600 bg-white hover:text-neutral-800 hover:bg-neutral-50 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user() ? Auth::user()->name : 'Usuario' }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                            <i class="bi bi-person mr-2"></i>
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="flex items-center">
                                <i class="bi bi-box-arrow-right mr-2"></i>
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 focus:outline-none focus:bg-neutral-100 focus:text-neutral-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                <i class="bi bi-house-door mr-2"></i>
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('activities.index')" :active="request()->routeIs('activities.index')">
                <i class="bi bi-list-check mr-2"></i>
                {{ __('Actividades') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('activities.calendar')" :active="request()->routeIs('activities.calendar')">
                <i class="bi bi-calendar-event mr-2"></i>
                {{ __('Calendario') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-neutral-200">
            <div class="px-4">
                <div class="font-medium text-base text-neutral-800">{{ Auth::user() ? Auth::user()->name : 'Usuario' }}</div>
                <div class="font-medium text-sm text-neutral-500">{{ Auth::user() ? Auth::user()->email : '' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="bi bi-person mr-2"></i>
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="bi bi-box-arrow-right mr-2"></i>
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
