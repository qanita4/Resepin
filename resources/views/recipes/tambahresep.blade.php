<x-app-layout>
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @auth
            <div class="mx-auto max-w-3xl">
                <h1 class="mb-6 text-2xl font-bold">Tambah Resep</h1>

                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Chef</label>
                        <input type="text" name="chef" value="{{ old('chef', auth()->user()->name ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rating Awal</label>
                            <input type="number" step="0.1" min="0" max="5" name="initial_rating" value="{{ old('initial_rating') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Porsi</label>
                            <input type="number" name="servings" value="{{ old('servings') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Durasi</label>
                            <input type="text" name="duration" value="{{ old('duration') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kesulitan</label>
                        <input type="text" name="difficulty" value="{{ old('difficulty') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar</label>
                        <input type="file" name="image" class="mt-1 block w-full">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Badge</label>
                        <input type="text" name="badge" value="{{ old('badge') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bahan (satu baris = satu bahan)</label>
                        <textarea name="ingredients" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('ingredients') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Langkah (satu baris = satu langkah)</label>
                        <textarea name="steps" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('steps') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="rounded bg-resepin-tomato px-4 py-2 text-white">Simpan Resep</button>
                        <a href="{{ route('dashboard') }}" class="rounded border px-4 py-2">Batal</a>
                    </div>
                </form>
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center">
                <p class="mb-4 text-lg">Anda perlu login untuk menambah resep.</p>
                <a href="{{ route('login') }}" class="inline-block rounded bg-resepin-tomato px-4 py-2 text-white mr-2">Login</a>
                <a href="{{ route('register') }}" class="inline-block rounded border px-4 py-2">Daftar</a>
            </div>
        @endauth
    </main>
</x-app-layout>
