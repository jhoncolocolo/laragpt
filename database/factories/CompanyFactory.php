<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
*/
class CompanyFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return  array
     */
    public function definition()
    {
        return[
            'name' => $this->faker->company,
            'image_path' => $this->faker->imageUrl(width:620,height:480),
            'location' => $this->faker->city,
            'industry' => $this->faker->catchPhrase,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
