<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(30),
            'document_number' => $this->faker->numerify,
            'remarks' => $this->faker->text(191),
            'attribute' => $this->faker->numberBetween(0,3). '-' . $this->faker->numberBetween(0,2),
            'fiscal_year_id' => 5,
            'created_at' => $this->faker->dateTimeBetween('-2 months','now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months','now'),
        ];
    }
}
