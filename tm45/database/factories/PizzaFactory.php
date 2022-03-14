<?php

namespace Database\Factories;

use App\Models\Pizza;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pizza>
 */
class PizzaFactory extends Factory
{
    protected $model = Pizza::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->unique()->word(),
            'description' => $this->faker->text(10),
            'prix' => $this->faker->numberBetween(1,999),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => now(),
            'deleted_at' =>$this->faker->boolean(90) ? null:now(),
        ];
    }
}
