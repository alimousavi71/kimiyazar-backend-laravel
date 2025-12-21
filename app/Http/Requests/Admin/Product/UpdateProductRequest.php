<?php

namespace App\Http\Requests\Admin\Product;

use App\Enums\Database\ProductStatus;
use App\Enums\Database\ProductUnit;
use App\Enums\Database\CurrencyCode;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request class for updating an existing product
 */
class UpdateProductRequest extends FormRequest
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
        $productId = $this->route('id');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'sale_description' => ['sometimes', 'nullable', 'string'],
            'unit' => ['sometimes', 'required', Rule::enum(ProductUnit::class)],
            'category_id' => [
                'sometimes',
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'is_published' => ['sometimes', 'boolean'],
            'body' => ['sometimes', 'nullable', 'string'],
            'price_label' => ['sometimes', 'nullable', 'string', 'max:255'],
            'meta_title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'meta_description' => ['sometimes', 'nullable', 'string'],
            'meta_keywords' => ['sometimes', 'nullable', 'string'],
            'status' => ['sometimes', 'required', Rule::enum(ProductStatus::class)],
            'sort_order' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'current_price' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'currency_code' => ['sometimes', 'nullable', Rule::enum(CurrencyCode::class)],
            'price_updated_at' => ['sometimes', 'nullable', 'date'],
            'price_effective_date' => ['sometimes', 'nullable', 'date'],
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

        if (!$this->has('is_published')) {
            $this->merge(['is_published' => false]);
        }
    }
}
