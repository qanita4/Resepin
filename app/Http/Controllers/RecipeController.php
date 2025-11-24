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
    
}
