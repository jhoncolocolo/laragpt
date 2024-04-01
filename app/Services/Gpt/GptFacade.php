<?php

namespace App\Services\Gpt;
use Illuminate\Support\Facades\Facade;


class GptFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return 'GptService';
    }
}
