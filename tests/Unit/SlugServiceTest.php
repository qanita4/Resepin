<?php

use App\Models\Recipe;
use App\Services\SlugService;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    // Pastikan database bersih per test
    Recipe::query()->delete();
});

it('generates slug from title when no existing recipe', function () {
    $service = new SlugService();

    $slug = $service->generateUniqueSlug('Nasi Goreng Spesial');

    expect($slug)->toBe('nasi-goreng-spesial');
});

it('appends counter when slug already exists', function () {
    $service = new SlugService();

    // Buat recipe dengan slug tertentu
    Recipe::factory()->create([
        'title' => 'Nasi Goreng Spesial',
        'slug'  => 'nasi-goreng-spesial',
    ]);

    $slugBaru = $service->generateUniqueSlug('Nasi Goreng Spesial');

    expect($slugBaru)->toBe('nasi-goreng-spesial-1');
});

it('ignores current recipe when updating', function () {
    $service = new SlugService();

    $recipe = Recipe::factory()->create([
        'title' => 'Nasi Goreng Spesial',
        'slug'  => 'nasi-goreng-spesial',
    ]);

    // Saat update, slug yang sama untuk recipe yang sama seharusnya tidak ditambah counter
    $slug = $service->generateUniqueSlug('Nasi Goreng Spesial', $recipe->id);

    expect($slug)->toBe('nasi-goreng-spesial');
});
