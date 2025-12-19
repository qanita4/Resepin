<?php

use App\Models\Recipe;
use App\Models\RecipeLike;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('returns false for is_liked when guest', function () {
    $recipe = Recipe::factory()->create();

    expect($recipe->is_liked)->toBeFalse();
});

it('uses like metadata when loaded through scopeWithLikeMeta', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();
    RecipeLike::factory()->create([
        'recipe_id' => $recipe->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);
    $fetched = Recipe::withLikeMeta()->first();

    expect($fetched->likes_count)->toBe(1);
    expect($fetched->is_liked)->toBeTrue();
});

it('detects like through loaded relation fallback', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();
    RecipeLike::factory()->create([
        'recipe_id' => $recipe->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);
    $fetched = Recipe::with('likes')->first();

    expect($fetched->is_liked)->toBeTrue();
});

it('uses slug as route key name', function () {
    $recipe = new Recipe();

    expect($recipe->getRouteKeyName())->toBe('slug');
});
