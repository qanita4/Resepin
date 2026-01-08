<x-app-layout>
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Hero Title -->
        <div class="mb-6 text-center">
            {{-- <h1 class="text-8xl font-extrabold tracking-tight text-resepin-tomato sm:text-5xl"> --}}
            <h1 class="text-8xl tracking-tight text-resepin-tomato sm:text-5xl super-bold">
                RESEPIN
            </h1>
            <p class="mt-2 text-lg text-gray-600">
                Temukan & Bagikan Resep Favoritmu
            </p>
        </div>

        <!-- Search Section -->
        <div class="mb-8">
            <x-search-bar
                :action="route('dashboard')"
                name="q"
                :value="$searchQuery"
                placeholder="Cari resep favorit kamu..."
            />
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Recipes Grid -->
        <div class="mb-8">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-2xl font-bold text-gray-900">
                    @if ($currentFilter === 'my')
                        <span class="flex items-center gap-2">
                            📖 Resep Saya
                        </span>
                    @elseif (!empty($currentKategori))
                        <span class="flex items-center gap-2">
                            @switch($currentKategori)
                                @case('sarapan')
                                    🌅 Sarapan
                                    @break
                                @case('makan-siang')
                                    ☀️ Makan Siang
                                    @break
                                @case('makan-malam')
                                    🌙 Makan Malam
                                    @break
                                @case('minuman')
                                    🥤 Minuman
                                    @break
                                @case('camilan')
                                    🍿 Camilan
                                    @break
                                @case('dessert')
                                    🍰 Dessert
                                    @break
                            @endswitch
                        </span>
                    @elseif ($searchQuery)
                        Hasil Pencarian "{{ $searchQuery }}"
                    @else
                        <span class="flex items-center gap-2">
                            🔥 Resep Populer
                        </span>
                    @endif
                </h2>
                <span class="text-gray-500">{{ $recipes->count() }} resep</span>
            </div>

            @if ($recipes->isEmpty())
                <div class="rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-gray-500">
                    @if ($currentFilter === 'my')
                        Anda belum memiliki resep. <a href="{{ route('recipes.create') }}" class="text-resepin-green hover:underline">Tambah resep pertama Anda!</a>
                    @elseif (!empty($currentKategori))
                        Belum ada resep untuk kategori ini. <a href="{{ route('recipes.create') }}" class="text-resepin-green hover:underline">Tambah resep!</a>
                    @elseif ($searchQuery)
                        Resep tidak ditemukan. Coba kata kunci lainnya.
                    @else
                        Belum ada resep populer. Jadilah yang pertama menambah resep!
                    @endif
                </div>
            @else
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3" dusk="popular-recipes">
                    @foreach ($recipes as $recipe)
                        <x-recipe-card
                            class="shadow-md hover:shadow-lg"
                            :image="$recipe->image"
                            :title="$recipe->title"
                            :chef="$recipe->chef"
                            :href="route('recipes.show', $recipe->slug)"
                            :dusk="'popular-card-' . $recipe->id"
                        >
                            <x-slot:meta>
                                <div class="flex items-center gap-3">
                                    <x-like-button
                                        :recipe="$recipe"
                                        :likes-count="$recipe->likes_count ?? 0"
                                        :is-liked="$recipe->is_liked"
                                    />
                                    @if ($currentFilter === 'my' || (Auth::check() && $recipe->user_id === Auth::id()))
                                        <a href="{{ route('recipes.edit', $recipe) }}" class="text-gray-400 hover:text-resepin-green" title="Edit">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </x-slot:meta>
                        </x-recipe-card>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Resep Terbaru -->
        @if ($latestRecipes->isNotEmpty())
            <div class="mb-8">
                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">
                        <span class="flex items-center gap-2">
                            ✨ Resep Terbaru
                        </span>
                    </h2>
                    <span class="text-gray-500">{{ $latestRecipes->count() }} resep</span>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($latestRecipes as $recipe)
                        <x-recipe-card
                            class="shadow-md hover:shadow-lg"
                            :image="$recipe->image"
                            :title="$recipe->title"
                            :chef="$recipe->chef"
                            :href="route('recipes.show', $recipe->slug)"
                        >
                            <x-slot:meta>
                                <div class="flex items-center gap-3">
                                    <x-like-button
                                        :recipe="$recipe"
                                        :likes-count="$recipe->likes_count ?? 0"
                                        :is-liked="$recipe->is_liked"
                                    />
                                    <span class="text-xs text-gray-400">{{ $recipe->created_at->diffForHumans() }}</span>
                                </div>
                            </x-slot:meta>
                        </x-recipe-card>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Button Lihat Semua (hanya di dashboard utama) -->
        @if (empty($currentFilter) && empty($currentKategori) && empty($searchQuery))
            <div class="mt-8 text-center">
                <x-button 
                    variant="primary" 
                    size="lg" 
                    href="{{ route('recipes.all') }}"
                    :icon="'<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M17 8l4 4m0 0l-4 4m4-4H3\' />'"
                >
                    Lihat Semua
                </x-button>
            </div>
        @endif
    </main>
</x-app-layout>
