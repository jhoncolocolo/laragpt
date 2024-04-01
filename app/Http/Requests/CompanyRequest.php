<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class CompanyRequest extends FormRequest
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
        $rules= [
            'name' => 'required|string',
            'location' => 'required|string',
            'industry' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ];



        return $rules;
    }

    public function messages(){
        return [
            'name.required' => 'The field Name is Required',
            'location.required' => 'The field Location is Required',
            'industry.required' => 'The field Industry is Required',
            'user_id.required' => 'The field User is Required',
            'user_id.exists' => 'The field User Not exists in database'
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
