<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
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

        $recipes = Recipe::query()
            ->withLikeMeta()
            ->when($query->isNotEmpty(), function ($builder) use ($query) {
                $search = Str::lower($query->toString());

                $builder->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->whereRaw('LOWER(title) like ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(chef) like ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(description) like ?', ["%{$search}%"]);
                });
            })
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard', [
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
}
