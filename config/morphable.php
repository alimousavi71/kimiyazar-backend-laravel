<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Morphable Types Configuration
    |--------------------------------------------------------------------------
    |
    | Define the models that can be used in polymorphic relationships.
    | Each type should have:
    | - label: Display label for the type
    | - label_key: Translation key for the label (optional, falls back to label)
    | - search_fields: Fields to search when querying items
    | - display_field: Field to display as the text in dropdown
    | - metadata_fields: Additional fields to include in response (optional)
    | - image_field: Field path for image URL (optional, e.g., 'primary_photo.path')
    |
    */

    'types' => [
        \App\Models\Content::class => [
            'label' => 'Content',
            'label_key' => 'morphable.types.content',
            'search_fields' => ['title', 'slug'],
            'display_field' => 'title',
            'metadata_fields' => ['type', 'is_active'],
            'image_field' => null, // Future: 'primary_photo.path'
        ],
        // Easy to add more types:
        // \App\Models\Product::class => [
        //     'label' => 'Product',
        //     'label_key' => 'morphable.types.product',
        //     'search_fields' => ['name', 'sku'],
        //     'display_field' => 'name',
        //     'metadata_fields' => ['price', 'status'],
        //     'image_field' => 'primary_image.path',
        // ],
        // \App\Models\Slider::class => [
        //     'label' => 'Slider',
        //     'label_key' => 'morphable.types.slider',
        //     'search_fields' => ['title'],
        //     'display_field' => 'title',
        //     'metadata_fields' => ['is_active'],
        //     'image_field' => null,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Search Configuration
    |--------------------------------------------------------------------------
    |
    | Configure default search behavior for morphable item queries.
    |
    */

    'default_limit' => 50,
    'min_search_length' => 2,
];
