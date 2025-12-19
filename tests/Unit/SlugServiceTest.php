<?php

use App\Models\Recipe;
use App\Services\SlugService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('generates an incremented slug when duplicate exists', function () {
    Recipe::factory()->create(['slug' => 'nasi-goreng']);

    $slug = app(SlugService::class)->generateUniqueSlug('Nasi Goreng');

    expect($slug)->toBe('nasi-goreng-1');
});

it('ignores the current recipe when regenerating slug', function () {
    $recipe = Recipe::factory()->create(['slug' => 'nasi-goreng']);

    $slug = app(SlugService::class)->generateUniqueSlug('Nasi Goreng', $recipe->id);

    expect($slug)->toBe('nasi-goreng');
});
