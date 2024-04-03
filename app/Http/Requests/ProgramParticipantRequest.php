<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use App\Rules\EntityIdValid;

class ProgramParticipantRequest extends FormRequest
{
   /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'program_id' => 'required|integer|exists:programs,id',
            'entity_type' => ['required', Rule::in(['App\Models\User', 'App\Models\Challenge', 'App\Models\Company'])],
            'entity_id' => ['required','integer',
                         new EntityIdValid($this->input('entity_type'))
            ],
        ];
    }

    public function messages()
    {
        return [
            'program_id.required' => 'The field Program is Required',
            'program_id.exists' => 'The field Program Not exists in database',
            'entity_type.required' => 'The entity type is required.',
            'entity_type.in' => 'The entity type must be one of the following: App\Models\User, App\Models\Challenge or App\Models\Company.',
            'entity_id.required' => 'The entity ID is required.',
            'entity_id.integer' => 'The entity ID must be an integer.',
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(
                ['message' => 'Validation exception',
                'errors' => $errors ], 405
            )
        );
    }
}
