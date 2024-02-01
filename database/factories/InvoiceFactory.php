<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'invoice_number' => $this->faker->numberBetween(1,400),
            'invoice_datetime' => $this->faker->dateTime(),
            //'registration_number' => $this->faker->numberBetween(1,400),
            'receiver' => $this->faker->name(),
            'sender' => $this->faker->name(),
            'attender_book_number' => $this->faker->numberBetween(1,400),
            'subject' => $this->faker->sentence(4),
            'medium' => $this->faker->numberBetween(1,3),
            'remarks' => $this->faker->sentence(4),
            'fiscal_year_id' => $this->faker->numberBetween(1,5),
            'created_at' => $this->faker->dateTimeBetween('-2 months','now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months','now'),
        ];
    }
}
