<?php

return [
    'title' => 'استعلامات قیمت',
    'management' => 'مدیریت استعلامات قیمت',
    'description' => 'مدیریت و بررسی استعلامات قیمت مشتریان',

    'fields' => [
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'full_name' => 'نام کامل',
        'email' => 'ایمیل',
        'phone_number' => 'شماره تلفن',
        'product' => 'محصول',
        'quantity' => 'تعداد',
        'variant' => 'نوع/ویژگی',
        'products' => 'محصولات',
        'products_count' => 'تعداد محصولات',
        'is_reviewed' => 'وضعیت بررسی',
        'user' => 'کاربر',
        'user_id' => 'شناسه کاربر',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ بروزرسانی',
    ],

    'labels' => [
        'registered_user' => 'کاربر ثبت‌نام شده',
        'not_found' => 'یافت نشد',
    ],

    'status' => [
        'reviewed' => 'بررسی شده',
        'pending' => 'در انتظار',
    ],

    'messages' => [
        'status_toggled' => 'وضعیت بررسی با موفقیت بروزرسانی شد.',
        'deleted' => 'استعلام قیمت با موفقیت حذف شد.',
        'delete_confirm' => 'آیا مطمئن هستید که می‌خواهید این استعلام قیمت را حذف کنید؟',
    ],

    'show' => [
        'title' => 'جزئیات استعلام قیمت',
        'header_title' => 'جزئیات استعلام قیمت',
        'description' => 'مشاهده و مدیریت جزئیات استعلام قیمت',
        'contact_info' => 'اطلاعات تماس',
        'products' => 'محصولات',
        'product' => 'محصول',
        'timestamps' => 'زمان‌بندی',
        'quick_actions' => 'عملیات سریع',
        'no_products' => 'محصولی یافت نشد',
        'buttons' => [
            'back_to_list' => 'بازگشت به لیست',
        ],
    ],

    'buttons' => [
        'mark_reviewed' => 'علامت‌گذاری به عنوان بررسی شده',
        'mark_unreviewed' => 'علامت‌گذاری به عنوان بررسی نشده',
    ],
];
