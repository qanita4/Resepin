<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    /**
     * Daftar nama resep Indonesia
     */
    private array $recipeNames = [
        'Nasi Goreng Spesial',
        'Rendang Daging Sapi',
        'Sate Ayam Madura',
        'Gado-Gado Betawi',
        'Soto Ayam Lamongan',
        'Bakso Malang',
        'Mie Goreng Jawa',
        'Ayam Geprek',
        'Pecel Lele',
        'Nasi Uduk',
        'Es Cendol',
        'Pisang Goreng',
        'Bubur Ayam',
        'Rawon Surabaya',
        'Tahu Gejrot',
        'Siomay Bandung',
        'Kwetiau Goreng',
        'Opor Ayam',
        'Nasi Liwet',
        'Es Teler',
        'Pempek Palembang',
        'Martabak Manis',
        'Gulai Kambing',
        'Sop Buntut',
        'Klepon Pandan',
        'Tempe Goreng Tepung',
        'Capcay Sayur',
        'Ikan Bakar Sambal',
        'Ayam Bakar Taliwang',
        'Sop Iga Sapi',
    ];

    /**
     * Daftar nama chef Indonesia
     */
    private array $chefNames = [
        'Juna',
        'Arnold',
        'Renatta',
        'Fatmah',
        'Bondan',
        'Sisca',
        'Marinka',
        'Haryo',
        'Rudy',
        'William',
    ];

    public function definition(): array
    {
        $title = $this->faker->unique()->randomElement($this->recipeNames);
        $slug = Str::slug($title);
        
        // Download image from picsum and save to storage
        $imageUrl = 'https://picsum.photos/seed/' . $slug . '/900/600';
        $imageContent = @file_get_contents($imageUrl);
        $imagePath = 'recipes/' . $slug . '.jpg';
        
        if ($imageContent) {
            Storage::disk('public')->put($imagePath, $imageContent);
        }

        return [
            'user_id' => User::factory(),
            'slug' => $slug,
            'title' => $title,
            'chef' => $this->faker->randomElement($this->chefNames),
            'initial_rating' => $this->faker->randomFloat(1, 3.5, 5),
            'description' => 'Resep ' . strtolower($title) . ' yang lezat dan mudah dibuat di rumah.',
            'image' => $imagePath,
            'duration' => $this->faker->randomElement([15, 20, 30, 45, 60, 90]) . ' menit',
            'servings' => $this->faker->numberBetween(2, 6) . ' porsi',
            'difficulty' => $this->faker->randomElement(['Mudah', 'Sedang', 'Sulit']),
            'category' => $this->faker->randomElement(['sarapan', 'makan siang', 'makan malam', 'minuman', 'camilan', 'dessert']),
            'ingredients' => [
                'Bawang merah 5 siung',
                'Bawang putih 3 siung', 
                'Cabai merah 3 buah',
                'Garam secukupnya',
                'Minyak goreng',
            ],
            'steps' => [
                'Siapkan semua bahan-bahan.',
                'Haluskan bumbu dengan blender atau ulekan.',
                'Panaskan minyak, tumis bumbu hingga harum.',
                'Masak hingga matang dan sajikan.',
            ],
        ];
    }
}
