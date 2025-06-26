<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph(),
            'post_id' => $this->faker->numberBetween(1, 30), // This will be set later if needed
            'author_id' => $this->faker->numberBetween(1, 20), // This will be set later if needed
            'parent_id' => null, // This will be set later if needed
        ];
    }
}
