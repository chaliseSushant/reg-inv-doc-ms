<?php

namespace Database\Factories;

use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Registration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sender' => $this->faker->name,
            'medium' => $this->faker->numberBetween(1,2),
            'fiscal_year_id' => $this->faker->numberBetween(1,5),
            'registration_date' => $this->faker->date('Y-m-d','now'),
            'invoice_date' => $this->faker->date('Y-m-d','now'),
            'registration_number' => $this->faker->numberBetween(1,400),
            'letter_number' => $this->faker->numberBetween(1,400),
            'invoice_number' => $this->faker->numberBetween(1,400),
            //'receiver' => $this->faker->name(),
            'subject' => $this->faker->sentence(4),
            'service_id' => $this->faker->numberBetween(1,10),
            //'document_id' => $this->faker->numberBetween(1,10),
            'user_id' => $this->faker->numberBetween(1,3),
            /*'confidential' => $this->faker->numberBetween(0,1),
            'urgent' => $this->faker->numberBetween(0,1),*/
            'remarks' => $this->faker->sentence(4),
            'complete' => false,
            //'attribute' => $this->faker->numberBetween(0,3). '-' . $this->faker->numberBetween(0,2)
            'created_at' => $this->faker->dateTimeBetween('-2 months','now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months','now'),
        ];
    }
}
