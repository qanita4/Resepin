<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Recipe;
use App\Models\RecipeLike;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_POP_2_Test extends DuskTestCase
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

    public function test_tc_pop_2(): void
    {
        $user = $this->makeUser();
        $recipe = Recipe::factory()->create(['title' => 'Nasi Goreng Spesial']);
        
        // Beri like agar muncul di populer
        RecipeLike::factory()->create([
            'recipe_id' => $recipe->id,
            'user_id' => $user->id,
        ]);

        $this->browse(function (Browser $browser) use ($user, $recipe) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->pause(2000)
                ->assertPresent('@popular-recipes')
                ->assertPresent("@popular-card-{$recipe->id}")
                ->pause(2000)
                ->click("@popular-card-{$recipe->id} a")
                ->pause(2000)
                ->assertPathIs("/recipes/{$recipe->slug}")
                ->assertSee('Nasi Goreng Spesial')
                ->pause(2000);
        });
    }
}
