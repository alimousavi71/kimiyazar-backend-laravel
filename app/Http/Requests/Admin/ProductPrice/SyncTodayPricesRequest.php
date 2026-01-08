<?php

namespace App\Http\Requests\Admin\ProductPrice;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request class for syncing today's prices
 */
class SyncTodayPricesRequest extends FormRequest
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
            'prices' => ['required', 'array', 'min:1'],
            'prices.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'prices.*.price' => ['required', 'numeric', 'min:0'],
            'prices.*.currency_code' => ['required', \Illuminate\Validation\Rule::enum(\App\Enums\Database\CurrencyCode::class)],
        ];
    }
}
