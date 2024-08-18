<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // company id
            'company_id' => 1,
            // user id
            'user_id' => 1,
            // shift id
            'shift_id' => 1,

            // leave id
            'leave_id' => null,
            // leave type id
            'leave_type_id' =>  null,
            // holiday id
            'holiday_id' => null,

            'date' => $this->faker->date(),
            'clock_in_date_time' => $this->faker->dateTime(),
            'clock_out_date_time' => $this->faker->dateTime(),
            'total_duration' => $this->faker->numberBetween(0, 10),
            'is_late' => 0,
            'is_half_day' => 0,
            'is_paid' => 1,
            'status' => 'present',
            'reason' => $this->faker->sentence(),
        ];
    }
}
