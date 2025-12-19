<?php

use App\Models\Recipe;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

it('mengizinkan user terautentikasi membuat resep baru dengan slug unik dan membersihkan bahan/langkah kosong', function () {
    $user = User::factory()->create();
    actingAs($user);

    $payload = [
        'title' => 'Nasi Goreng Spesial',
        'description' => 'Enak dan cepat',
        'badge' => 'Favorit',
        'duration' => '15 menit',
        'servings' => 2,
        'difficulty' => 'Mudah',
        'category' => 'sarapan',
        'ingredients' => [' nasi ', 'kecap '],
        'steps' => ['tumis bumbu ', 'masukkan nasi '],
    ];

    post(route('recipes.store'), $payload)
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $recipe = Recipe::firstOrFail();
    expect($recipe->slug)->toBe('nasi-goreng-spesial');
    expect($recipe->ingredients)->toBe(['nasi', 'kecap']);
    expect($recipe->steps)->toBe(['tumis bumbu', 'masukkan nasi']);
    expect($recipe->chef)->toBe($user->name);
});

it('hanya pemilik yang boleh memperbarui resep dan slug berubah jika judul berubah', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $owner->id,
        'title' => 'Ayam Bakar',
        'slug' => 'ayam-bakar',
    ]);

    actingAs($other);
    put(route('recipes.update', $recipe), [
        'title' => 'Ayam Bakar Madu',
        'description' => '---',
        'ingredients' => ['ayam'],
        'steps' => ['panggang'],
        'difficulty' => 'Sedang',
        'servings' => 2,
    ])->assertForbidden();

    actingAs($owner);
    put(route('recipes.update', $recipe), [
        'title' => 'Ayam Bakar Madu',
        'description' => 'lebih manis',
        'ingredients' => ['ayam', 'madu'],
        'steps' => ['panggang', 'oles madu'],
        'difficulty' => 'Sedang',
        'servings' => 2,
    ])->assertRedirect();

    $recipe->refresh();
    expect($recipe->title)->toBe('Ayam Bakar Madu');
    expect($recipe->slug)->toBe('ayam-bakar-madu');
    expect($recipe->ingredients)->toBe(['ayam', 'madu']);
});

it('hanya pemilik yang boleh menghapus resep', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $recipe = Recipe::factory()->create(['user_id' => $owner->id]);

    actingAs($other);
    delete(route('recipes.destroy', $recipe))->assertForbidden();
    expect(Recipe::whereKey($recipe->id)->exists())->toBeTrue();

    actingAs($owner);
    delete(route('recipes.destroy', $recipe))->assertRedirect(route('dashboard'));
    expect(Recipe::whereKey($recipe->id)->exists())->toBeFalse();
});
