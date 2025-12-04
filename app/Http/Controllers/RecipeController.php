<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->string('q')->trim();
        $filter = $request->string('filter')->trim()->toString();
        $kategori = $request->string('kategori')->trim()->toString();

        // Map kategori slug to actual value
        $kategoriMap = [
            'sarapan' => 'sarapan',
            'makan-siang' => 'makan siang',
            'makan-malam' => 'makan malam',
            'minuman' => 'minuman',
            'camilan' => 'camilan',
            'dessert' => 'dessert',
        ];

        // Base query
        $baseQuery = Recipe::query()
            ->withLikeMeta()
            ->withCount('comments');

        // Search
        $baseQuery->when($query->isNotEmpty(), function ($builder) use ($query) {
            $search = Str::lower($query->toString());

            $builder->where(function ($subQuery) use ($search) {
                $subQuery
                    ->whereRaw('LOWER(title) like ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(chef) like ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description) like ?', ["%{$search}%"]);
            });
        });

        // Apply filter
        if ($filter === 'my') {
            // Resep Saya - filter by user_id
            $baseQuery->where('user_id', Auth::id());
            $recipes = $baseQuery->orderByDesc('created_at')->get();
        } elseif (!empty($kategori) && isset($kategoriMap[$kategori])) {
            // Filter by kategori
            $baseQuery->whereRaw('LOWER(category) = ?', [strtolower($kategoriMap[$kategori])]);
            $recipes = $baseQuery->orderByDesc('likes_count')->get();
        } elseif ($query->isNotEmpty()) {
            // Search results
            $recipes = $baseQuery->orderByDesc('created_at')->get();
        } else {
            // Default: Resep Populer - top 6 by likes
            $recipes = $baseQuery->orderByDesc('likes_count')->take(6)->get();
        }

        // Get latest recipes (only for default view)
        $latestRecipes = collect();
        if (empty($filter) && empty($kategori) && $query->isEmpty()) {
            $latestRecipes = Recipe::query()
                ->withLikeMeta()
                ->orderByDesc('created_at')
                ->take(6)
                ->get();
        }

        return view('dashboard', [
            'recipes' => $recipes,
            'searchQuery' => $query->toString(),
            'currentFilter' => $filter,
            'currentKategori' => $kategori,
            'latestRecipes' => $latestRecipes,
        ]);
    }

    public function all(Request $request): View
    {
        $query = $request->string('q')->trim();

        $baseQuery = Recipe::query()
            ->withLikeMeta()
            ->withCount('comments');

        // Search
        $baseQuery->when($query->isNotEmpty(), function ($builder) use ($query) {
            $search = Str::lower($query->toString());

            $builder->where(function ($subQuery) use ($search) {
                $subQuery
                    ->whereRaw('LOWER(title) like ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(chef) like ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description) like ?', ["%{$search}%"]);
            });
        });

        $recipes = $baseQuery->orderByDesc('created_at')->paginate(9);

        return view('recipes.all', [
            'recipes' => $recipes,
            'searchQuery' => $query->toString(),
        ]);
    }

    public function show(Recipe $recipe): View
    {
        $recipe->loadCount('likes');

        $likedByCurrentUser = false;

        if (Auth::check()) {
            $likedByCurrentUser = $recipe->likes()
                ->where('user_id', Auth::id())
                ->exists();
        }

        $recipe->setAttribute('liked_by_current_user', $likedByCurrentUser);

        $recipe->load(['comments' => fn ($query) => $query->with('user')->latest()]);

        $relatedRecipes = Recipe::query()
            ->where('id', '!=', $recipe->id)
            ->withLikeMeta()
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('recipes.show', [
            'recipe' => $recipe,
            'relatedRecipes' => $relatedRecipes,
        ]);
    }

    public function create(): View
    {
        return view('recipes.create');
    }

    public function store(StoreRecipeRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Generate slug dari title
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;

        // Pastikan slug unik
        while (Recipe::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
        }

        // Filter ingredients dan steps yang kosong
        $ingredients = array_values(array_filter($validated['ingredients'], fn($item) => !empty(trim($item))));
        $steps = array_values(array_filter($validated['steps'], fn($item) => !empty(trim($item))));

        // Buat resep baru
        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'slug' => $slug,
            'title' => $validated['title'],
            'chef' => Auth::user()->name,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'badge' => $validated['badge'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'servings' => $validated['servings'] ?? null,
            'difficulty' => $validated['difficulty'] ?? null,
            'ingredients' => $ingredients,
            'steps' => $steps,
            'initial_rating' => 0,
        ]);

        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Resep berhasil ditambahkan!');
    }

    public function edit(Recipe $recipe): View
    {
        // Only owner can edit
        if ($recipe->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit resep ini.');
        }

        return view('recipes.edit', [
            'recipe' => $recipe,
        ]);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe): RedirectResponse
    {
        // Only owner can update
        if ($recipe->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit resep ini.');
        }

        $validated = $request->validated();

        // Handle upload gambar baru
        $imagePath = $recipe->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $imagePath = $request->file('image')->store('recipes', 'public');
        }

        // Filter ingredients dan steps yang kosong
        $ingredients = array_values(array_filter($validated['ingredients'], fn($item) => !empty(trim($item))));
        $steps = array_values(array_filter($validated['steps'], fn($item) => !empty(trim($item))));

        // Update slug jika title berubah
        $slug = $recipe->slug;
        if ($validated['title'] !== $recipe->title) {
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $counter = 1;

            while (Recipe::where('slug', $slug)->where('id', '!=', $recipe->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $recipe->update([
            'slug' => $slug,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'badge' => $validated['badge'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'servings' => $validated['servings'] ?? null,
            'difficulty' => $validated['difficulty'] ?? null,
            'ingredients' => $ingredients,
            'steps' => $steps,
        ]);

        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Resep berhasil diperbarui!');
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        // Only owner can delete
        if ($recipe->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus resep ini.');
        }

        // Delete image if exists
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Resep berhasil dihapus!');
    }
}
