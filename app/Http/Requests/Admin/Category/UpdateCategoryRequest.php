<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request class for updating an existing category
 */
class UpdateCategoryRequest extends FormRequest
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
        $categoryId = $this->route('id');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'parent_id' => [
                'nullable',
                'integer',
                // Allow 0 (no parent). Validate existence only when > 0.
                function ($attribute, $value, $fail) {
                    if ($value === null || $value === '' || (int) $value === 0) {
                        return;
                    }
                    $exists = Category::where('id', $value)->whereNull('deleted_at')->exists();
                    if (!$exists) {
                        $fail(__('admin/categories.messages.parent_id_not_self'));
                    }
                },
                // Prevent category from being its own parent
                function ($attribute, $value, $fail) use ($categoryId) {
                    if ($value == $categoryId) {
                        $fail(__('admin/categories.messages.parent_id_not_self'));
                    }
                },
            ],
            'sort_order' => ['sometimes', 'nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if (!$this->has('sort_order')) {
            $this->merge(['sort_order' => 0]);
        }

        if (!$this->has('is_active')) {
            $this->merge(['is_active' => false]);
        }
    }
}
