<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ChallengeRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string',
            'difficulty' => 'required|integer|min:1|max:3',
            'user_id' => 'required|exists:users,id'
        ];

        return $rules;
    }

    public function messages(){
        return [
            'title.required' => 'The field Title is Required',
            'difficulty.integer' => 'The page should be a integer',
            'difficulty.min' => 'The Value of Dificulty cannot be less than 1',
            'difficulty.max' => 'The Difficulty Value cannot be higher than 3',
            'user_id.required' => 'The field User is Required',
            'user_id.exists' => 'The field User Not exists in database',
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
