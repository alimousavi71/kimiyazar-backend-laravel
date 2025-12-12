<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Direction
    |--------------------------------------------------------------------------
    |
    | This option controls the text direction of the application.
    | Set to 'rtl' for right-to-left languages (Arabic, Hebrew, etc.)
    | Set to 'ltr' for left-to-right languages (English, etc.)
    |
    */

    'direction' => env('APP_DIRECTION', 'rtl'),

    /*
    |--------------------------------------------------------------------------
    | RTL Locales
    |--------------------------------------------------------------------------
    |
    | List of locales that should use RTL direction by default.
    | When the app locale matches one of these, direction will be set to 'rtl'
    |
    */

    'rtl_locales' => [
        'ar',
        'he',
        'fa',
        'ur',
        'yi',
        'ji',
        'iw',
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-detect Direction
    |--------------------------------------------------------------------------
    |
    | If true, direction will be automatically detected based on the app locale.
    | If false, the 'direction' value above will be used.
    |
    */

    'auto_detect' => env('APP_AUTO_DETECT_DIRECTION', true),
];
