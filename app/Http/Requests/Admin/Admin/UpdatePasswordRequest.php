<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request class for updating admin password
 */
class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
        return [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.required' => __('validation.required', ['attribute' => __('admin/admins.fields.password')]),
            'password.min' => __('validation.min.string', ['attribute' => __('admin/admins.fields.password'), 'min' => 8]),
            'password.confirmed' => __('validation.confirmed', ['attribute' => __('admin/admins.fields.password')]),
        ];
    }
}

