<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Program;
use App\Models\ProgramParticipant;
use App\Models\User;
use App\Models\Challenge;
use App\Models\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramParticipant>
*/
class ProgramParticipantFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return  array
     */
    public function definition()
    {
        // Possible entities
        $entityTypes = ['App\Models\User', 'App\Models\Challenge', 'App\Models\Company'];

        $entitiableType = $this->faker->randomElement($entityTypes);
        $entitiableId = null;

        switch ($entitiableType) {
            case 'App\Models\User':
                $entitiableId = User::getRandomId();
                break;
            case 'App\Models\Challenge':
                $entitiableId = Challenge::getRandomId();
                break;
            case 'App\Models\Company':
                $entitiableId = Company::getRandomId();
                break;
        }
        $programId = Program::inRandomOrder()->first()->id;

        $newArray = [
                'program_id' =>$programId,
                'entitiable_type' => $entitiableType,
                'entitiable_id' => $entitiableId,
        ];

        return $newArray;
    }
}


