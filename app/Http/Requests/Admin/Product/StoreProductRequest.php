<?php

namespace App\Http\Requests\Admin\Product;

use App\Enums\Database\ProductStatus;
use App\Enums\Database\ProductUnit;
use App\Enums\Database\CurrencyCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request class for storing a new product
 */
class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'sale_description' => ['nullable', 'string'],
            'unit' => ['required', Rule::enum(ProductUnit::class)],
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'is_published' => ['sometimes', 'boolean'],
            'body' => ['nullable', 'string'],
            'price_label' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(ProductStatus::class)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'current_price' => ['nullable', 'numeric', 'min:0'],
            'currency_code' => ['nullable', Rule::enum(CurrencyCode::class)],
            'price_updated_at' => ['nullable', 'date'],
            'price_effective_date' => ['nullable', 'date'],
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
        if (!$this->has('sort_order')) {
            $this->merge(['sort_order' => 0]);
        }

        if (!$this->has('is_published')) {
            $this->merge(['is_published' => false]);
        }

        if (!$this->has('status')) {
            $this->merge(['status' => ProductStatus::DRAFT->value]);
        }
    }
}
