<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules =  [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'nif' => ['sometimes','nullable','string', 'max:9'],
            'payment_type' => ['sometimes'],
            'photo_file'=> ['sometimes', 'image', 'max:8192'],
        ];

        if(strtoupper($this->payment_type) == "PAYPAL"){
            $rules = array_merge($rules, [
                'payment_ref' => ['sometimes','required','string','email', 'lowercase']
            ]);
        }
        elseif(strtoupper($this->payment_type) == 'MBWAY'){
            $rules = array_merge($rules, [
                'payment_ref' => ['sometimes','required','string','size:9','regex:/^[9]\d{8}$/']
            ]);
        }
        elseif(strtoupper($this->payment_type) == 'VISA'){
            $rules = array_merge($rules, [
                'payment_ref' => ['sometimes','required','string','size:16', 'regex:/^\d{16}$/']
            ]);
        }
        else{
            $rules = array_merge($rules, [
                'payment_ref' => ['sometimes','size:0']
            ]);
        }

        return $rules;
    }
}
