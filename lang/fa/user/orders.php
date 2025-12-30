<?php

return [
    'title' => 'سفارش‌ها',
    'management' => 'سفارش‌های من',
    'description' => 'مشاهده سفارش‌های ثبت شده شما',

    'fields' => [
        'id' => 'شماره سفارش',
        'customer_type' => 'نوع خریدار',
        'status' => 'وضعیت',
        'payment_type' => 'نوع پرداخت',
        'total_payment_amount' => 'مبلغ کل',
        'created_at' => 'تاریخ ثبت',
        'full_name' => 'نام و نام خانوادگی',
        'company_name' => 'نام شرکت',
        'national_code' => 'کد ملی',
        'economic_code' => 'کد اقتصادی',
        'phone' => 'تلفن',
        'mobile' => 'موبایل',
        'country' => 'کشور',
        'state' => 'استان',
        'city' => 'شهر',
        'postal_code' => 'کد پستی',
        'address' => 'آدرس',
        'receiver_full_name' => 'نام گیرنده',
        'delivery_method' => 'روش تحویل',
        'product' => 'محصول',
        'quantity' => 'تعداد',
        'unit' => 'واحد',
        'unit_price' => 'قیمت واحد',
        'product_description' => 'توضیحات محصول',
        'payment_date' => 'تاریخ پرداخت',
        'payment_time' => 'زمان پرداخت',
    ],

    'customer_types' => [
        'real' => 'شخصی',
        'legal' => 'حقوقی',
    ],

    'statuses' => [
        'pending_payment' => 'در انتظار پرداخت',
        'paid' => 'پرداخت شده',
        'processing' => 'در حال پردازش',
        'shipped' => 'ارسال شده',
        'delivered' => 'تحویل شده',
        'cancelled' => 'لغو شده',
        'returned' => 'برگشت داده شده',
    ],

    'payment_types' => [
        'online_gateway' => 'درگاه آنلاین',
        'bank_deposit' => 'واریز به حساب',
        'wallet' => 'کیف پول',
        'pos' => 'پرداخت در محل',
        'cash_on_delivery' => 'پرداخت نقدی',
    ],

    'units' => [
        'piece' => 'عدد',
        'kg' => 'کیلوگرم',
        'ton' => 'تن',
        'liter' => 'لیتر',
        'can' => 'قوطی',
        'packet' => 'بسته',
        'gallon' => 'گالن',
        'can_and_packet' => 'قوطی و بسته',
    ],

    'delivery_methods' => [
        'post' => 'پست ایران',
        'courier' => 'پیک موتوری',
        'in_person' => 'تحویل حضوری',
    ],

    'show' => [
        'title' => 'جزئیات سفارش',
        'header_title' => 'جزئیات سفارش',
        'description' => 'مشاهده جزئیات سفارش شما',
        'order_info' => 'اطلاعات سفارش',
        'customer_info' => 'اطلاعات خریدار',
        'location_info' => 'اطلاعات آدرس',
        'product_info' => 'اطلاعات محصول',
        'payment_info' => 'اطلاعات پرداخت',
        'buttons' => [
            'back_to_list' => 'بازگشت به فهرست',
        ],
    ],

    'breadcrumbs' => [
        'dashboard' => 'داشبورد',
        'orders' => 'سفارش‌ها',
        'details' => 'جزئیات',
    ],
];

