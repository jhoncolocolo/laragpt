<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(25)->create();
        \App\Models\Challenge::factory(45)->create();
        \App\Models\Company::factory(35)->create();
        \App\Models\Program::factory(15)->create();
        \App\Models\ProgramParticipant::factory(50)->create();
    }
}
