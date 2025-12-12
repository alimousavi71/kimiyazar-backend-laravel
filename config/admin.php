<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Route Prefix
    |--------------------------------------------------------------------------
    |
    | This option defines the prefix for all admin routes. You can change
    | this value to customize the admin panel URL path.
    |
    */

    'prefix' => env('ADMIN_PREFIX', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | Admin Route Name Prefix
    |--------------------------------------------------------------------------
    |
    | This option defines the name prefix for all admin routes. This is used
    | when generating route names like 'admin.dashboard', 'admin.users.index', etc.
    |
    */

    'route_name_prefix' => env('ADMIN_ROUTE_NAME_PREFIX', 'admin'),

];

