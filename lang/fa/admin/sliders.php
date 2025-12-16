<?php

return [
    'title' => 'اسلایدرها',
    'management' => 'مدیریت اسلایدرها',
    'description' => 'مدیریت تمام اسلایدرهای سیستم',
    'add_new' => 'افزودن اسلایدر جدید',

    'fields' => [
        'title' => 'عنوان',
        'heading' => 'سرتیتر',
        'description' => 'توضیحات',
        'is_active' => 'وضعیت',
        'sort_order' => 'ترتیب نمایش',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ به‌روزرسانی',
    ],

    'status' => [
        'active' => 'فعال',
        'inactive' => 'غیرفعال',
    ],

    'messages' => [
        'created' => 'اسلایدر با موفقیت ایجاد شد.',
        'updated' => 'اسلایدر با موفقیت به‌روزرسانی شد.',
        'deleted' => 'اسلایدر با موفقیت حذف شد.',
        'not_found' => 'اسلایدر یافت نشد.',
        'delete_failed' => 'حذف اسلایدر با خطا مواجه شد.',
        'create_failed' => 'ایجاد اسلایدر با خطا مواجه شد.',
    ],

    'forms' => [
        'create' => [
            'title' => 'ایجاد اسلایدر',
            'header_title' => 'ایجاد اسلایدر',
            'description' => 'افزودن یک اسلایدر جدید',
            'card_title' => 'اطلاعات اسلایدر',
            'submit' => 'ایجاد اسلایدر',
        ],
        'edit' => [
            'title' => 'ویرایش اسلایدر',
            'header_title' => 'ویرایش اسلایدر',
            'description' => 'به‌روزرسانی اطلاعات اسلایدر',
            'card_title' => 'اطلاعات اسلایدر',
            'submit' => 'به‌روزرسانی اسلایدر',
        ],
        'breadcrumbs' => [
            'dashboard' => 'داشبورد',
            'sliders' => 'اسلایدرها',
            'create' => 'ایجاد',
            'edit' => 'ویرایش',
        ],
        'placeholders' => [
            'title' => 'عنوان اسلایدر را وارد کنید',
            'heading' => 'سرتیتر اسلایدر را وارد کنید',
            'description' => 'توضیحات اسلایدر را وارد کنید',
            'sort_order' => 'ترتیب نمایش',
        ],
        'labels' => [
            'active_slider' => 'اسلایدر فعال است',
        ],
    ],

    'show' => [
        'title' => 'جزئیات اسلایدر',
        'header_title' => 'جزئیات اسلایدر',
        'description' => 'مشاهده اطلاعات کامل اسلایدر',
        'slider_info' => 'اطلاعات اسلایدر',
        'status' => 'وضعیت',
        'timestamps' => 'زمان‌بندی',
        'buttons' => [
            'edit' => 'ویرایش',
            'back_to_list' => 'بازگشت به لیست',
        ],
    ],
];

