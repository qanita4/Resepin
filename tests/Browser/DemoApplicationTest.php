<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Recipe;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DemoApplicationTest extends DuskTestCase
{
    /**
     * Pause duration in milliseconds
     */
    private int $pauseDuration = 700;

    /**
     * Get or create demo user
     */
    private function getDemoUser(): User
    {
        return User::firstOrCreate(
            ['email' => 'demo@resepin.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password123'),
            ]
        );
    }

    /**
     * Demo aplikasi Resepin
     */
    public function test_demo_aplikasi_resepin(): void
    {
        $user = $this->getDemoUser();

        $this->browse(function (Browser $browser) use ($user) {
            // ========================================
            // 1. HALAMAN DASHBOARD (TANPA LOGIN)
            // ========================================
            $browser->visit('/dashboard')
                ->pause($this->pauseDuration)
                ->assertSee('Resep Populer')
                ->pause($this->pauseDuration);

            // Scroll untuk lihat resep populer
            $browser->scrollTo('@popular-recipes')
                ->pause($this->pauseDuration);

            // ========================================
            // 2. LIHAT SEMUA RESEP
            // ========================================
            $browser->visit('/recipes')
                ->pause($this->pauseDuration)
                ->assertPathIs('/recipes')
                ->pause($this->pauseDuration);

            // ========================================
            // 3. LIHAT DETAIL RESEP
            // ========================================
            $firstRecipe = Recipe::first();
            $browser->visit('/recipes/' . $firstRecipe->slug)
                ->pause($this->pauseDuration)
                ->assertSee($firstRecipe->title)
                ->pause($this->pauseDuration);

            // Scroll untuk lihat bahan-bahan
            $browser->scrollTo('.ingredients')
                ->pause($this->pauseDuration);

            // Scroll untuk lihat langkah-langkah
            $browser->scrollTo('.steps')
                ->pause($this->pauseDuration);

            // ========================================
            // 4. HALAMAN LOGIN
            // ========================================
            $browser->visit('/login')
                ->pause($this->pauseDuration)
                ->assertSee('Masuk')
                ->pause($this->pauseDuration);

            // Isi form login
            $browser->type('email', 'demo@resepin.com')
                ->pause($this->pauseDuration)
                ->type('password', 'password123')
                ->pause($this->pauseDuration)
                ->press('Masuk')
                ->pause($this->pauseDuration);

            // ========================================
            // 5. DASHBOARD SETELAH LOGIN
            // ========================================
            $browser->assertPathIs('/dashboard')
                ->pause($this->pauseDuration);

            // ========================================
            // 6. BUAT RESEP BARU
            // ========================================
            $browser->visit('/recipes/create')
                ->pause($this->pauseDuration)
                ->assertSee('Buat Resep')
                ->pause($this->pauseDuration);

            // Isi form resep
            $browser->type('title', 'Nasi Goreng Demo')
                ->pause($this->pauseDuration)
                ->type('description', 'Resep nasi goreng untuk demo aplikasi')
                ->pause($this->pauseDuration)
                ->type('duration', '15 menit')
                ->pause($this->pauseDuration)
                ->type('servings', '2 porsi')
                ->pause($this->pauseDuration);

            // Scroll ke bawah
            $browser->scrollTo('button[type="submit"]')
                ->pause($this->pauseDuration);

            // ========================================
            // 7. HALAMAN PROFIL
            // ========================================
            $browser->visit('/profile')
                ->pause($this->pauseDuration)
                ->assertSee('Profil')
                ->pause($this->pauseDuration);

            // Scroll untuk lihat form update profil
            $browser->scrollTo('form')
                ->pause($this->pauseDuration);

            // ========================================
            // 8. LIKE RESEP
            // ========================================
            $browser->visit('/recipes/' . $firstRecipe->slug)
                ->pause($this->pauseDuration);

            // Klik tombol like jika ada
            if ($browser->element('@like-button')) {
                $browser->click('@like-button')
                    ->pause($this->pauseDuration);
            }

            // ========================================
            // 9. KOMENTAR RESEP
            // ========================================
            // Scroll ke bagian komentar
            $browser->scrollTo('.comments')
                ->pause($this->pauseDuration);

            // Tulis komentar jika form ada
            if ($browser->element('textarea[name="content"]')) {
                $browser->type('content', 'Resep yang sangat lezat! Terima kasih sudah berbagi.')
                    ->pause($this->pauseDuration);
            }

            // ========================================
            // 10. SEARCH/FILTER RESEP
            // ========================================
            $browser->visit('/recipes')
                ->pause($this->pauseDuration);

            // Cari resep jika ada search box
            if ($browser->element('input[name="search"]')) {
                $browser->type('search', 'nasi goreng')
                    ->pause($this->pauseDuration)
                    ->keys('input[name="search"]', '{enter}')
                    ->pause($this->pauseDuration);
            }

            // ========================================
            // 11. LOGOUT
            // ========================================
            // Klik menu user atau tombol logout
            if ($browser->element('@user-menu')) {
                $browser->click('@user-menu')
                    ->pause($this->pauseDuration);
            }

            $browser->post('/logout')
                ->pause($this->pauseDuration);

            // ========================================
            // 12. HALAMAN REGISTER
            // ========================================
            $browser->visit('/register')
                ->pause($this->pauseDuration)
                ->assertSee('Daftar')
                ->pause($this->pauseDuration);

            // Isi form register (demo saja, tidak submit)
            $browser->type('name', 'User Baru')
                ->pause($this->pauseDuration)
                ->type('email', 'userbaru@resepin.com')
                ->pause($this->pauseDuration)
                ->type('password', 'Password123!')
                ->pause($this->pauseDuration)
                ->type('password_confirmation', 'Password123!')
                ->pause($this->pauseDuration);

            // ========================================
            // SELESAI
            // ========================================
            $browser->visit('/dashboard')
                ->pause(2000); // Pause lebih lama di akhir
        });
    }
}
