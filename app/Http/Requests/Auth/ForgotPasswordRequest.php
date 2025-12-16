<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email_or_phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $isEmail = filter_var($value, FILTER_VALIDATE_EMAIL);
                    $isPhone = preg_match('/^(\+?98|0)?9\d{9}$/', $value);

                    if (!$isEmail && !$isPhone) {
                        $fail(__('auth.validation.email_or_phone_format'));
                    }

                    // Check if user exists
                    $userExists = \App\Models\User::where('email', $value)
                        ->orWhere('phone_number', $value)
                        ->exists();

                    if (!$userExists) {
                        // For security, don't reveal if user exists or not
                        // Still pass validation
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email_or_phone.required' => __('auth.validation.email_or_phone_required'),
        ];
    }
}
