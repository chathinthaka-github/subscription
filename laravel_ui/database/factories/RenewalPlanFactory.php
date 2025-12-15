<?php

namespace Database\Factories;

use App\Models\RenewalPlan;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RenewalPlan>
 */
class RenewalPlanFactory extends Factory
{
    protected $model = RenewalPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $planType = $this->faker->randomElement(['daily', 'weekly', 'monthly']);
        $scheduleRules = match ($planType) {
            'daily' => [
                'plan_type' => 'daily',
                'skip_subscription_day' => false,
                'is_fixed_time' => true,
                'fixed_time' => '10:00',
            ],
            'weekly' => [
                'plan_type' => 'weekly',
                'days' => [1, 3, 5],
                'skip_subscription_day' => false,
                'is_fixed_time' => true,
                'fixed_time' => '10:00',
            ],
            'monthly' => [
                'plan_type' => 'monthly',
                'days' => [1, 15, 30],
                'skip_subscription_day' => false,
                'is_fixed_time' => true,
                'fixed_time' => '10:00',
            ],
        };

        return [
            'service_id' => Service::factory(),
            'name' => $this->faker->words(3, true),
            'plan_type' => $planType,
            'schedule_rules' => $scheduleRules,
            'skip_subscription_day' => false,
            'is_fixed_time' => true,
            'fixed_time' => $this->faker->time('H:i'),
            'start_from' => $this->faker->optional()->dateTime(),
        ];
    }
}

