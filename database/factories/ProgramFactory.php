<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
*/
class ProgramFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return  array
     */
    public function definition()
    {
        $start_date = $this->faker->date($format = 'Y-m-d', $max = 'now');

        return[
            'title' => $this->faker->word,
            'description' => $this->faker->sentence,
            'start_date' => $start_date,
            'end_date' => Carbon::parse($start_date)->addDays($this->faker->numberBetween(0, 14)),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
