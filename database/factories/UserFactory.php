<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
*/
class UserFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return  array
     */
    public function definition()
    {
        return[
            'name' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'image_path' => $this->faker->imageUrl(width:620,height:480),
        ];
    }
}
