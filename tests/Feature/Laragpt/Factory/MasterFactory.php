<?php

namespace Tests\Feature\Laragpt\Factory;

use Faker\Generator as Faker;
use Tests\TestCase;
use App\Models\User;

class MasterFactory
{

    public function __construct()
    {
    }

    public static function createBase(): MasterFactory
    {
        $faker = \Faker\Factory::create();
        try {

            //Users
            User::create([
                'name' => $faker->userName(),
                'email' => $faker->unique()->safeEmail(),
                'image_path' => $faker->text(255),
            ]);



        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            echo $e;
        }

        return new MasterFactory();
    }
}
