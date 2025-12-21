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
            // No validation needed for sync operation
        ];
    }
}
