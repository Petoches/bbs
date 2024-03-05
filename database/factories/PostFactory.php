<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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
        $is_video = fake()->boolean;

        return [
            'instagram_id' => fake()->unique()->randomNumber(),
            'shortcode' => 'CFRxN5eqRir',
            'display_url' => fake()->imageUrl,
            'video_url' => $is_video ? fake()->url : null,
            'description' => fake()->text,
            'likes' => fake()->randomNumber(),
            'is_video' =>  $is_video,
        ];
    }
}
