<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PROFIL_5_Test extends DuskTestCase
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

    public function test_tc_profil_5(): void
    {
        $user = $this->makeUser();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->click('@edit-password-btn')
                ->pause(2000)
                ->type('@old-password', 'Salah123')
                ->pause(500)
                ->type('@new-password', 'Baru@1234')
                ->pause(500)
                ->type('@new-password-confirmation', 'Baru@1234')
                ->pause(500)
                ->click('@save-password')
                ->pause(2000)
                // Laravel menampilkan pesan "The provided password does not match your current password."
                ->assertSee('password');
        });
    }
}
