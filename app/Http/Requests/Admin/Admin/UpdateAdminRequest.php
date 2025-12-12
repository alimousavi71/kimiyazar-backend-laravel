<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Validation\Rule;

/**
 * Request class for updating an existing admin
 */
class UpdateAdminRequest extends StoreAdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $adminId = $this->route('id');
        $rules = parent::rules();

        // Make fields optional for update (add 'sometimes')
        $rules['first_name'] = ['sometimes', 'required', 'string', 'max:255'];
        $rules['last_name'] = ['sometimes', 'required', 'string', 'max:255'];

        // Update email rule to ignore current admin
        $rules['email'] = [
            'sometimes',
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('admins', 'email')->ignore($adminId),
        ];

        // Remove password from update (handled separately)
        unset($rules['password']);

        return $rules;
    }
}

