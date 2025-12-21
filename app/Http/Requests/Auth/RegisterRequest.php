<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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

                    // Check if already exists
                    if ($isEmail) {
                        if (User::where('email', $value)->exists()) {
                            $fail(__('auth.messages.user_already_exists'));
                        }
                    } elseif ($isPhone) {
                        if (User::where('phone_number', $value)->exists()) {
                            $fail(__('auth.messages.user_already_exists'));
                        }
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email_or_phone.required' => __('auth.validation.email_or_phone_required'),
            'email_or_phone.string' => __('auth.validation.email_or_phone_format'),
        ];
    }
}
