<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 month', '+3 month'),
            'time' => $this->faker->time('H:i'),
            'appointment_type_id' => AppointmentType::factory(),
        ];
    }

    public function reserved(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => AppointmentStatus::Reserved,
                'customer_id' => Customer::factory(),
            ];
        });
    }

    public function confirmed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => AppointmentStatus::Confirmed,
                'customer_id' => Customer::factory(),
            ];
        });
    }
}
