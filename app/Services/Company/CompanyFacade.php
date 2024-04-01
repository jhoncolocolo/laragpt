<?php

namespace App\Services\Company;
use Illuminate\Support\Facades\Facade;


class CompanyFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return 'CompanyService';
    }
}
