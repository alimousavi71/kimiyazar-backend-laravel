<?php

namespace App\Http\Requests\PriceInquiry;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePriceInquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Both guest and authenticated users can submit
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'products' => ['required', 'array', 'min:1', 'max:5'],
            'products.*' => ['required', 'integer', Rule::exists('products', 'id')->where('is_published', true)],
            'captcha' => ['required', 'captcha'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'captcha.required' => __('price-inquiry.validation.captcha_required'),
            'captcha.captcha' => __('price-inquiry.validation.captcha_invalid'),
        ];
    }
}
