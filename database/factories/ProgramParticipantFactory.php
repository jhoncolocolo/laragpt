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

        $entityType = $this->faker->randomElement($entityTypes);
        $entityId = null;

        switch ($entityType) {
            case 'App\Models\User':
                $entityId = User::getRandomId();
                break;
            case 'App\Models\Challenge':
                $entityId = Challenge::getRandomId();
                break;
            case 'App\Models\Company':
                $entityId = Company::getRandomId();
                break;
        }
        $programId = Program::inRandomOrder()->first()->id;

        $newArray = [
                'program_id' =>$programId,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
        ];

        return $newArray;
    }
}


