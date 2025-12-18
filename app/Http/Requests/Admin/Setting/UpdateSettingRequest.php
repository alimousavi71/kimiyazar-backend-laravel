<?php

namespace App\Http\Requests\Admin\Setting;

use App\Enums\Database\SettingKey;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request class for updating settings
 */
class UpdateSettingRequest extends FormRequest
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
        $rules = [
            'settings' => ['required', 'array'],
        ];

        // Add validation rules for each setting key based on enum definition
        foreach (SettingKey::cases() as $key) {
            $rules["settings.{$key->value}"] = $key->validationRules();
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Ensure settings is an array
        if (!$this->has('settings')) {
            $this->merge(['settings' => []]);
        }

        // Collect all setting keys from request
        $settings = [];
        $validKeys = SettingKey::values();

        foreach ($validKeys as $key) {
            if ($this->has($key)) {
                $settings[$key] = $this->input($key);
            }
        }

        // Merge with existing settings array if present
        if ($this->has('settings') && is_array($this->input('settings'))) {
            $settings = array_merge($settings, $this->input('settings'));
        }

        $this->merge(['settings' => $settings]);
    }
}
