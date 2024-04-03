<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use App\Rules\EntitiableIdValid;

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
            'entitiable_type' => ['required', Rule::in(['App\Models\User', 'App\Models\Challenge', 'App\Models\Company'])],
            'entitiable_id' => ['required','integer',
                         new EntitiableIdValid($this->input('entitiable_type'))
            ],
        ];
    }

    public function messages()
    {
        return [
            'program_id.required' => 'The field Program is Required',
            'program_id.exists' => 'The field Program Not exists in database',
            'entitiable_type.required' => 'The entitiable type is required.',
            'entitiable_type.in' => 'The entitiable type must be one of the following: App\Models\User, App\Models\Challenge or App\Models\Company.',
            'entitiable_id.required' => 'The entitiable ID is required.',
            'entitiable_id.integer' => 'The entitiable ID must be an integer.',
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
