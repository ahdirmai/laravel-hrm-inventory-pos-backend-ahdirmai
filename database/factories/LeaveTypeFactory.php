<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeaveType>
 */
class LeaveTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => 1,
            'name' => fake()->word(),
            'is_paid' => 1,
            'total_leave' => fake()->numberBetween(0, 20),
            'max_leave_per_month' => fake()->numberBetween(0, 10),
            'created_by' => 1,
        ];
    }
}
