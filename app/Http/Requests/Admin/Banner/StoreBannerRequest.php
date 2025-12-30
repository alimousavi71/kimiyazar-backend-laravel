<?php

namespace App\Http\Requests\Admin\Banner;

use App\Enums\Database\BannerPosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBannerRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'banner_file' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120',
            ],
            'link' => ['nullable', 'string', 'max:500', 'url'],
            'position' => ['required', 'string', Rule::enum(BannerPosition::class)],
            'target_type' => ['nullable', 'string', 'max:50'],
            'target_id' => ['nullable', 'integer', 'required_with:target_type'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if (!$this->has('is_active')) {
            $this->merge(['is_active' => true]);
        }

        if (empty($this->target_type)) {
            $this->merge(['target_type' => null, 'target_id' => null]);
        }
    }
}
