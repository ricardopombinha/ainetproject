<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScreeningFormRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'time' => ['sometimes', 'required'],
            'theater' => ['sometimes','required'],
            'timeFrame' => ['sometimes','required'],
            'dateLast' => ['sometimes','required', 'date'],
            'time13' => ['sometimes','nullable'],
            'time14' => ['sometimes','nullable'],
            'time16' => ['sometimes','nullable'],
            'time19' => ['sometimes','nullable'],
            'time21' => ['sometimes','nullable'],
            'time22' => ['sometimes','nullable'],
        ];

        return $rules;
    }
}
