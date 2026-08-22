<?php

namespace Database\Factories;

use App\Models\Confession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Confession>
 */
class ConfessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraph(),
            'is_hidden' => false,
        ];
    }
}
