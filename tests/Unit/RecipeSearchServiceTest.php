<?php

use App\Models\Recipe;
use App\Services\RecipeSearchService;

beforeEach(function () {
    Recipe::query()->delete();
});

it('filters recipes by search term in title, chef, or description', function () {
    $service = new RecipeSearchService();

    Recipe::factory()->create([
        'title' => 'Nasi Goreng Spesial',
        'chef' => 'Chef Andi',
        'description' => 'Nasi goreng enak dan lezat',
    ]);

    Recipe::factory()->create([
        'title' => 'Soto Ayam',
        'chef' => 'Chef Budi',
        'description' => 'Kuah hangat',
    ]);

    $query = $service->getBaseQuery();
    $query = $service->applySearch($query, 'nasi goreng');

    $results = $query->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->title)->toBe('Nasi Goreng Spesial');
});

it('filters recipes by category slug using kategori map', function () {
    $service = new RecipeSearchService();

    Recipe::factory()->create([
        'title' => 'Nasi Uduk',
        'category' => 'sarapan',
    ]);

    Recipe::factory()->create([
        'title' => 'Steak',
        'category' => 'makan malam',
    ]);

    $query = $service->getBaseQuery();
    $query = $service->applyCategory($query, 'sarapan');

    $results = $query->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->category)->toBe('sarapan');
});

it('filters recipes by user id', function () {
    $service = new RecipeSearchService();

    $user1Id = 1;
    $user2Id = 2;

    Recipe::factory()->create([
        'title' => 'Resep User 1',
        'user_id' => $user1Id,
    ]);

    Recipe::factory()->create([
        'title' => 'Resep User 2',
        'user_id' => $user2Id,
    ]);

    $query = $service->getBaseQuery();
    $query = $service->applyUserFilter($query, $user1Id);

    $results = $query->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->user_id)->toBe($user1Id);
});
