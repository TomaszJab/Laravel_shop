<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\CategoryProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Example Product',
            'price' => 99.99,
            'detail' => 'This is a sample product description.',
            'favorite' => 1,
            //'category_products_id' => 1, // Przypisanie do konkretnej kategorii
            'created_at' => now(),
            'updated_at' => now(),
        ];
        // return [
        //     'name' => $this->faker->word,
        //     'price' => $this->faker->randomFloat(2, 10, 1000),
        //     'detail' => $this->faker->sentence,
        //     'category_products_id' => \App\Models\CategoryProduct::factory(),
        // ];
    }
}
