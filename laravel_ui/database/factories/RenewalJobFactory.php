<?php

namespace Database\Factories;

use App\Models\RenewalJob;
use App\Models\RenewalPlan;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RenewalJob>
 */
class RenewalJobFactory extends Factory
{
    protected $model = RenewalJob::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'renewal_plan_id' => RenewalPlan::factory(),
            'subscription_id' => Subscription::factory(),
            'msisdn' => $this->faker->numerify('##########'),
            'status' => $this->faker->randomElement(['queued', 'processing', 'done', 'failed']),
            'queued_at' => $this->faker->dateTime(),
            'processed_at' => $this->faker->optional()->dateTime(),
        ];
    }
}

