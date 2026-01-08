<?php

namespace App\Http\Requests\Admin\Modal;

use App\Traits\ConvertsPersianNumbers;
use Illuminate\Foundation\Http\FormRequest;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class StoreModalRequest extends FormRequest
{
    use ConvertsPersianNumbers;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
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
        // Defaults
        $this->merge([
            'close_text' => $this->input('close_text', 'بستن'),
            'is_rememberable' => $this->input('is_rememberable', true),
            'is_published' => $this->input('is_published', false),
            'priority' => $this->input('priority', 0),
            'start_at' => $this->convertJalaliDate($this->input('start_at'), '00:00:00'),
            'end_at' => $this->convertJalaliDate($this->input('end_at'), '23:59:59'),
        ]);
    }

    public function messages(): array
    {
        return [
            'end_at.after_or_equal' => __('validation.after_or_equal', [
                'attribute' => __('admin/modals.fields.end_at'),
                'date' => __('admin/modals.fields.start_at'),
            ]),
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!$this->input('start_at') || !$this->input('end_at')) {
                return;
            }

            if (
                Carbon::parse($this->input('end_at'))
                    ->lt(Carbon::parse($this->input('start_at')))
            ) {
                $validator->errors()->add(
                    'end_at',
                    __('validation.after_or_equal', [
                        'attribute' => __('admin/modals.fields.end_at'),
                        'date' => __('admin/modals.fields.start_at'),
                    ])
                );
            }
        });
    }

    /**
     * Convert Jalali date (Persian/Arabic numbers) to Gregorian datetime
     */
    protected function convertJalaliDate(?string $value, string $time): ?string
    {
        try {
            $value = $this->faToEnNumbers(trim($value));
            $datePart = explode(' ', $value)[0];

            return Jalalian::fromFormat('Y/m/d', $datePart)
                ->toCarbon()
                ->format('Y-m-d') . ' ' . $time;
        } catch (\Throwable) {
            return null;
        }
    }
}
