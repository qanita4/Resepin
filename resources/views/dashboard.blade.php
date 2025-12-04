<x-app-layout>
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Search Section -->
        <div class="mb-8">
            <x-search-bar
                :action="route('dashboard')"
                name="q"
                :value="$searchQuery"
                placeholder="Cari resep favorit kamu..."
            />
        </div>

        <!-- Welcome Section -->
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="mb-2 text-3xl font-bold text-gray-900">
                    Selamat Datang di Resepin! 👋
                </h1>
                <p class="text-lg text-gray-600">
                    Temukan resep-resep terbaik dari chef berpengalaman
                </p>
            </div>
            <a
                href="{{ route('recipes.create') }}"
                class="flex items-center gap-2 rounded-lg bg-resepin-tomato px-6 py-3 font-medium text-white shadow-md transition hover:brightness-95"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Resep
            </a>
        </div>

        <!-- Recipes Grid -->
        <div class="mb-8">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-2xl font-bold text-gray-900">
                    Resep Populer
                </h2>
                <a
                    href="#"
                    class="inline-flex items-center rounded-lg border-2 border-resepin-green px-4 py-2 font-medium text-resepin-green transition hover:bg-resepin-green/10"
                >
                    Lihat Semua
                </a>
            </div>

            @if ($recipes->isEmpty())
                <div class="rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-gray-500">
                    Resep tidak ditemukan. Coba kata kunci lainnya.
                </div>
            @else
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($recipes as $recipe)
                        <x-recipe-card
                            class="shadow-md hover:shadow-lg"
                            :image="$recipe->image"
                            :title="$recipe->title"
                            :chef="$recipe->chef"
                            :href="route('recipes.show', $recipe->slug)"
                        >
                            <x-slot:meta>
                                <x-like-button
                                    :recipe="$recipe"
                                    :likes-count="$recipe->likes_count ?? 0"
                                    :is-liked="$recipe->is_liked"
                                />
                            </x-slot:meta>
                        </x-recipe-card>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</x-app-layout>
