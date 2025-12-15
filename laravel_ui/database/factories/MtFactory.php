<?php

namespace Database\Factories;

use App\Models\Mt;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mt>
 */
class MtFactory extends Factory
{
    protected $model = Mt::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'subscription_id' => Subscription::factory(),
            'msisdn' => $this->faker->numerify('##########'),
            'message_type' => $this->faker->randomElement(['FPMT', 'RENEWAL']),
            'status' => $this->faker->randomElement(['queued', 'success', 'fail']),
            'dn_status' => $this->faker->randomElement(['pending', 'success', 'fail']),
            'dn_details' => $this->faker->optional()->sentence(),
            'price_code' => $this->faker->optional()->bothify('PRICE###'),
            'mt_ref_id' => $this->faker->unique()->bothify('MT#######'),
            'message' => $this->faker->sentence(20),
        ];
    }
}

