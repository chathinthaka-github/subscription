<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'msisdn' => $this->faker->numerify('##########'),
            'service_id' => Service::factory(),
            'status' => $this->faker->randomElement(['pending', 'active', 'suspended', 'cancelled']),
            'subscribed_at' => $this->faker->dateTime(),
            'last_renewal_at' => $this->faker->optional()->dateTime(),
            'next_renewal_at' => $this->faker->optional()->dateTime(),
        ];
    }
}

