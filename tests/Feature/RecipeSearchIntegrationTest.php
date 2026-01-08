<?php

use App\Models\Recipe;

it('allows user to search recipes from dashboard', function () {
    Recipe::factory()->create([
        'title' => 'Nasi Goreng Special',
        'description' => 'Nasi goreng dengan telur',
    ]);

    Recipe::factory()->create([
        'title' => 'Soto Ayam',
        'description' => 'Soto ayam bening',
    ]);

    $response = $this->get(route('dashboard', ['q' => 'Nasi Goreng']));

    $response->assertStatus(200);
    $response->assertViewHas('recipes', function ($recipes) {
        return $recipes->contains(function ($recipe) {
            return str_contains($recipe->title, 'Nasi Goreng');
        });
    });
});

it('allows user to filter recipes by category from dashboard', function () {
    Recipe::factory()->create([
        'title' => 'Nasi Uduk',
        'category' => 'Sarapan',
    ]);

    Recipe::factory()->create([
        'title' => 'Steak',
        'category' => 'Makan Malam',
    ]);

    $response = $this->get(route('dashboard', ['kategori' => 'Sarapan']));

    $response->assertStatus(200);
    $response->assertViewHas('recipes', function ($recipes) {
        return $recipes->every(function ($recipe) {
            return $recipe->category === 'Sarapan';
        });
    });
});
