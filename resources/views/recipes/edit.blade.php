<x-app-layout>
    <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('recipes.show', $recipe) }}" class="mb-4 inline-flex items-center text-resepin-green hover:underline">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Resep
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Resep</h1>
            <p class="mt-2 text-gray-600">Perbarui resep "{{ $recipe->title }}"</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="rounded-xl bg-white p-6 shadow-md">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Informasi Dasar</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="title" class="mb-1 block font-medium text-gray-700">
                            Judul Resep <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title', $recipe->title) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                            placeholder="Contoh: Nasi Goreng Spesial"
                            required
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="mb-1 block font-medium text-gray-700">
                            Deskripsi
                        </label>
                        <textarea
                            name="description"
                            id="description"
                            rows="3"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                            placeholder="Ceritakan sedikit tentang resep ini..."
                        >{{ old('description', $recipe->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="image" class="mb-1 block font-medium text-gray-700">
                            Gambar Resep
                        </label>
                        @if ($recipe->image)
                            <div class="mb-3">
                                <p class="mb-2 text-sm text-gray-500">Gambar saat ini:</p>
                                <img src="{{ Storage::url($recipe->image) }}" alt="{{ $recipe->title }}" class="h-32 w-32 rounded-lg object-cover">
                            </div>
                        @endif
                        <input
                            type="file"
                            name="image"
                            id="image"
                            accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 file:mr-4 file:rounded-lg file:border-0 file:bg-resepin-green file:px-4 file:py-2 file:text-white file:hover:brightness-95 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                        >
                        <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Recipe Details -->
            <div class="rounded-xl bg-white p-6 shadow-md">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Detail Resep</h2>
                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="duration" class="mb-1 block font-medium text-gray-700">
                            Waktu Memasak
                        </label>
                        <input
                            type="text"
                            name="duration"
                            id="duration"
                            value="{{ old('duration', $recipe->duration) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                            placeholder="Contoh: 30 menit"
                        >
                        @error('duration')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="servings" class="mb-1 block font-medium text-gray-700">
                            Porsi
                        </label>
                        <input
                            type="number"
                            name="servings"
                            id="servings"
                            value="{{ old('servings', $recipe->servings) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                            placeholder="Contoh: 4"
                            min="1"
                        >
                        @error('servings')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="difficulty" class="mb-1 block font-medium text-gray-700">
                            Tingkat Kesulitan
                        </label>
                        <select
                            name="difficulty"
                            id="difficulty"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                        >
                            <option value="">Pilih tingkat kesulitan</option>
                            <option value="Mudah" {{ old('difficulty', $recipe->difficulty) == 'Mudah' ? 'selected' : '' }}>Mudah</option>
                            <option value="Sedang" {{ old('difficulty', $recipe->difficulty) == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Sulit" {{ old('difficulty', $recipe->difficulty) == 'Sulit' ? 'selected' : '' }}>Sulit</option>
                        </select>
                        @error('difficulty')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="mb-1 block font-medium text-gray-700">
                            Kategori
                        </label>
                        <select
                            name="category"
                            id="category"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                        >
                            <option value="">Pilih kategori</option>
                            <option value="sarapan" {{ old('category', $recipe->category) == 'sarapan' ? 'selected' : '' }}>🌅 Sarapan</option>
                            <option value="makan siang" {{ old('category', $recipe->category) == 'makan siang' ? 'selected' : '' }}>☀️ Makan Siang</option>
                            <option value="makan malam" {{ old('category', $recipe->category) == 'makan malam' ? 'selected' : '' }}>🌙 Makan Malam</option>
                            <option value="minuman" {{ old('category', $recipe->category) == 'minuman' ? 'selected' : '' }}>🥤 Minuman</option>
                            <option value="camilan" {{ old('category', $recipe->category) == 'camilan' ? 'selected' : '' }}>🍿 Camilan</option>
                            <option value="dessert" {{ old('category', $recipe->category) == 'dessert' ? 'selected' : '' }}>🍰 Dessert</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Ingredients -->
            <div class="rounded-xl bg-white p-6 shadow-md">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">
                    Bahan-bahan <span class="text-red-500">*</span>
                </h2>
    
                <div id="ingredients-container" class="space-y-3">
                    @php
                        $ingredients = old('ingredients', $recipe->ingredients ?? []);
                    @endphp
                    @foreach ($ingredients as $index => $ingredient)
                        <div class="ingredient-item flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-resepin-green/10 text-sm font-medium text-resepin-green">{{ $index + 1 }}</span>
                            <input
                                type="text"
                                name="ingredients[]"
                                value="{{ $ingredient }}"
                                class="flex-1 rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                                placeholder="Contoh: 2 butir telur"
                                required
                            >
                            <button type="button" onclick="removeIngredient(this)" class="rounded-lg p-2 text-red-500 hover:bg-red-50">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
                @error('ingredients')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
                @error('ingredients.*')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
                
                <button
                    type="button"
                    onclick="addIngredient()"
                    class="mt-4 inline-flex items-center gap-2 rounded-lg border-2 border-dashed border-resepin-green px-4 py-2 font-medium text-resepin-green transition hover:bg-resepin-green/10"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Bahan
                </button>
            </div>

            <!-- Steps -->
            <div class="rounded-xl bg-white p-6 shadow-md">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">
                    Langkah-langkah <span class="text-red-500">*</span>
                </h2>
                
                <div id="steps-container" class="space-y-3">
                    @php
                        $steps = old('steps', $recipe->steps ?? []);
                    @endphp
                    @foreach ($steps as $index => $step)
                        <div class="step-item flex items-start gap-2">
                            <span class="mt-3 flex h-8 w-8 items-center justify-center rounded-full bg-resepin-tomato/10 text-sm font-medium text-resepin-tomato">{{ $index + 1 }}</span>
                            <textarea
                                name="steps[]"
                                rows="2"
                                class="flex-1 rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                                placeholder="Jelaskan langkah memasak..."
                                required
                            >{{ $step }}</textarea>
                            <button type="button" onclick="removeStep(this)" class="mt-3 rounded-lg p-2 text-red-500 hover:bg-red-50">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
                @error('steps')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
                @error('steps.*')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
                
                <button
                    type="button"
                    onclick="addStep()"
                    class="mt-4 inline-flex items-center gap-2 rounded-lg border-2 border-dashed border-resepin-tomato px-4 py-2 font-medium text-resepin-tomato transition hover:bg-resepin-tomato/10"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Langkah
                </button>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('recipes.show', $recipe) }}" class="rounded-lg border border-gray-300 px-6 py-3 font-medium text-gray-700 transition hover:bg-gray-50">
                    Batal
                </a>
                <button
                    type="submit"
                    class="rounded-lg bg-resepin-tomato px-8 py-3 font-medium text-white shadow-md transition hover:brightness-95"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </main>
</x-app-layout>
