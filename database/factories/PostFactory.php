<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'description' => $this->faker->optional()->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'author_id' => null, // This will be set later if needed
            'category_id' => $this->faker->numberBetween(1, 10), // This will be set later if needed
            'image' => $this->faker->imageUrl(640, 480, 'nature', true),
            'published_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'views' => $this->faker->numberBetween(0, 11000)
        ];
    }
}
