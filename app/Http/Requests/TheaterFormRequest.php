<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TheaterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'name' => ['required', 'string', 'max:255'],
            'photo_file' => ['sometimes', 'image', 'max:4096'],
            'seats' => ['sometimes','integer','between:6,12'],
            'rows' => ['sometimes','integer','between:7,15'],
        ];

        return $rules;
    }

    /*public function messages(): array
        {
        return [
        'seats.between' => 'ECTS is required',
        'seats.between' => 'ECTS must be an integer',
        ];
    }*/
}
