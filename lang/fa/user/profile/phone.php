<?php

return [
    'messages' => [
        'otp_sent' => 'کد OTP به شماره تلفن جدید شما ارسال شد.',
        'otp_resent' => 'کد OTP دوباره به شماره تلفن جدید شما ارسال شد.',
        'phone_updated' => 'شماره تلفن شما با موفقیت بروزرسانی شد.',
        'session_expired' => 'جلسه شما منقضی شده است. لطفاً دوباره شروع کنید.',
        'invalid_otp' => 'کد OTP نامعتبر است. لطفاً دوباره تلاش کنید.',
    ],

    'forms' => [
        'edit' => [
            'title' => 'تغییر شماره تلفن',
            'header_title' => 'تغییر شماره تلفن',
            'description' => 'بروزرسانی شماره تلفن با تأیید OTP',
            'card_title' => 'تغییر شماره تلفن',
            'current_phone' => 'شماره تلفن فعلی:',
            'no_phone' => 'هیچ شماره تلفنی تنظیم نشده است',
            'country_code' => 'کد کشور',
            'phone_number' => 'شماره تلفن',
            'placeholder_country_code' => 'مثال: +98',
            'placeholder_phone_number' => 'شماره تلفن را وارد کنید',
            'submit' => 'ارسال کد OTP',
        ],
    ],

    'verify' => [
        'title' => 'تأیید تغییر شماره تلفن',
        'header_title' => 'تأیید تغییر شماره تلفن',
        'description' => 'کد OTP ارسال شده به شماره تلفن جدید خود را وارد کنید',
        'card_title' => 'تأیید کد OTP',
        'sent_to' => 'کد ارسال شده به:',
        'code_label' => 'کد OTP',
        'submit' => 'تأیید و بروزرسانی شماره تلفن',
        'resend' => 'ارسال مجدد کد OTP',
        'resend_timer' => 'ارسال مجدد کد در :seconds ثانیه',
        'sending' => 'در حال ارسال...',
    ],
];
