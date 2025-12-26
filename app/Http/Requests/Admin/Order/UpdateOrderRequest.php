<?php

namespace App\Http\Requests\Admin\Order;

use App\Enums\Database\ProductUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request class for updating an order
 */
class UpdateOrderRequest extends FormRequest
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
            // Customer type and reference
            'customer_type' => ['sometimes', 'in:real,legal'],
            'member_id' => ['nullable', 'integer', 'exists:users,id'],

            // Individual (real person) information
            'full_name' => ['nullable', 'string', 'max:255'],
            'national_code' => ['nullable', 'string', 'max:255'],
            'national_card_photo' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:255'],
            'is_photo_sent' => ['sometimes', 'boolean'],

            // Legal entity (company) information
            'company_name' => ['nullable', 'string', 'max:255'],
            'economic_code' => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'integer'],
            'official_gazette_photo' => ['nullable', 'string', 'max:255'],

            // Location information
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'state_id' => ['nullable', 'integer', 'exists:states,id'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],

            // Receiver details
            'receiver_full_name' => ['nullable', 'string', 'max:255'],
            'delivery_method' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],

            // Single product details
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'unit' => ['nullable', Rule::in(array_column(ProductUnit::cases(), 'value'))],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'product_description' => ['nullable', 'string', 'max:255'],

            // Payment information
            'payment_bank_id' => ['nullable', 'integer', 'exists:banks,id'],
            'payment_type' => ['sometimes', 'in:online_gateway,bank_deposit,wallet,pos,cash_on_delivery'],
            'total_payment_amount' => ['nullable', 'string'],
            'payment_date' => ['nullable', 'string'],
            'payment_time' => ['nullable', 'string'],

            // Administration & status
            'admin_note' => ['nullable', 'string'],
            'status' => ['sometimes', 'in:pending_payment,paid,processing,shipped,delivered,cancelled,returned'],
            'is_registered_service' => ['sometimes', 'boolean'],
            'is_viewed' => ['sometimes', 'boolean'],
        ];
    }
}
