<?php

namespace App\Services\Generic;
use Illuminate\Support\Facades\Facade;


class GenericFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return 'GenericService';
    }
}
