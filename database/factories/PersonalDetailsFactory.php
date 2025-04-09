<?php

namespace Database\Factories;
use App\Models\personalDetails;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\personalDetails>
 */
class PersonalDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // lub null, jeśli nie zawsze musi być
            'email' => $this->faker->unique()->safeEmail(),
            'firstName' => $this->faker->firstName(),
            'lastName' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'company_name' => $this->faker->company(),
            'company_or_private_person' => $this->faker->randomElement(['company', 'private']),
            'nip' => $this->faker->numerify('##########'),
            'street' => $this->faker->streetName(),
            'house_number' => $this->faker->buildingNumber(),
            'zip_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'additional_information' => $this->faker->optional()->sentence(),
            'acceptance_of_the_regulations' => true,
            'acceptance_of_the_invoice' => $this->faker->boolean(),
            'default_personal_details' => $this->faker->boolean(30), // np. 30% szans
        ];
    }
}
