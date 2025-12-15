<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shortcode' => $this->faker->unique()->numerify('####'),
            'keyword' => $this->faker->unique()->word(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'fpmt_enabled' => $this->faker->boolean(),
        ];
    }
}

