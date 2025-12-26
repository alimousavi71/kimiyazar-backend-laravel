<?php

namespace App\Http\Requests\Admin\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuRequest extends FormRequest
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
        $menuId = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menus', 'name')->ignore($menuId),
            ],
            'type' => ['required', 'in:quick_access,services,custom'],
            'links' => ['nullable', 'array'],
            'links.*.id' => ['required', 'string'],
            'links.*.title' => ['required', 'string', 'max:255'],
            'links.*.url' => ['required', 'string', 'max:500'],
            'links.*.type' => ['required', 'in:custom,content'],
            'links.*.content_id' => ['nullable', 'integer', 'exists:contents,id'],
            'links.*.order' => ['required', 'integer', 'min:1'],
        ];
    }
}
