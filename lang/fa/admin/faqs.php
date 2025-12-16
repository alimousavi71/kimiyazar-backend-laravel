<?php

return [
    'title' => 'سوالات متداول',
    'management' => 'مدیریت سوالات متداول',
    'description' => 'مدیریت تمام سوالات متداول سیستم',
    'add_new' => 'افزودن سوال جدید',

    'fields' => [
        'id' => 'شناسه',
        'question' => 'سوال',
        'answer' => 'پاسخ',
        'is_published' => 'وضعیت انتشار',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ به‌روزرسانی',
    ],

    'status' => [
        'published' => 'منتشر شده',
        'unpublished' => 'منتشر نشده',
    ],

    'messages' => [
        'created' => 'سوال با موفقیت ایجاد شد.',
        'updated' => 'سوال با موفقیت به‌روزرسانی شد.',
        'deleted' => 'سوال با موفقیت حذف شد.',
        'not_found' => 'سوال یافت نشد.',
        'delete_failed' => 'حذف سوال با خطا مواجه شد.',
    ],

    'forms' => [
        'create' => [
            'title' => 'ایجاد سوال جدید',
            'header_title' => 'ایجاد سوال جدید',
            'description' => 'افزودن یک سوال جدید به سوالات متداول',
            'card_title' => 'اطلاعات سوال',
            'submit' => 'ایجاد سوال',
        ],
        'edit' => [
            'title' => 'ویرایش سوال',
            'header_title' => 'ویرایش سوال',
            'description' => 'به‌روزرسانی اطلاعات سوال',
            'card_title' => 'اطلاعات سوال',
            'submit' => 'به‌روزرسانی سوال',
        ],
        'placeholders' => [
            'question' => 'سوال را وارد کنید',
            'answer' => 'پاسخ را وارد کنید',
        ],
        'labels' => [
            'publish_question' => 'انتشار این سوال',
        ],
        'breadcrumbs' => [
            'dashboard' => 'داشبورد',
            'faqs' => 'سوالات متداول',
            'create' => 'ایجاد',
            'edit' => 'ویرایش',
            'details' => 'جزئیات',
        ],
    ],

    'show' => [
        'title' => 'جزئیات سوال',
        'header_title' => 'جزئیات سوال',
        'description' => 'نمایش اطلاعات سوال',
        'question_info' => 'اطلاعات سوال',
        'timestamps' => 'زمان‌بندی‌ها',
        'quick_actions' => 'اقدامات سریع',
        'buttons' => [
            'edit' => 'ویرایش سوال',
            'back_to_list' => 'بازگشت به فهرست',
        ],
    ],

    'table' => [
        'empty' => 'سوالی یافت نشد.',
        'actions' => 'اقدامات',
    ],

    'index' => [
        'title' => 'سوالات متداول',
        'header_title' => 'سوالات متداول',
        'description' => 'مدیریت تمام سوالات متداول',
        'table_title' => 'لیست سوالات',
    ],
];
