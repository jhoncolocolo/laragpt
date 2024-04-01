<?php

namespace App\Services\Challenge;
use Illuminate\Support\Facades\Facade;


class ChallengeFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return 'ChallengeService';
    }
}
