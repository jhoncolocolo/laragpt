<?php

namespace Tests\Feature\Laragpt\Factory;
use Illuminate\Support\Facades\File;
use App\Models\Program;
use App\Models\Challenge;
use App\Models\Company;

class TablesDependentFactory
{

    public $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public static function createTables($table_create_data): TablesDependentFactory
    {
        try {

           $table = $table_create_data;
           $tables = ['challenges','companies','programs'];
            if (in_array($table_create_data, $tables))
            {
                foreach ($tables as $curren_table) {
                    if($curren_table == $table_create_data){

                        // programs
                        if($table == "programs"){
                            Program::factory(10)->create();
                        }

                        // challenges
                        if($table == "challenges"){
                            Challenge::factory(15)->create();
                        }
                        // companies
                        if($table == "companies"){
                            Company::factory(25)->create();
                        }
                    }
                }
            }
            else
            {
                return false;
            }

        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            echo $e;
        }

        return new TablesDependentFactory($table);
    }
}
