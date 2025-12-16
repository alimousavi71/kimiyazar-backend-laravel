<?php

namespace App\Http\Requests\Admin\Banner;

use App\Enums\Database\BannerPosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBannerRequest extends FormRequest
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
        $position = $this->input('position');
        $dimensions = $position ? config('banner.positions.' . $position, ['width' => 1200, 'height' => 300]) : ['width' => 1200, 'height' => 300];

        $bannerFileRules = [
            'sometimes',
            'image',
            'mimes:jpeg,png,jpg,webp',
            'max:5120',
        ];

        // Add dimensions validation only if banner_file is provided
        if ($this->hasFile('banner_file')) {
            $bannerFileRules[] = 'dimensions:width=' . $dimensions['width'] . ',height=' . $dimensions['height'];
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'banner_file' => $bannerFileRules,
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
        if (empty($this->target_type)) {
            $this->merge(['target_type' => null, 'target_id' => null]);
        }
    }
}
