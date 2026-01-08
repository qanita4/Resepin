<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Recipe;
use App\Models\RecipeLike;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_POP_1_Test extends DuskTestCase
{
    use DatabaseMigrations;

    private function makeUser(): User
    {
        return User::factory()->create([
            'name' => 'rafif_muh',
            'email' => 'rafif@test.com',
            'password' => Hash::make('Test@1234'),
        ]);
    }

    public function test_tc_pop_1(): void
    {
        $user = $this->makeUser();

        // Buat banyak resep dengan likes agar muncul di populer
        $recipes = Recipe::factory()->count(10)->create();
        
        // Beri likes ke beberapa resep
        foreach ($recipes->take(6) as $recipe) {
            RecipeLike::factory()->create([
                'recipe_id' => $recipe->id,
                'user_id' => $user->id,
            ]);
        }

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Resep Populer')
                ->assertPresent('@popular-recipes')
                ->pause(2000);

            $cards = $browser->elements('[dusk^="popular-card-"]');
            $this->assertTrue(count($cards) <= 6, 'Resep populer yang tampil lebih dari 6!');
        });
    }
}
