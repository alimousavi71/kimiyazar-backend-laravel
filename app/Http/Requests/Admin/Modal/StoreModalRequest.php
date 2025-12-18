<?php

namespace App\Http\Requests\Admin\Modal;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request class for storing a new modal
 */
class StoreModalRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:500', 'url'],
            'close_text' => ['sometimes', 'string', 'max:100'],
            'is_rememberable' => ['sometimes', 'boolean'],
            'modalable_type' => ['nullable', 'string', 'max:255'],
            'modalable_id' => ['nullable', 'integer', 'min:1'],
            'is_published' => ['sometimes', 'boolean'],
            'start_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'end_at' => ['nullable', 'date_format:Y-m-d H:i:s', 'after_or_equal:start_at'],
            'priority' => ['sometimes', 'integer', 'min:0'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Set default values
        if (!$this->has('close_text')) {
            $this->merge(['close_text' => 'بستن']);
        }

        if (!$this->has('is_rememberable')) {
            $this->merge(['is_rememberable' => true]);
        }

        if (!$this->has('is_published')) {
            $this->merge(['is_published' => false]);
        }

        if (!$this->has('priority')) {
            $this->merge(['priority' => 0]);
        }
    }
}
