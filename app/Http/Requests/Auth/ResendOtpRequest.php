<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResendOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'otp_id' => ['required', 'integer', 'exists:otps,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'otp_id.required' => 'OTP ID is required',
            'otp_id.exists' => 'Invalid OTP ID',
        ];
    }
}
