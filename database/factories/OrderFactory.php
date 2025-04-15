<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\CategoryProduct;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'order_product_id' => OrderProduct::factory(),
            'name' => fake()->name(),
            'quantity' => fake()->numerify('###'),
            'price' => fake()->numerify('###'),
            'size' => fake()->name(),
            'category_products_id' => CategoryProduct::factory(),
        ];
    }
}
