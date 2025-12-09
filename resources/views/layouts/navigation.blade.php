<nav x-data="{ open: false }" class="bg-white border-b border-resepin-tomato/20 backdrop-blur">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-resepin-tomato" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') && !request()->has('filter') && !request()->has('kategori')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Kategori Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                            {{ __('Kategori') }}
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                <a href="{{ route('dashboard', ['kategori' => 'sarapan']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    🌅 Sarapan
                                </a>
                                <a href="{{ route('dashboard', ['kategori' => 'makan-siang']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    ☀️ Makan Siang
                                </a>
                                <a href="{{ route('dashboard', ['kategori' => 'makan-malam']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    🌙 Makan Malam
                                </a>
                                <a href="{{ route('dashboard', ['kategori' => 'minuman']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    🥤 Minuman
                                </a>
                                <a href="{{ route('dashboard', ['kategori' => 'camilan']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    🍿 Camilan
                                </a>
                                <a href="{{ route('dashboard', ['kategori' => 'dessert']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    🍰 Dessert
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Profile + Tambah Resep -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:gap-4">
                @auth
                    <!-- Profile Dropdown -->
                    <x-dropdown align="right" width="48" class="relative">
                        <x-slot name="trigger">
                            <button aria-haspopup="true" aria-expanded="false" aria-label="Open user menu" class="relative inline-flex items-center p-0.5 rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-resepin-tomato">
                                <span class="sr-only">Open user menu</span>
                                <img
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="{{ Auth::user()->name }} avatar"
                                    width="32"
                                    height="32"
                                    class="rounded-full object-cover"
                                    style="width: 32px; height: 32px;"
                                />
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('dashboard', ['filter' => 'my'])">
                                {{ __('Resep Saya') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                    <!-- Tambah Resep Button -->
                    <a href="{{ route('recipes.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-resepin-tomato px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:brightness-95">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Resep
                    </a>
                @else
                    <div>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg bg-resepin-tomato px-4 py-2 text-sm font-medium text-white">Masuk?</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-resepin-tomato/80 hover:text-resepin-tomato hover:bg-resepin-cream/70 focus:outline-none focus:bg-resepin-cream/80 focus:text-resepin-tomato transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-resepin-cream/90">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') && !request()->has('filter') && !request()->has('kategori')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Kategori Section -->
            <div class="px-4 py-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Kategori</span>
            </div>
            <x-responsive-nav-link :href="route('dashboard', ['kategori' => 'sarapan'])">
                🌅 {{ __('Sarapan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard', ['kategori' => 'makan-siang'])">
                ☀️ {{ __('Makan Siang') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard', ['kategori' => 'makan-malam'])">
                🌙 {{ __('Makan Malam') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard', ['kategori' => 'minuman'])">
                🥤 {{ __('Minuman') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard', ['kategori' => 'camilan'])">
                🍿 {{ __('Camilan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard', ['kategori' => 'dessert'])">
                🍰 {{ __('Dessert') }}
            </x-responsive-nav-link>

            <!-- Tambah Resep -->
            <div class="px-4 pt-2">
                <a href="{{ route('recipes.create') }}" class="flex items-center justify-center gap-2 rounded-lg bg-resepin-tomato px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:brightness-95">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Resep
                </a>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-resepin-tomato/20">
            <div class="px-4">
                @auth
                    <div class="font-medium text-sm text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                @else
                    <div>
                        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 rounded-lg bg-resepin-tomato px-4 py-2 text-sm font-medium text-white">Masuk?</a>
                    </div>
                @endauth
            </div>

            <div class="mt-3 space-y-1">
                @auth
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('dashboard', ['filter' => 'my'])">
                        {{ __('Resep Saya') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
