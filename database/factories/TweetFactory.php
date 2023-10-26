<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tweet>
 */
class TweetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message'=> fake()->sentence(),
            'like'=> fake()->numberBetween(0,80),
            'numOfComments' => fake()->numberBetween(0,150)
        ];
    }
}
