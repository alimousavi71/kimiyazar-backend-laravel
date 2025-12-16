<?php

return [
    'register' => [
        'title' => 'ثبت‌نام',
        'subtitle' => 'برای شروع ایمیل یا شماره موبایل خود را وارد کنید',
        'submit' => 'ادامه',
        'have_account' => 'حساب کاربری دارید؟',
        'login_link' => 'ورود',
    ],

    'verify_otp' => [
        'title' => 'تأیید کد یکبار مصرف',
        'subtitle_email' => 'کد تأیید به ایمیل شما ارسال شد',
        'subtitle_sms' => 'کد تأیید به شماره موبایل شما ارسال شد',
        'sent_to' => 'ارسال شده به',
        'code_label' => 'کد تأیید',
        'code_placeholder' => 'کد 6 رقمی را وارد کنید',
        'submit' => 'تأیید کد',
        'resend' => 'ارسال مجدد کد',
        'resend_timer' => 'ارسال مجدد در :seconds ثانیه',
        'back_to_register' => 'بازگشت به ثبت‌نام',
    ],

    'complete_registration' => [
        'title' => 'تکمیل ثبت‌نام',
        'subtitle' => 'رمز عبور خود را تعیین کنید',
        'verified_contact' => 'تأیید شده',
        'submit' => 'تکمیل ثبت‌نام',
    ],

    'login' => [
        'title' => 'ورود',
        'welcome' => 'خوش آمدید',
        'subtitle' => 'به حساب کاربری خود وارد شوید',
        'remember_me' => 'مرا به خاطر بسپار',
        'forgot_password' => 'رمز عبور را فراموش کرده‌اید؟',
        'submit' => 'ورود',
        'no_account' => 'حساب کاربری ندارید؟',
        'register_link' => 'ثبت‌نام کنید',
    ],

    'forgot_password' => [
        'title' => 'فراموشی رمز عبور',
        'subtitle' => 'کد تأیید برای شما ارسال می‌شود',
        'submit' => 'ارسال کد تأیید',
        'back_to_login' => 'بازگشت به ورود',
    ],

    'reset_password' => [
        'title' => 'بازنشانی رمز عبور',
        'subtitle' => 'رمز عبور جدید خود را وارد کنید',
        'submit' => 'تغییر رمز عبور',
        'back_to_login' => 'بازگشت به ورود',
    ],

    'fields' => [
        'email_or_phone' => 'ایمیل یا شماره موبایل',
        'email' => 'ایمیل',
        'phone' => 'شماره موبایل',
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'password' => 'رمز عبور',
        'password_confirmation' => 'تأیید رمز عبور',
        'code' => 'کد تأیید',
    ],

    'placeholders' => [
        'email_or_phone' => 'ایمیل یا شماره موبایل خود را وارد کنید',
        'email' => 'example@domain.com',
        'phone' => '09123456789',
        'first_name' => 'نام خود را وارد کنید',
        'last_name' => 'نام خانوادگی خود را وارد کنید',
        'password' => 'رمز عبور خود را وارد کنید',
        'password_confirmation' => 'رمز عبور را دوباره وارد کنید',
        'code' => '123456',
    ],

    'messages' => [
        'registration_initiated' => 'کد تأیید برای شما ارسال شد.',
        'otp_verified' => 'کد با موفقیت تأیید شد.',
        'registration_completed' => 'ثبت‌نام شما با موفقیت تکمیل شد.',
        'login_successful' => 'خوش آمدید!',
        'logout_successful' => 'شما با موفقیت خارج شدید.',
        'reset_link_sent' => 'کد بازیابی برای شما ارسال شد.',
        'password_reset_successful' => 'رمز عبور شما با موفقیت تغییر کرد.',
        'invalid_credentials' => 'ایمیل/موبایل یا رمز عبور اشتباه است.',
        'account_inactive' => 'حساب کاربری شما غیرفعال است.',
        'user_already_exists' => 'این ایمیل یا شماره موبایل قبلاً ثبت شده است.',
        'user_not_found' => 'کاربری با این مشخصات یافت نشد.',
        'invalid_otp' => 'کد وارد شده صحیح نیست.',
        'otp_expired' => 'کد منقضی شده است.',
        'otp_max_attempts' => 'تعداد تلاش‌های مجاز تمام شد. کد جدید درخواست کنید.',
        'otp_already_used' => 'این کد قبلاً استفاده شده است.',
        'otp_resent' => 'کد جدید برای شما ارسال شد.',
        'session_expired' => 'جلسه شما منقضی شده است. لطفاً دوباره تلاش کنید.',
        'attempts_remaining' => 'تلاش باقی‌مانده',
    ],

    'validation' => [
        'email_or_phone_required' => 'ایمیل یا شماره موبایل الزامی است.',
        'email_or_phone_format' => 'فرمت ایمیل یا شماره موبایل صحیح نیست.',
        'password_required' => 'رمز عبور الزامی است.',
        'password_min' => 'رمز عبور باید حداقل 8 کاراکتر باشد.',
        'password_confirmed' => 'تأیید رمز عبور مطابقت ندارد.',
        'code_required' => 'کد تأیید الزامی است.',
        'code_numeric' => 'کد تأیید باید عدد باشد.',
        'code_digits' => 'کد تأیید باید 6 رقم باشد.',
    ],

    'password_requirements' => [
        'title' => 'الزامات رمز عبور',
        'min_length' => 'حداقل 8 کاراکتر',
        'contains_letter' => 'شامل حروف',
        'contains_number' => 'شامل اعداد',
    ],
];
