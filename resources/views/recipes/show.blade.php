<x-app-layout>
    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        <a
            href="{{ route('dashboard') }}"
            class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-resepin-tomato transition hover:text-resepin-tomato/80"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Dashboard
        </a>

        <article class="overflow-hidden rounded-3xl bg-white shadow-sm">
            <div class="grid gap-0 md:grid-cols-[1.25fr_1fr]">
                <div class="relative overflow-hidden rounded-t-3xl md:rounded-none md:rounded-l-3xl">
                    <div class="h-60 md:h-auto md:aspect-[4/3]">
                        <img
                            src="{{ $recipe->image }}"
                            alt="Foto {{ $recipe->title }}"
                            class="h-full w-full object-cover"
                        />
                    </div>

                    @if (! empty($recipe->badge))
                        <span class="absolute left-4 top-4 inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-resepin-tomato shadow">
                            {{ $recipe->badge }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col gap-6 p-6 sm:p-8">
                    <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500">
                        <div class="flex items-center gap-4">
                            <span class="inline-flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.28 0 4-1.79 4-4s-1.72-4-4-4-4 1.79-4 4 1.72 4 4 4zM6 20v-.67C6 17.5 8.24 16 12 16s6 .5 6 3.33V20" />
                                </svg>
                                {{ $recipe->chef }}
                            </span>
                        </div>
                        <x-like-button
                            variant="large"
                            :recipe="$recipe"
                            :likes-count="$recipe->likes_count ?? 0"
                            :is-liked="$recipe->is_liked"
                        />
                    </div>

                    <div>
                        <h1 class="mb-3 text-3xl font-bold text-gray-900">{{ $recipe->title }}</h1>
                        <p class="text-gray-600">{{ $recipe->description }}</p>
                    </div>

                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="rounded-xl bg-resepin-cream/70 p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Durasi</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $recipe->duration }}</dd>
                        </div>
                        <div class="rounded-xl bg-resepin-cream/70 p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Porsi</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $recipe->servings }}</dd>
                        </div>
                        <div class="rounded-xl bg-resepin-cream/70 p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">Kesulitan</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $recipe->difficulty }}</dd>
                        </div>
                    </dl>

                    <x-recipe-button href="#steps">Mulai Masak</x-recipe-button>
                </div>
            </div>
        </article>

        <section id="ingredients" class="mt-10 rounded-3xl bg-white p-8 shadow-sm">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-gray-900">Bahan-Bahan</h2>
                <span class="text-sm font-medium text-gray-500">Siapkan semuanya dulu, ya!</span>
            </div>

            <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach ($recipe->ingredients ?? [] as $ingredient)
                    <li class="flex items-start gap-3 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
                        <span class="mt-2 inline-flex h-2.5 w-2.5 rounded-full bg-resepin-tomato"></span>
                        <span class="text-gray-700">{{ $ingredient }}</span>
                    </li>
                @endforeach
            </ul>
        </section>

        <section id="steps" class="mt-10 rounded-3xl bg-white p-8 shadow-sm">
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-900">Langkah Memasak</h2>
                <p class="text-gray-500">Ikuti langkah-langkah berikut untuk hasil terbaik.</p>
            </div>

            <ol class="space-y-4">
                @foreach (($recipe->steps ?? []) as $index => $step)
                    <li class="flex gap-4 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                        <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-resepin-tomato text-lg font-semibold text-white">{{ $index + 1 }}</span>
                        <p class="text-gray-700">{{ $step }}</p>
                    </li>
                @endforeach
            </ol>
        </section>

        <section id="comments" class="mt-10 rounded-3xl bg-white p-8 shadow-sm">
            <div class="mb-8 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900">Komentar Resep</h2>
                    <p class="text-gray-500">Bagikan tips atau pengalamanmu memasak resep ini.</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-resepin-cream px-3 py-1 text-sm font-semibold text-resepin-tomato">
                    {{ \Illuminate\Support\Str::plural('Komentar', $recipe->comments->count()) }} · {{ $recipe->comments->count() }}
                </span>
            </div>

            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form
                method="POST"
                action="{{ route('recipes.comments.store', $recipe) }}"
                class="mb-10 space-y-4"
            >
                @csrf

                <div class="space-y-2">
                    <label for="comment" class="text-sm font-semibold text-gray-700">Tinggalkan Komentar</label>
                    <textarea
                        id="comment"
                        name="comment"
                        rows="4"
                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-gray-700 shadow-sm transition focus:border-resepin-tomato focus:ring-2 focus:ring-resepin-tomato/30"
                        placeholder="Ceritakan hasil masakanmu atau beri tips tambahan..."
                    >{{ old('comment') }}</textarea>
                    <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button class="inline-flex items-center gap-2 rounded-xl px-6 py-3 text-sm">
                        Kirim Komentar
                    </x-primary-button>
                </div>
            </form>

            <div class="space-y-6">
                @forelse ($recipe->comments as $comment)
                    <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">{{ $comment->user->name ?? 'Pengguna Resepin' }}</h3>
                                <p class="text-xs text-gray-500">{{ $comment->created_at?->diffForHumans() }}</p>
                            </div>

                            @if ($comment->user_id === auth()->id())
                                <form
                                    method="POST"
                                    action="{{ route('recipes.comments.destroy', [$recipe, $comment]) }}"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button class="rounded-xl px-3 py-2 text-xs">
                                        Hapus
                                    </x-danger-button>
                                </form>
                            @endif
                        </div>

                        <p class="mt-4 text-sm text-gray-700">{{ $comment->comment }}</p>
                    </article>
                @empty
                    <p class="text-sm text-gray-500">Belum ada komentar. Jadilah yang pertama berbagi pengalamanmu!</p>
                @endforelse
            </div>
        </section>

        @if ($relatedRecipes->isNotEmpty())
            <section class="mt-12">
                <div class="mb-6 flex flex-col gap-2">
                    <h2 class="text-2xl font-semibold text-gray-900">Rekomendasi Resep Lainnya</h2>
                    <p class="text-gray-500">Coba juga kreasi favorit lainnya dari Resepin.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedRecipes as $related)
                        <x-recipe-card
                            class="flex h-full flex-col rounded-2xl"
                            content-class="p-5"
                            actions-class="mt-5"
                            :image="$related->image"
                            :title="$related->title"
                            :chef="$related->chef"
                            :badge="$related->badge"
                            badge-position="content"
                            :href="route('recipes.show', $related->slug)"
                        >
                            <x-slot:meta>
                                <x-like-button
                                    :recipe="$related"
                                    :likes-count="$related->likes_count ?? 0"
                                    :is-liked="$related->is_liked"
                                />
                            </x-slot:meta>
                        </x-recipe-card>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
</x-app-layout>
