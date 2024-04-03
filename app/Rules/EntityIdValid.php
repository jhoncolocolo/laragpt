<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use App\Models\Challenge;
use App\Models\Company;

class EntityIdValid implements Rule
{
    protected $entityType;
    protected $value;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($entityType)
    {
        $this->entityType = $entityType;
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
        // Check if an entity exists with the given entity_id and entity_type
        switch ($this->entityType) {
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
        return  'The :attribute '.$this->value.' not exists in entity_type ' . $this->entityType;
    }
}
