<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_recipes(): void
    {
        Recipe::factory()->create(['title' => 'Cari Satu']);
        Recipe::factory()->create(['title' => 'Cari Dua']);
        Recipe::factory()->create(['title' => 'Cari Tiga']);

        $response = $this->get(route('dashboard', ['q' => 'Cari']));

        $response->assertOk();
        $response->assertViewIs('dashboard');
        $response->assertViewHas('recipes', fn ($recipes) => $recipes->count() === 3);
    }

    public function test_store_creates_recipe_when_authenticated(): void
    {
        $user = User::factory()->create();

        $payload = [
            'title' => 'Nasi Goreng',
            'description' => 'Enak dan cepat',
            'ingredients' => ['nasi', 'telur', 'kecap'],
            'steps' => ['Tumis bumbu', 'Masak nasi', 'Sajikan'],
            'category' => 'sarapan',
            'difficulty' => 'Mudah',
        ];

        $response = $this->actingAs($user)->post(route('recipes.store'), $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('recipes', ['title' => 'Nasi Goreng']);
    }

    public function test_show_returns_404_for_missing_recipe(): void
    {
        $response = $this->get(route('recipes.show', 9999));

        $response->assertNotFound();
    }
}
