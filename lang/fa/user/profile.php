<?php

return [
    'title' => 'پروفایل',
    'management' => 'مدیریت پروفایل',
    'description' => 'مدیریت اطلاعات پروفایل شما',

    'fields' => [
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'full_name' => 'نام کامل',
        'email' => 'ایمیل',
        'phone_number' => 'شماره تلفن',
        'country_code' => 'کد کشور',
        'last_login' => 'آخرین ورود',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ بروزرسانی',
    ],

    'messages' => [
        'updated' => 'پروفایل با موفقیت بروزرسانی شد.',
        'password_updated' => 'رمز عبور با موفقیت بروزرسانی شد.',
        'update_failed' => 'خطا در بروزرسانی پروفایل.',
        'password_update_failed' => 'خطا در بروزرسانی رمز عبور.',
    ],

    'navigation' => [
        'panel' => 'پنل کاربری',
        'dashboard' => 'داشبورد',
        'profile' => 'پروفایل',
        'price_inquiries' => 'استعلامات قیمت',
        'home' => 'خانه',
    ],

    'header' => [
        'user_menu' => 'منوی کاربر',
        'profile' => 'پروفایل',
        'logout' => 'خروج',
    ],

    'show' => [
        'title' => 'پروفایل',
        'header_title' => 'پروفایل من',
        'description' => 'مشاهده اطلاعات پروفایل شما',
        'personal_info' => 'اطلاعات شخصی',
        'activity_info' => 'اطلاعات فعالیت',
        'avatar_card_title' => 'تصویر پروفایل',
        'labels' => [
            'never_logged_in' => 'هرگز',
            'email_verified' => 'ایمیل تأیید شده',
            'verified' => 'تأیید شده',
            'not_verified' => 'تأیید نشده',
        ],
        'buttons' => [
            'edit' => 'ویرایش پروفایل',
        ],
    ],

    'forms' => [
        'edit' => [
            'title' => 'ویرایش پروفایل',
            'header_title' => 'ویرایش پروفایل',
            'description' => 'بروزرسانی اطلاعات پروفایل شما',
            'card_title' => 'اطلاعات پروفایل',
            'avatar_card_title' => 'تصویر پروفایل',
            'submit' => 'بروزرسانی پروفایل',
            'change_email' => 'تغییر ایمیل',
            'change_phone' => 'تغییر شماره تلفن',
        ],
        'password' => [
            'title' => 'تغییر رمز عبور',
            'header_title' => 'تغییر رمز عبور',
            'description' => 'بروزرسانی رمز عبور حساب کاربری شما',
            'card_title' => 'تغییر رمز عبور',
            'current_password' => 'رمز عبور فعلی',
            'new_password' => 'رمز عبور جدید',
            'confirm_password' => 'تأیید رمز عبور جدید',
            'submit' => 'بروزرسانی رمز عبور',
            'placeholders' => [
                'current_password' => 'رمز عبور فعلی را وارد کنید',
                'new_password' => 'رمز عبور جدید را وارد کنید',
                'confirm_password' => 'رمز عبور جدید را تأیید کنید',
            ],
        ],
        'placeholders' => [
            'first_name' => 'نام را وارد کنید',
            'last_name' => 'نام خانوادگی را وارد کنید',
            'email' => 'آدرس ایمیل را وارد کنید',
            'phone_number' => 'شماره تلفن را وارد کنید',
            'country_code' => 'کد کشور را وارد کنید',
        ],
    ],

    'breadcrumbs' => [
        'dashboard' => 'داشبورد',
        'profile' => 'پروفایل',
        'edit' => 'ویرایش',
        'password' => 'تغییر رمز عبور',
    ],
];
