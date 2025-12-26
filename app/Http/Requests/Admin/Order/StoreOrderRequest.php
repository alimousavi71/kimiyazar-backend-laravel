<?php

namespace App\Http\Requests\Admin\Order;

use App\Enums\Database\ProductUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request class for storing a new order
 */
class StoreOrderRequest extends FormRequest
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
            'customer_type' => ['required', 'in:real,legal'],
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
            'unit' => ['required_with:quantity', Rule::in(array_column(ProductUnit::cases(), 'value'))],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'product_description' => ['nullable', 'string', 'max:255'],

            // Payment information
            'payment_bank_id' => ['nullable', 'integer', 'exists:banks,id'],
            'payment_type' => ['required', 'in:online_gateway,bank_deposit,wallet,pos,cash_on_delivery'],
            'total_payment_amount' => ['nullable', 'string'],
            'payment_date' => ['nullable', 'string'],
            'payment_time' => ['nullable', 'string'],

            // Administration & status
            'admin_note' => ['nullable', 'string'],
            'status' => ['required', 'in:pending_payment,paid,processing,shipped,delivered,cancelled,returned'],
            'is_registered_service' => ['sometimes', 'boolean'],
            'is_viewed' => ['sometimes', 'boolean'],
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
        if (!$this->has('is_photo_sent')) {
            $this->merge(['is_photo_sent' => false]);
        }

        if (!$this->has('is_registered_service')) {
            $this->merge(['is_registered_service' => false]);
        }

        if (!$this->has('is_viewed')) {
            $this->merge(['is_viewed' => false]);
        }

        if (!$this->has('unit')) {
            $this->merge(['unit' => ProductUnit::PIECE->value]);
        }

        if (!$this->has('payment_type')) {
            $this->merge(['payment_type' => 'online_gateway']);
        }

        if (!$this->has('status')) {
            $this->merge(['status' => 'pending_payment']);
        }
    }
}
