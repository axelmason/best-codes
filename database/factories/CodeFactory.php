<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'image' => 'default.png',
            'code' => '#'.fake()->text(10),
            'title' => fake()->text(30),
            'description' => fake()->realText(300),
            'activate_url' => fake()->url(),
            'user_id' => User::all()->random()->id
        ];
    }
}
