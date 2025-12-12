<?php

return [
    'title' => 'مدیران',
    'management' => 'مدیریت مدیران',
    'description' => 'مدیریت تمام مدیران سیستم',
    'add_new' => 'افزودن مدیر جدید',

    'fields' => [
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'full_name' => 'نام کامل',
        'email' => 'ایمیل',
        'password' => 'رمز عبور',
        'password_confirmation' => 'تأیید رمز عبور',
        'is_block' => 'وضعیت',
        'last_login' => 'آخرین ورود',
        'avatar' => 'آواتار',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ به‌روزرسانی',
    ],

    'status' => [
        'active' => 'فعال',
        'blocked' => 'مسدود شده',
        'never' => 'هرگز',
    ],

    'messages' => [
        'created' => 'مدیر با موفقیت ایجاد شد.',
        'updated' => 'مدیر با موفقیت به‌روزرسانی شد.',
        'deleted' => 'مدیر با موفقیت حذف شد.',
        'not_found' => 'مدیر یافت نشد.',
        'delete_failed' => 'حذف مدیر با خطا مواجه شد.',
        'password_updated' => 'رمز عبور با موفقیت به‌روزرسانی شد.',
    ],

    'forms' => [
        'create' => [
            'title' => 'ایجاد مدیر',
            'header_title' => 'ایجاد مدیر',
            'description' => 'افزودن مدیر جدید به سیستم',
            'card_title' => 'اطلاعات مدیر',
            'submit' => 'ایجاد مدیر',
        ],
        'edit' => [
            'title' => 'ویرایش مدیر',
            'header_title' => 'ویرایش مدیر',
            'description' => 'به‌روزرسانی اطلاعات مدیر',
            'card_title' => 'اطلاعات مدیر',
            'avatar_card_title' => 'آواتار',
            'submit' => 'به‌روزرسانی مدیر',
        ],
        'password' => [
            'title' => 'تغییر رمز عبور',
            'header_title' => 'تغییر رمز عبور',
            'description' => 'به‌روزرسانی رمز عبور مدیر',
            'card_title' => 'اطلاعات رمز عبور',
            'submit' => 'به‌روزرسانی رمز عبور',
        ],
        'placeholders' => [
            'first_name' => 'نام را وارد کنید',
            'last_name' => 'نام خانوادگی را وارد کنید',
            'email' => 'آدرس ایمیل را وارد کنید',
            'password' => 'رمز عبور را وارد کنید',
            'password_confirmation' => 'تأیید رمز عبور',
            'new_password' => 'رمز عبور جدید را وارد کنید',
            'confirm_new_password' => 'تأیید رمز عبور جدید',
        ],
        'labels' => [
            'block_admin' => 'مسدود کردن این مدیر',
            'upload_avatar' => 'آپلود آواتار',
            'delete_avatar' => 'حذف آواتار',
            'uploading' => 'در حال آپلود...',
            'deleting' => 'در حال حذف...',
        ],
        'breadcrumbs' => [
            'dashboard' => 'داشبورد',
            'admins' => 'مدیران',
            'create' => 'ایجاد',
            'edit' => 'ویرایش',
            'details' => 'جزئیات',
            'password' => 'تغییر رمز عبور',
        ],
    ],

    'show' => [
        'title' => 'جزئیات مدیر',
        'header_title' => 'جزئیات مدیر',
        'description' => 'مشاهده اطلاعات مدیر',
        'personal_info' => 'اطلاعات شخصی',
        'activity_info' => 'اطلاعات فعالیت',
        'avatar_card_title' => 'آواتار',
        'buttons' => [
            'edit' => 'ویرایش مدیر',
            'back_to_list' => 'بازگشت به لیست',
        ],
        'labels' => [
            'email_verified' => 'ایمیل تأیید شده',
            'never_logged_in' => 'هرگز وارد نشده',
            'verified' => 'تأیید شده',
            'not_verified' => 'تأیید نشده',
        ],
        'javascript' => [
            'select_image' => 'لطفاً یک فایل تصویری انتخاب کنید',
            'delete_avatar_confirm' => 'آیا مطمئن هستید که می‌خواهید آواتار را حذف کنید؟',
        ],
    ],
];

