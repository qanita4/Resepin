<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PROFIL_4_Test extends DuskTestCase
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

    public function test_tc_profil_4(): void
    {
        $user = $this->makeUser();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->click('@edit-password-btn')
                ->pause(2000)
                ->type('@old-password', 'Test@1234')
                ->type('@new-password', 'Baru@1234')
                ->type('@new-password-confirmation', 'Baru@1234')
                ->click('@save-password')
                ->waitFor('@password-success-message')
                ->assertSee('Password berhasil diperbarui')
                ->pause(2000);
        });
    }
}
