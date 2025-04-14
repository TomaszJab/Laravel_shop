<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\OrderProduct;
use App\Models\User;
use App\Models\Comment;
use App\Models\PersonalDetails;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'personal_details_id' => PersonalDetails::factory(), 
            'method_delivery' => fake()->name(),
            'method_payment' => fake()->name(),
            'promo_code' => fake()->name(),
            'delivery' => fake()->numerify('###'),
            'payment' => fake()->numerify('###'),
            'subtotal' => fake()->numerify('###'),
            'total' => fake()->numerify('###'),
        ];
    }
}
