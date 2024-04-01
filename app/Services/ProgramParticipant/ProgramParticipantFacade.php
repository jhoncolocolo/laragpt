<?php

namespace App\Services\ProgramParticipant;
use Illuminate\Support\Facades\Facade;


class ProgramParticipantFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return 'ProgramParticipantService';
    }
}
