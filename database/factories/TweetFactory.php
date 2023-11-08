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
            'message' => fake()->sentence(),
            'user_id' => 1,
            'file' => 'files\/W0LX4iDQ9DK0MDzz4elGq15oq8AMsUS0NntqKpCz.png',
            'tweet_id'=>fake()->numberBetween(1,20),
            'like' => fake()->numberBetween(0, 80),
            'numOfComments' => fake()->numberBetween(0, 150),
            'views' => fake()->numberBetween(0, 1000),
            'shares' => fake()->numberBetween(0, 40)
        ];
    }
}
