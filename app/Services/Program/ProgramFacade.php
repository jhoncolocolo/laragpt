<?php

namespace App\Services\Program;
use Illuminate\Support\Facades\Facade;


class ProgramFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return 'ProgramService';
    }
}
