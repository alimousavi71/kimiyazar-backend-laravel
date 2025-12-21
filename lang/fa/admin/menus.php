<?php

return [
    'title' => 'منوها',
    'management' => 'مدیریت منوها',
    'description' => 'مدیریت منوها و لینک‌های سیستم',
    'add_new' => 'افزودن منوی جدید',
    'links' => 'لینک',

    'fields' => [
        'name' => 'نام منو',
        'links' => 'لینک‌ها',
        'links_count' => 'تعداد لینک‌ها',
        'link_type' => 'نوع لینک',
        'title' => 'عنوان',
        'url' => 'آدرس',
        'select_content' => 'انتخاب صفحه',
        'order' => 'ترتیب',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ بروزرسانی',
    ],

    'link_types' => [
        'custom' => 'سفارشی',
        'content' => 'صفحه محتوا',
    ],

    'messages' => [
        'created' => 'منو با موفقیت ایجاد شد.',
        'updated' => 'منو با موفقیت بروزرسانی شد.',
        'deleted' => 'منو با موفقیت حذف شد.',
        'not_found' => 'منو یافت نشد.',
        'delete_failed' => 'خطا در حذف منو.',
        'update_failed' => 'خطا در بروزرسانی منو.',
        'create_failed' => 'خطا در ایجاد منو.',
        'no_links' => 'لینکی وجود ندارد.',
        'links_saved' => 'لینک‌ها با موفقیت ذخیره شدند.',
        'save_failed' => 'خطا در ذخیره لینک‌ها.',
        'confirm_delete_link' => 'آیا از حذف این لینک اطمینان دارید؟',
        'links_updated' => 'لینک‌ها با موفقیت بروزرسانی شدند.',
    ],

    'buttons' => [
        'add_link' => 'افزودن لینک',
    ],

    'forms' => [
        'create' => [
            'title' => 'ایجاد منوی جدید',
            'header_title' => 'ایجاد منوی جدید',
            'description' => 'یک منوی جدید ایجاد کنید',
            'card_title' => 'اطلاعات منو',
        ],
        'edit' => [
            'title' => 'ویرایش منو',
            'header_title' => 'ویرایش منو',
            'description' => 'اطلاعات منو را ویرایش کنید',
            'menu_info' => 'اطلاعات منو',
            'links_manager' => 'مدیریت لینک‌ها',
        ],
        'breadcrumbs' => [
            'dashboard' => 'داشبورد',
            'menus' => 'منوها',
            'create' => 'ایجاد',
            'edit' => 'ویرایش',
            'details' => 'جزئیات',
        ],
        'placeholders' => [
            'name' => 'نام منو را وارد کنید',
            'link_title' => 'عنوان لینک را وارد کنید',
            'select_content' => 'صفحه را انتخاب کنید',
        ],
    ],

    'modal' => [
        'add_link' => 'افزودن لینک',
        'edit_link' => 'ویرایش لینک',
    ],

    'show' => [
        'title' => 'جزئیات منو',
        'header_title' => 'جزئیات منو',
        'description' => 'اطلاعات کامل منو',
        'menu_info' => 'اطلاعات منو',
        'links' => 'لینک‌ها',
    ],
];
