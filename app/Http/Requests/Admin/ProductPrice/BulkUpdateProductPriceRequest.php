<?php

namespace App\Http\Requests\Admin\ProductPrice;

use App\Enums\Database\CurrencyCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request class for bulk updating product prices
 */
class BulkUpdateProductPriceRequest extends FormRequest
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
            'prices' => ['required', 'array'],
            'prices.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'prices.*.price' => ['required', 'numeric', 'min:0'],
            'prices.*.currency_code' => ['required', Rule::enum(CurrencyCode::class)],
        ];
    }
}
