<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PROFIL_3_Test extends DuskTestCase
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

    public function test_tc_profil_3(): void
    {
        $user = $this->makeUser();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->click('@edit-profile-btn')
                ->pause(2000)
                ->clear('@username-input')
                ->click('@save-profile')
                // HTML5 validation akan mencegah submit, cek bahwa tetap di halaman profile
                ->assertPathIs('/profile')
                ->pause(2000);
        });
    }
}
