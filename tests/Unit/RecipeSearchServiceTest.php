<?php

use App\Models\Recipe;
use App\Models\RecipeLike;
use App\Models\User;
use App\Services\RecipeSearchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->service = app(RecipeSearchService::class);
});

it('filters recipes by search term across title chef and description', function () {
    Recipe::factory()->create(['title' => 'Nasi Goreng Spesial', 'chef' => 'Budi', 'description' => 'Pedas']);
    Recipe::factory()->create(['title' => 'Mie Ayam']);

    $results = $this->service
        ->applySearch($this->service->getBaseQuery(), 'gOrEnG')
        ->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->title)->toBe('Nasi Goreng Spesial');
});

it('maps slugified category filters to stored values', function () {
    Recipe::factory()->create(['title' => 'Soto Ayam', 'category' => 'makan siang']);
    Recipe::factory()->create(['title' => 'Es Teh', 'category' => 'minuman']);

    $results = $this->service
        ->applyCategory($this->service->getBaseQuery(), 'makan-siang')
        ->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->category)->toBe('makan siang');
});

it('filters recipes by user', function () {
    $user = User::factory()->create();
    $ownerRecipe = Recipe::factory()->create(['user_id' => $user->id]);
    Recipe::factory()->create();

    $results = $this->service
        ->applyUserFilter($this->service->getBaseQuery(), $user->id)
        ->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->is($ownerRecipe))->toBeTrue();
});

it('returns popular recipes ordered by like count', function () {
    $mostLiked = Recipe::factory()->create();
    $lessLiked = Recipe::factory()->create();

    RecipeLike::factory()->count(3)->create(['recipe_id' => $mostLiked->id]);
    RecipeLike::factory()->create(['recipe_id' => $lessLiked->id]);

    $popular = $this->service->getPopular();

    expect($popular)->toHaveCount(2);
    expect($popular->first()->is($mostLiked))->toBeTrue();
});

it('returns latest recipes ordered by creation date', function () {
    $older = Recipe::factory()->create(['created_at' => Carbon::now()->subDay()]);
    $newer = Recipe::factory()->create(['created_at' => Carbon::now()]);

    $latest = $this->service->getLatest();

    expect($latest->first()->is($newer))->toBeTrue();
    expect($latest->last()->is($older))->toBeTrue();
});

it('returns related recipes matching category and excluding current', function () {
    $recipe = Recipe::factory()->create(['category' => 'minuman']);
    $sameCategory = Recipe::factory()->create(['category' => 'minuman']);
    Recipe::factory()->create(['category' => 'sarapan']);

    $related = $this->service->getRelated($recipe, 3);

    expect($related)->toHaveCount(1);
    expect($related->first()->is($sameCategory))->toBeTrue();
    expect($related->pluck('category')->unique()->all())->toBe(['minuman']);
});
