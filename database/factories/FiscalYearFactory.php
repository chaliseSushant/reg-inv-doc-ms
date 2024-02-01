<?php

namespace Database\Factories;

use App\Models\FiscalYear;
use Faker\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FiscalYear>
 */
class FiscalYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = FiscalYear::class;

    public function definition()
    {
        $faker = Factory::create();
        return [
            'year' => $faker->sentence(2),
            'active' => 1
        ];
    }
}
