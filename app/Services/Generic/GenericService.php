<?php

namespace App\Services\Generic;
use App\Repositories\Generic\GenericRepository;

class GenericService
{

    /*
    * cleanStringForConvertions
    * Function for clean String for operation with strings
    * @param  $string String
    * return String
    */
    public function cleanStringForConvertions($string) {
        $string = str_replace(['\n', '\r', '\t'], '', $string);
        $string = str_replace('```json', '', $string);
        $string = str_replace('```', '', $string);
        return $string;
    }
}
