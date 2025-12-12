<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request class for updating the authenticated admin's profile
 */
class UpdateProfileRequest extends FormRequest
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
        $admin = auth('admin')->user() ?? auth()->user();
        $adminId = $admin ? $admin->id : null;

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('admins', 'email')->ignore($adminId),
            ],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}

