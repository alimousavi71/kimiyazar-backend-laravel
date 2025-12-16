<?php

return [
    'title' => 'کاربران',
    'management' => 'مدیریت کاربران',
    'description' => 'مدیریت تمام کاربران سیستم',
    'add_new' => 'افزودن کاربر جدید',

    'fields' => [
        'id' => 'شناسه',
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'full_name' => 'نام کامل',
        'email' => 'ایمیل',
        'phone_number' => 'شماره تلفن',
        'country_code' => 'کد کشور',
        'password' => 'رمز عبور',
        'password_confirmation' => 'تأیید رمز عبور',
        'is_active' => 'وضعیت',
        'last_login' => 'آخرین ورود',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ به‌روزرسانی',
    ],

    'status' => [
        'active' => 'فعال',
        'inactive' => 'غیرفعال',
    ],

    'messages' => [
        'created' => 'کاربر با موفقیت ایجاد شد.',
        'updated' => 'کاربر با موفقیت به‌روزرسانی شد.',
        'deleted' => 'کاربر با موفقیت حذف شد.',
        'not_found' => 'کاربر یافت نشد.',
        'delete_failed' => 'حذف کاربر با خطا مواجه شد.',
        'password_changed' => 'رمز عبور کاربر با موفقیت تغییر کرد.',
        'activated' => 'کاربر فعال شد.',
        'deactivated' => 'کاربر غیرفعال شد.',
    ],

    'forms' => [
        'create' => [
            'title' => 'ایجاد کاربر جدید',
            'header_title' => 'ایجاد کاربر جدید',
            'description' => 'افزودن یک کاربر جدید به سیستم',
            'card_title' => 'اطلاعات کاربر',
            'submit' => 'ایجاد کاربر',
        ],
        'edit' => [
            'title' => 'ویرایش کاربر',
            'header_title' => 'ویرایش کاربر',
            'description' => 'به‌روزرسانی اطلاعات کاربر',
            'card_title' => 'اطلاعات کاربر',
            'submit' => 'به‌روزرسانی کاربر',
        ],
        'change_password' => [
            'title' => 'تغییر رمز عبور',
            'header_title' => 'تغییر رمز عبور کاربر',
            'description' => 'تغییر رمز عبور کاربر به رمز جدید',
            'card_title' => 'رمز عبور جدید',
            'submit' => 'تغییر رمز عبور',
        ],
        'placeholders' => [
            'first_name' => 'نام را وارد کنید',
            'last_name' => 'نام خانوادگی را وارد کنید',
            'email' => 'آدرس ایمیل را وارد کنید',
            'country_code' => 'کد کشور را وارد کنید (مثال: +98)',
            'phone_number' => 'شماره تلفن را وارد کنید',
            'password' => 'رمز عبور را وارد کنید',
            'password_confirmation' => 'رمز عبور را دوباره وارد کنید',
            'new_password' => 'رمز عبور جدید را وارد کنید',
            'confirm_password' => 'رمز عبور جدید را تأیید کنید',
        ],
        'messages' => [
            'password_requirements' => 'رمز عبور باید حداقل 8 کاراکتر باشد',
        ],
        'labels' => [
            'active_user' => 'فعال کردن این کاربر',
        ],
        'breadcrumbs' => [
            'dashboard' => 'داشبورد',
            'users' => 'کاربران',
            'create' => 'ایجاد',
            'edit' => 'ویرایش',
            'change_password' => 'تغییر رمز عبور',
            'details' => 'جزئیات',
        ],
    ],

    'show' => [
        'title' => 'جزئیات کاربر',
        'header_title' => 'جزئیات کاربر',
        'description' => 'نمایش اطلاعات کاربر',
        'user_info' => 'اطلاعات کاربر',
        'timestamps' => 'زمان‌بندی‌ها',
        'quick_actions' => 'اقدامات سریع',
        'buttons' => [
            'edit' => 'ویرایش کاربر',
            'back_to_list' => 'بازگشت به فهرست',
        ],
    ],

    'table' => [
        'empty' => 'کاربری یافت نشد.',
        'actions' => 'عملیات',
    ],

    'index' => [
        'title' => 'کاربران',
        'header_title' => 'کاربران',
        'description' => 'مدیریت تمام کاربران',
        'table_title' => 'لیست کاربران',
    ],

    'buttons' => [
        'change_password' => 'تغییر رمز عبور',
        'view_profile' => 'مشاهده پروفایل',
    ],

    'labels' => [
        'full_phone' => 'شماره تلفن کامل',
        'changing_password_for' => 'تغییر رمز عبور برای',
    ],
];
