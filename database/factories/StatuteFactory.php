<?php

namespace Database\Factories;

use App\Models\Statute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statute>
 */
class StatuteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "content" => fake()->name(),
            'valid' => '1',
            'created_at' => fake()->dateTime('2014-02-25 08:37:17')
        ];
    }
}
