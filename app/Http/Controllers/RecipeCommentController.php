<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeCommentRequest;
use App\Models\Recipe;
use App\Models\RecipeComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RecipeCommentController extends Controller
{
    public function store(StoreRecipeCommentRequest $request, Recipe $recipe): RedirectResponse
    {

        $sanitizedComment = trim(strip_tags($request->validated()['comment']));

        if ($sanitizedComment === '') {
            return back()
                ->withErrors(['comment' => 'Komentar tidak boleh mengandung skrip atau tag HTML.'])
                ->withInput();
        }

        $recipe->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $sanitizedComment,
        ]);

        return back()->with('status', 'Komentar berhasil ditambahkan.');
    }

    public function destroy(Recipe $recipe, RecipeComment $comment): RedirectResponse
    {
        if ($comment->recipe_id !== $recipe->id || $comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('status', 'Komentar berhasil dihapus.');
    }
}
