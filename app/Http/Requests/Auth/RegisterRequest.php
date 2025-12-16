<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'unique:users,email', 'required_without:phone_number'],
            'phone_number' => ['nullable', 'string', 'max:20', 'unique:users,phone_number', 'required_without:email'],
            'country_code' => ['nullable', 'string', 'max:5', 'required_with:phone_number'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required_without' => 'Email or phone number is required.',
            'phone_number.required_without' => 'Email or phone number is required.',
            'country_code.required_with' => 'Country code is required when providing a phone number.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}