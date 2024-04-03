<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use App\Models\Challenge;
use App\Models\Company;

class EntitiableIdValid implements Rule
{
    protected $entitiableType;
    protected $value;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($entitiableType)
    {
        $this->entitiableType = $entitiableType;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->value = $value;
        // Check if an entitiable exists with the given entitiable_id and entitiable_type
        switch ($this->entitiableType) {
            case 'App\Models\User':
                return User::where('id', $value)->exists();
            case 'App\Models\Challenge':
                return Challenge::where('id', $value)->exists();
            case 'App\Models\Company':
                return Company::where('id', $value)->exists();
            default:
                return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  'The :attribute '.$this->value.' not exists in entitiable_type ' . $this->entitiableType;
    }
}
