<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Upload Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for image upload and manipulation settings.
    |
    */

    'default' => [
        'quality' => 90,
        'format' => 'jpg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Presets
    |--------------------------------------------------------------------------
    |
    | Define different image presets for various use cases.
    | Each preset can have width, height, fit method, and quality settings.
    |
    | Fit methods:
    | - 'contain': Resize image to fit within dimensions, maintaining aspect ratio
    | - 'cover': Resize image to cover dimensions, maintaining aspect ratio
    | - 'fill': Resize image to fill dimensions exactly
    | - 'inside': Resize image to fit inside dimensions, maintaining aspect ratio
    | - 'outside': Resize image to fit outside dimensions, maintaining aspect ratio
    |
    */

    'presets' => [
        'avatar' => [
            'width' => 300,
            'height' => 300,
            'fit' => 'cover',
            'quality' => 90,
            'format' => 'jpg',
        ],

        'thumbnail' => [
            'width' => 150,
            'height' => 150,
            'fit' => 'cover',
            'quality' => 85,
            'format' => 'jpg',
        ],

        'medium' => [
            'width' => 800,
            'height' => 600,
            'fit' => 'contain',
            'quality' => 90,
            'format' => 'jpg',
        ],

        'large' => [
            'width' => 1920,
            'height' => 1080,
            'fit' => 'contain',
            'quality' => 95,
            'format' => 'jpg',
        ],

        'product' => [
            'width' => 450,
            'height' => 450,
            'fit' => 'cover',
            'quality' => 90,
            'format' => 'jpg',
        ],

        'content' => [
            'width' => 450,
            'height' => 450,
            'fit' => 'cover',
            'quality' => 90,
            'format' => 'jpg',
        ],

        'editor' => [
            'width' => null,
            'height' => null,
            'fit' => 'contain',
            'quality' => 90,
            'format' => 'jpg',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Settings
    |--------------------------------------------------------------------------
    |
    | Default storage disk and path for uploaded images.
    |
    */

    'storage' => [
        'disk' => 'public',
        'path' => 'images',
    ],

];

