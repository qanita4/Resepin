<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Recipe;
use App\Services\ImageUploadService;
use App\Services\RecipeSearchService;
use App\Services\SlugService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function __construct(
        private RecipeSearchService $searchService,
        private SlugService $slugService,
        private ImageUploadService $imageService
    ) {}

    public function index(Request $request): View
    {
        $searchQuery = $request->string('q')->trim()->toString();
        $filter = $request->string('filter')->trim()->toString();
        $kategori = $request->string('kategori')->trim()->toString();

        // Base query
        $baseQuery = $this->searchService->getBaseQuery();
        
        // Apply search
        $this->searchService->applySearch($baseQuery, $searchQuery);

        // Apply filters
        if ($filter === 'my') {
            $this->searchService->applyUserFilter($baseQuery, Auth::id());
            $recipes = $baseQuery->orderByDesc('created_at')->get();
        } elseif (!empty($kategori)) {
            $this->searchService->applyCategory($baseQuery, $kategori);
            $recipes = $baseQuery->orderByDesc('likes_count')->get();
        } elseif (!empty($searchQuery)) {
            $recipes = $baseQuery->orderByDesc('created_at')->get();
        } else {
            $recipes = $this->searchService->getPopular(6);
        }

        // Get latest recipes (only for default view)
        $latestRecipes = collect();
        if (empty($filter) && empty($kategori) && empty($searchQuery)) {
            $latestRecipes = $this->searchService->getLatest(6);
        }

        return view('dashboard', [
            'recipes' => $recipes,
            'searchQuery' => $searchQuery,
            'currentFilter' => $filter,
            'currentKategori' => $kategori,
            'latestRecipes' => $latestRecipes,
        ]);
    }

    public function all(Request $request): View
    {
        $searchQuery = $request->string('q')->trim()->toString();

        $baseQuery = $this->searchService->getBaseQuery();
        $this->searchService->applySearch($baseQuery, $searchQuery);

        $recipes = $baseQuery->orderByDesc('created_at')->paginate(9);

        return view('recipes.all', [
            'recipes' => $recipes,
            'searchQuery' => $searchQuery,
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
        try {
            $validated = $request->validated();

            // Generate unique slug
            $slug = $this->slugService->generateUniqueSlug($validated['title']);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $this->imageService->upload($request->file('image'));
            }

            // Filter empty ingredients and steps
            $ingredients = array_values(array_filter(
                $validated['ingredients'],
                fn($item) => !empty(trim($item))
            ));
            $steps = array_values(array_filter(
                $validated['steps'],
                fn($item) => !empty(trim($item))
            ));

            // Create recipe
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
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan resep: ' . $e->getMessage()]);
        }
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

        // Handle image upload/update
        $imagePath = $recipe->image;
        if ($request->hasFile('image')) {
            $imagePath = $this->imageService->update($recipe->image, $request->file('image'));
        }

        // Filter empty ingredients and steps
        $ingredients = array_values(array_filter(
            $validated['ingredients'],
            fn($item) => !empty(trim($item))
        ));
        $steps = array_values(array_filter(
            $validated['steps'],
            fn($item) => !empty(trim($item))
        ));

        // Update slug if title changed
        $slug = $recipe->slug;
        if ($validated['title'] !== $recipe->title) {
            $slug = $this->slugService->generateUniqueSlug($validated['title'], $recipe->id);
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
        $this->imageService->delete($recipe->image);

        $recipe->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Resep berhasil dihapus!');
    }
}
