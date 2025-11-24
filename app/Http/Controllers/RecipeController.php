<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    // new: show form to create recipe
    public function create(): View
    {
        return view('recipes.tambahresep');
    }

    // new: store new recipe
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'chef' => 'nullable|string|max:255',
            'initial_rating' => 'nullable|numeric|min:0|max:5',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'badge' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:100',
            'servings' => 'nullable|integer|min:1',
            'difficulty' => 'nullable|string|max:50',
            'ingredients' => 'nullable|string',
            'steps' => 'nullable|string',
        ]);

        // handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('recipes', 'public');
            $data['image'] = $path;
        }

        // normalize ingredients & steps: textarea -> array by newlines
        $normalizeList = function (?string $text) {
            if (is_null($text) || trim($text) === '') {
                return [];
            }
            $lines = preg_split('/\r\n|\r|\n/', $text);
            $lines = array_map('trim', $lines);
            $lines = array_filter($lines, fn($l) => $l !== '');
            return array_values($lines);
        };

        $data['ingredients'] = $normalizeList($data['ingredients'] ?? null);
        $data['steps'] = $normalizeList($data['steps'] ?? null);

        // slug unique
        $slug = Str::slug($data['title']);
        $original = $slug;
        $i = 1;
        while (Recipe::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }
        $data['slug'] = $slug;

        // set chef default to current user name if not provided
        if (empty($data['chef']) && Auth::check()) {
            $data['chef'] = Auth::user()->name ?? null;
        }

        // record user who created recipe
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        $recipe = Recipe::create($data);

        return redirect()->route('recipes.show', $recipe)->with('success', 'Resep berhasil ditambahkan.');
    }

    protected $fillable = [
        'slug',
        'user_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];
}
