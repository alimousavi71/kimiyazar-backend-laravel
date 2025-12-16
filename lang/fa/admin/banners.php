<?php

return [
    'title' => 'بنرها',
    'management' => 'مدیریت بنرها',
    'description' => 'مدیریت تمام بنرهای سیستم',
    'add_new' => 'افزودن بنر جدید',

    'fields' => [
        'name' => 'نام',
        'banner_file' => 'فایل بنر',
        'link' => 'لینک',
        'position' => 'موقعیت',
        'target_type' => 'نوع هدف',
        'target_id' => 'شناسه هدف',
        'is_active' => 'وضعیت',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ به‌روزرسانی',
    ],

    'status' => [
        'active' => 'فعال',
        'inactive' => 'غیرفعال',
    ],

    'messages' => [
        'created' => 'بنر با موفقیت ایجاد شد.',
        'updated' => 'بنر با موفقیت به‌روزرسانی شد.',
        'deleted' => 'بنر با موفقیت حذف شد.',
        'not_found' => 'بنر یافت نشد.',
        'delete_failed' => 'حذف بنر با خطا مواجه شد.',
    ],

    'forms' => [
        'create' => [
            'title' => 'ایجاد بنر',
            'header_title' => 'ایجاد بنر',
            'description' => 'افزودن یک بنر جدید',
            'card_title' => 'اطلاعات بنر',
            'submit' => 'ایجاد بنر',
        ],
        'edit' => [
            'title' => 'ویرایش بنر',
            'header_title' => 'ویرایش بنر',
            'description' => 'به‌روزرسانی اطلاعات بنر',
            'card_title' => 'اطلاعات بنر',
            'submit' => 'به‌روزرسانی بنر',
        ],
        'placeholders' => [
            'name' => 'نام بنر را وارد کنید',
            'select_position' => 'موقعیت را انتخاب کنید',
            'banner_file' => 'فایل تصویر بنر را انتخاب کنید',
            'banner_file_update' => 'برای تغییر فایل بنر، فایل جدید را انتخاب کنید',
            'link' => 'لینک بنر را وارد کنید (اختیاری)',
            'target_type' => 'نوع هدف (اختیاری)',
            'target_id' => 'شناسه هدف (اختیاری)',
        ],
        'messages' => [
            'dimensions_info' => 'ابعاد پیشنهادی برای این موقعیت: :width × :height پیکسل',
        ],
        'labels' => [
            'active_banner' => 'بنر فعال',
        ],
        'breadcrumbs' => [
            'dashboard' => 'داشبورد',
            'banners' => 'بنرها',
            'create' => 'ایجاد',
            'edit' => 'ویرایش',
            'details' => 'جزئیات',
        ],
    ],

    'show' => [
        'title' => 'جزئیات بنر',
        'header_title' => 'جزئیات بنر',
        'description' => 'نمایش اطلاعات بنر',
        'banner_info' => 'اطلاعات بنر',
        'timestamps' => 'زمان‌بندی‌ها',
        'quick_actions' => 'اقدامات سریع',
        'buttons' => [
            'edit' => 'ویرایش بنر',
            'back_to_list' => 'بازگشت به فهرست',
        ],
    ],
];

