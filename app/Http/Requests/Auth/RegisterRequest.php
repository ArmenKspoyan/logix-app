<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name' => 'The :attribute is required.',
            'last_name' => 'The :attribute is required.',
            'password' => 'The :attribute is required.',
            'email' => 'The :attribute is required.',
        ];
    }
}
