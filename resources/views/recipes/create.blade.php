<x-app-layout>
    <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="mb-4 inline-flex items-center text-resepin-green hover:underline">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Resep Baru</h1>
            <p class="mt-2 text-gray-600">Bagikan resep favoritmu dengan komunitas Resepin!</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <x-alert type="error">
                <div class="font-medium">Terjadi kesalahan:</div>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <!-- Form -->
        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Informasi Dasar -->
            <x-card title="Informasi Dasar">
                <div class="space-y-4">
                    <x-form.input
                        name="title"
                        label="Judul Resep"
                        placeholder="Contoh: Nasi Goreng Spesial"
                        required
                    />

                    <x-form.textarea
                        name="description"
                        label="Deskripsi"
                        placeholder="Ceritakan sedikit tentang resep ini..."
                        rows="3"
                    />

                    <div>
                        <label for="image" class="mb-1 block font-medium text-gray-700">
                            Gambar Resep
                        </label>
                        <input
                            type="file"
                            name="image"
                            id="image"
                            accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 file:mr-4 file:rounded-lg file:border-0 file:bg-resepin-green file:px-4 file:py-2 file:text-white file:hover:brightness-95 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                        >
                        <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF, WEBP. Maksimal 2MB.</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-card>

            <!-- Detail Resep -->
            <x-card title="Detail Resep">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-form.input
                        name="duration"
                        label="Waktu Memasak"
                        placeholder="Contoh: 30 menit"
                    />

                    <x-form.input
                        name="servings"
                        label="Porsi"
                        placeholder="Contoh: 4 porsi"
                    />

                    <x-form.select
                        name="difficulty"
                        label="Tingkat Kesulitan"
                        placeholder="Pilih tingkat kesulitan"
                        :options="[
                            'Mudah' => 'Mudah',
                            'Sedang' => 'Sedang',
                            'Sulit' => 'Sulit',
                        ]"
                    />

                    <x-form.select
                        name="category"
                        label="Kategori"
                        placeholder="Pilih kategori"
                        :options="[
                            'sarapan' => '🌅 Sarapan',
                            'makan siang' => '☀️ Makan Siang',
                            'makan malam' => '🌙 Makan Malam',
                            'minuman' => '🥤 Minuman',
                            'camilan' => '🍿 Camilan',
                            'dessert' => '🍰 Dessert',
                        ]"
                    />
                </div>
            </x-card>

            <!-- Ingredients -->
            <div class="rounded-xl bg-white p-6 shadow-md">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">
                    Bahan-bahan <span class="text-red-500">*</span>
                </h2>
                
                <div id="ingredients-container" class="space-y-3">
                    @if (old('ingredients'))
                        @foreach (old('ingredients') as $index => $ingredient)
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
                    @else
                        <div class="ingredient-item flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-resepin-green/10 text-sm font-medium text-resepin-green">1</span>
                            <input
                                type="text"
                                name="ingredients[]"
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
                    @endif
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
                    @if (old('steps'))
                        @foreach (old('steps') as $index => $step)
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
                    @else
                        <div class="step-item flex items-start gap-2">
                            <span class="mt-3 flex h-8 w-8 items-center justify-center rounded-full bg-resepin-tomato/10 text-sm font-medium text-resepin-tomato">1</span>
                            <textarea
                                name="steps[]"
                                rows="2"
                                class="flex-1 rounded-lg border border-gray-300 px-4 py-3 focus:border-resepin-green focus:outline-none focus:ring-2 focus:ring-resepin-green/20"
                                placeholder="Jelaskan langkah memasak..."
                                required
                            ></textarea>
                            <button type="button" onclick="removeStep(this)" class="mt-3 rounded-lg p-2 text-red-500 hover:bg-red-50">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @endif
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
                <x-button 
                    variant="outline" 
                    size="lg" 
                    href="{{ route('dashboard') }}"
                >
                    Batal
                </x-button>
                
                <x-button 
                    variant="primary" 
                    size="lg" 
                    type="submit"
                >
                    Simpan Resep
                </x-button>
            </div>
        </form>
    </main>
</x-app-layout>
