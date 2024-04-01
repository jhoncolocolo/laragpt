<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Challenge>
*/
class ChallengeFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return  array
     */
    public function definition()
    {
        return[
            'title' => $this->faker->sentence,
            'description' => $this->faker->text(),
            'difficulty' => $this->faker->randomElement([1, 2, 3]),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
