<?php

namespace App\Http\Requests\Order;

use App\Enums\Database\ProductUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLegalOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Basic contact information
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            
            // Company legal information
            'company_name' => ['required', 'string', 'max:255'],
            'economic_code' => ['required', 'string', 'max:12', 'regex:/^[0-9]+$/'],
            'registration_number' => ['required', 'integer'],
            'official_gazette_photo' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
            
            // Delivery address
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'state_id' => ['required', 'integer', 'exists:states,id'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'size:10', 'regex:/^[0-9]+$/'],
            'address' => ['required', 'string', 'max:1000'],
            'receiver_full_name' => ['required', 'string', 'max:255'],
            'delivery_method' => ['required', 'string', 'in:post,courier,in_person'],
            
            // Product details
            'quantity' => ['required', 'integer', 'min:1', 'max:999999'],
            'unit' => ['required', Rule::in(array_column(ProductUnit::cases(), 'value'))],
            'product_description' => ['nullable', 'string', 'max:1000'],

            // Security
            'captcha' => ['required', 'captcha'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        // Auto-fill from authenticated user
        if (auth()->check()) {
            $user = auth()->user();
            $this->merge([
                'full_name' => $user->first_name . ' ' . $user->last_name,
                'phone' => $user->phone_number ?? '',
                'email' => $user->email,
            ]);
        }
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => __('orders.validation.full_name_required'),
            'phone.required' => __('orders.validation.phone_required'),
            'company_name.required' => __('orders.validation.company_name_required'),
            'economic_code.required' => __('orders.validation.economic_code_required'),
            'economic_code.regex' => __('orders.validation.economic_code_numeric'),
            'registration_number.required' => __('orders.validation.registration_number_required'),
            'official_gazette_photo.required' => __('orders.validation.official_gazette_required'),
            'official_gazette_photo.mimes' => __('orders.validation.official_gazette_mimes'),
            'official_gazette_photo.max' => __('orders.validation.file_max'),
            'country_id.required' => __('orders.validation.country_required'),
            'state_id.required' => __('orders.validation.state_required'),
            'city.required' => __('orders.validation.city_required'),
            'postal_code.required' => __('orders.validation.postal_code_required'),
            'postal_code.size' => __('orders.validation.postal_code_size'),
            'address.required' => __('orders.validation.address_required'),
            'receiver_full_name.required' => __('orders.validation.receiver_name_required'),
            'delivery_method.required' => __('orders.validation.delivery_method_required'),
            'quantity.required' => __('orders.validation.quantity_required'),
            'unit.required' => __('orders.validation.unit_required'),
            'captcha.required' => __('orders.validation.captcha_required'),
            'captcha.captcha' => __('orders.validation.captcha_invalid'),
        ];
    }
}
