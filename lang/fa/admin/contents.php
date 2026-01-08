<?php

return [
    'title' => 'محتوا',
    'management' => 'مدیریت محتوا',
    'description' => 'مدیریت تمام محتوای سیستم',
    'add_new' => 'افزودن محتوای جدید',

    'types' => [
        'news' => 'خبر',
        'article' => 'مقاله',
        'page' => 'صفحه',
    ],

    'fields' => [
        'type' => 'نوع',
        'title' => 'عنوان',
        'slug' => 'نامک',
        'body' => 'محتوا',
        'seo_description' => 'توضیحات SEO',
        'seo_keywords' => 'کلمات کلیدی SEO',
        'is_active' => 'وضعیت',
        'visit_count' => 'تعداد بازدید',
        'is_undeletable' => 'غیرقابل حذف',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ به‌روزرسانی',
    ],

    'status' => [
        'active' => 'فعال',
        'inactive' => 'غیرفعال',
    ],

    'messages' => [
        'created' => 'محتوا با موفقیت ایجاد شد.',
        'updated' => 'محتوا با موفقیت به‌روزرسانی شد.',
        'deleted' => 'محتوا با موفقیت حذف شد.',
        'not_found' => 'محتوا یافت نشد.',
        'delete_failed' => 'حذف محتوا با خطا مواجه شد.',
        'image_uploaded' => 'تصویر با موفقیت آپلود شد.',
        'image_upload_failed' => 'آپلود تصویر با خطا مواجه شد.',
    ],

    'forms' => [
        'create' => [
            'title' => 'ایجاد محتوا',
            'header_title' => 'ایجاد محتوا',
            'description' => 'افزودن یک محتوای جدید',
            'card_title' => 'اطلاعات محتوا',
            'submit' => 'ایجاد محتوا',
        ],
        'edit' => [
            'title' => 'ویرایش محتوا',
            'header_title' => 'ویرایش محتوا',
            'description' => 'به‌روزرسانی اطلاعات محتوا',
            'card_title' => 'اطلاعات محتوا',
            'submit' => 'به‌روزرسانی محتوا',
        ],
        'placeholders' => [
            'select_type' => 'نوع را انتخاب کنید',
            'title' => 'عنوان محتوا را وارد کنید',
            'slug' => 'نامک را وارد کنید (اختیاری)',
            'slug_help' => 'در صورت خالی بودن، به صورت خودکار از عنوان تولید می‌شود',
            'body' => 'محتوا را وارد کنید',
            'seo_description' => 'توضیحات SEO را وارد کنید',
            'seo_keywords' => 'کلمات کلیدی SEO را وارد کنید',
        ],
        'labels' => [
            'active_content' => 'محتوا فعال',
            'undeletable_content' => 'محتوا غیرقابل حذف',
        ],
        'breadcrumbs' => [
            'dashboard' => 'داشبورد',
            'contents' => 'محتوا',
            'create' => 'ایجاد',
            'edit' => 'ویرایش',
            'details' => 'جزئیات',
        ],
    ],

    'show' => [
        'title' => 'جزئیات محتوا',
        'header_title' => 'جزئیات محتوا',
        'description' => 'نمایش اطلاعات محتوا',
        'content_info' => 'اطلاعات محتوا',
        'status' => 'وضعیت',
        'timestamps' => 'زمان‌بندی‌ها',
        'quick_actions' => 'اقدامات سریع',
        'buttons' => [
            'edit' => 'ویرایش محتوا',
            'back_to_list' => 'بازگشت به فهرست',
        ],
    ],
];

