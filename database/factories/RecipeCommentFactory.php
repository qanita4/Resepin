<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\RecipeComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\RecipeComment>
 */
class RecipeCommentFactory extends Factory
{
    protected $model = RecipeComment::class;

    public function definition(): array
    {
        return [
            'recipe_id' => Recipe::factory(),
            'user_id' => User::factory(),
            'comment' => $this->faker->sentence(),
        ];
    }
}
