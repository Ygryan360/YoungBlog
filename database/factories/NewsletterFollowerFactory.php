<?php

namespace Database\Factories;

use App\Models\NewsletterFollower;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NewsletterFollower>
 */
class NewsletterFollowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'verified' => $this->faker->boolean(),
            'is_register' => $this->faker->boolean(),
            'token' => $this->faker->uuid(),
        ];
    }
}
