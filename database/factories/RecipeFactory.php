<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);

        return [
            'user_id' => User::factory(),
            'slug' => Str::slug($title),
            'title' => $title,
            'chef' => $this->faker->name(),
            'initial_rating' => $this->faker->randomFloat(1, 0, 5),
            'description' => $this->faker->sentence(),
            'image' => null,
            'badge' => null,
            'duration' => $this->faker->numberBetween(10, 120) . ' menit',
            'servings' => $this->faker->numberBetween(1, 6) . ' porsi',
            'difficulty' => $this->faker->randomElement(['mudah', 'sedang', 'sulit']),
            'category' => $this->faker->randomElement(['sarapan', 'makan siang', 'makan malam', 'minuman', 'camilan']),
            'ingredients' => ['garam', 'lada'],
            'steps' => ['siapkan bahan', 'masak'],
        ];
    }
}
