<x-app-layout>
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="mb-4 inline-flex items-center text-resepin-green hover:underline">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Semua Resep</h1>
            <p class="mt-2 text-gray-600">Jelajahi semua resep yang tersedia di Resepin</p>
        </div>

        <!-- Search Section -->
        <div class="mb-8">
            <x-search-bar
                :action="route('recipes.all')"
                name="q"
                :value="$searchQuery"
                placeholder="Cari resep..."
            />
        </div>

        <!-- Recipes Info -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold text-gray-900">
                @if ($searchQuery)
                    Hasil Pencarian "{{ $searchQuery }}"
                @else
                    📚 Semua Resep
                @endif
            </h2>
            <span class="text-gray-500">{{ $recipes->total() }} resep</span>
        </div>

        <!-- Recipes Grid -->
        @if ($recipes->isEmpty())
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-gray-500">
                @if ($searchQuery)
                    Resep tidak ditemukan. Coba kata kunci lainnya.
                @else
                    Belum ada resep. <a href="{{ route('recipes.create') }}" class="text-resepin-green hover:underline">Tambah resep pertama!</a>
                @endif
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

            <!-- Pagination -->
            <div class="mt-8">
                {{ $recipes->withQueryString()->links('vendor.pagination.resepin') }}
            </div>
        @endif
    </main>
</x-app-layout>
