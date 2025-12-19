<?php

use App\Models\Recipe;
use App\Models\RecipeLike;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\post;

it('mencatat like unik per user dan bisa dilepas', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();

    actingAs($user);

    post(route('recipes.likes.store', $recipe))->assertRedirect();
    post(route('recipes.likes.store', $recipe))->assertRedirect(); // tidak duplikat
    expect(RecipeLike::where('recipe_id', $recipe->id)->where('user_id', $user->id)->count())->toBe(1);

    delete(route('recipes.likes.destroy', $recipe))->assertRedirect();
    expect(RecipeLike::where('recipe_id', $recipe->id)->where('user_id', $user->id)->exists())->toBeFalse();
});

it('menyimpan komentar yang sudah disanitasi untuk resep', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();

    actingAs($user);

    post(route('recipes.comments.store', $recipe), [
        'comment' => '<b>Enak!</b> Mantap',
    ])->assertRedirect();

    $comment = $recipe->comments()->firstOrFail();
    expect($comment->comment)->toBe('Enak! Mantap');
    expect($comment->user_id)->toBe($user->id);
});
