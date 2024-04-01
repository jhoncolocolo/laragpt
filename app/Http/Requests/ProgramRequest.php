<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ProgramRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El título es requerido.',
            'title.string' => 'El título debe ser una cadena de caracteres.',
            'description.required' => 'La descripción es requerida.',
            'description.string' => 'La descripción debe ser una cadena de caracteres.',
            'start_date.required' => 'La fecha de inicio es requerida.',
            'start_date.date_format' => 'El formato de fecha de inicio debe ser YYYY-MM-DD.',
            'end_date.required' => 'La fecha de finalización es requerida.',
            'end_date.date_format' => 'El formato de fecha de finalización debe ser YYYY-MM-DD.',
            'end_date.after' => 'La fecha de finalización debe ser posterior a la fecha de inicio.',
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
