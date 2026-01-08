<?php

namespace App\Http\Requests\Admin\Modal;

use App\Traits\ConvertsPersianNumbers;
use Illuminate\Foundation\Http\FormRequest;
use Morilog\Jalali\Jalalian;

class UpdateModalRequest extends FormRequest
{
    use ConvertsPersianNumbers;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'content' => ['sometimes', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:500', 'url'],
            'close_text' => ['sometimes', 'string', 'max:100'],
            'is_rememberable' => ['sometimes', 'boolean'],
            'modalable_type' => ['nullable', 'string', 'max:255'],
            'modalable_id' => ['nullable', 'integer', 'min:1'],
            'is_published' => ['sometimes', 'boolean'],
            'start_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'end_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'priority' => ['sometimes', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'start_at' => $this->convertJalaliDate(
                $this->input('start_at'),
                '00:00:00'
            ),
            'end_at' => $this->convertJalaliDate(
                $this->input('end_at'),
                '23:59:59'
            ),
        ]);
    }

    /**
     * Convert Jalali date (with Persian/Arabic numbers) to Gregorian datetime
     */
    protected function convertJalaliDate(?string $value, string $time): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            // Normalize numbers
            $value = $this->faToEnNumbers(trim($value));

            // Extract date part only (YYYY/MM/DD)
            $datePart = explode(' ', $value)[0];

            return Jalalian::fromFormat('Y/m/d', $datePart)
                ->toCarbon()
                ->format('Y-m-d') . ' ' . $time;
        } catch (\Throwable) {
            return null;
        }
    }
}
