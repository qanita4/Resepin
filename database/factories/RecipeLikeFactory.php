<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\RecipeLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\RecipeLike>
 */
class RecipeLikeFactory extends Factory
{
    protected $model = RecipeLike::class;

    public function definition(): array
    {
        return [
            'recipe_id' => Recipe::factory(),
            'user_id' => User::factory(),
        ];
    }
}
