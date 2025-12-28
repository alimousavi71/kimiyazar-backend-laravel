<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:11', 'regex:/^09\d{9}$/'],
            'email' => ['required', 'email', 'max:255'],
            'text' => ['required', 'string', 'min:10', 'max:2000'],
            'captcha' => ['required', 'captcha'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الزامی است.',
            'title.max' => 'عنوان نباید بیشتر از 255 کاراکتر باشد.',
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.regex' => 'شماره موبایل باید با 09 شروع شود و 11 رقم باشد.',
            'mobile.max' => 'شماره موبایل نباید بیشتر از 11 رقم باشد.',
            'email.required' => 'ایمیل الزامی است.',
            'email.email' => 'فرمت ایمیل نامعتبر است.',
            'email.max' => 'ایمیل نباید بیشتر از 255 کاراکتر باشد.',
            'text.required' => 'متن پیام الزامی است.',
            'text.min' => 'متن پیام باید حداقل 10 کاراکتر باشد.',
            'text.max' => 'متن پیام نباید بیشتر از 2000 کاراکتر باشد.',
            'captcha.required' => 'کد امنیتی الزامی است.',
            'captcha.captcha' => 'کد امنیتی نادرست است. لطفاً دوباره تلاش کنید.',
        ];
    }
}
