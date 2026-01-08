<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PROFIL_1_Test extends DuskTestCase
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

    public function test_tc_profil_1(): void
    {
        $user = $this->makeUser();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->click('@profile-dropdown-trigger')
                ->pause(2000)
                ->click('@menu-profile')
                ->assertPathIs('/profile')
                ->pause(2000)
                ->assertInputValue('@username-input', 'rafif_muh')
                ->assertInputValue('@email-input', 'rafif@test.com');
        });
    }
}
