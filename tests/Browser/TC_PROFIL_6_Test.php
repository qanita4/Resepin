<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PROFIL_6_Test extends DuskTestCase
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

    public function test_tc_profil_6(): void
    {
        $user = $this->makeUser();

        // data terkait akun (contoh: resep milik user)
        $recipe = Recipe::factory()->create([
            'user_id' => $user->id,
            'title' => 'Resep Punya User',
        ]);
        $recipeSlug = $recipe->slug;

        $this->browse(function (Browser $browser) use ($user, $recipeSlug) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->click('@delete-account')
                ->pause(2000)
                ->type('@delete-password', 'Test@1234')
                ->pause(1000)
                ->click('@confirm-delete')
                ->pause(2000)
                ->assertGuest();

            // setelah akun dihapus, resep user juga harus terhapus (404)
            $browser->visit("/recipes/{$recipeSlug}")
                ->assertSee('404');
        });
    }
}
