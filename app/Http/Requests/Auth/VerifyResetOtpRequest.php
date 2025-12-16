<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyResetOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'size:6', 'regex:/^\d{6}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => __('auth.validation.code_required'),
            'code.numeric' => __('auth.validation.code_numeric'),
            'code.size' => __('auth.validation.code_digits'),
            'code.regex' => __('auth.validation.code_digits'),
        ];
    }
}
