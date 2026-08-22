<?php

namespace Database\Factories;

use App\Models\ConsultationBooking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ConsultationBooking>
 */
class ConsultationBookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'couple_name' => $this->faker->name().' & '.$this->faker->firstName(),
            'whatsapp' => '080'.$this->faker->numerify('########'),
            'email' => $this->faker->safeEmail(),
            'notes' => $this->faker->sentence(),
            'status' => ConsultationBooking::STATUS_PENDING,
        ];
    }
}
