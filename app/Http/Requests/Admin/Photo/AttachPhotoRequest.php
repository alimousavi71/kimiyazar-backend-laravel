<?php

namespace App\Http\Requests\Admin\Photo;

use Illuminate\Foundation\Http\FormRequest;

class AttachPhotoRequest extends FormRequest
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
            'photoable_type' => ['required', 'string', 'max:255'],
            'photoable_id' => ['required', 'integer'],
            'photo_ids' => ['required', 'array'],
            'photo_ids.*' => ['required', 'integer'],
        ];
    }
}
