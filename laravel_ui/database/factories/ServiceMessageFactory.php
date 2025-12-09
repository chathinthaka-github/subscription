<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\ServiceMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceMessage>
 */
class ServiceMessageFactory extends Factory
{
    protected $model = ServiceMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'message_type' => $this->faker->randomElement(['FPMT', 'RENEWAL']),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'message' => $this->faker->sentence(20),
            'price_code' => $this->faker->optional()->bothify('PRICE###'),
        ];
    }
}

