<?php

return [
    'title' => 'Product Price Management',
    'management' => 'Product Price Management',
    'description' => 'Manage product prices efficiently with inline editing and bulk operations',
    'add_new' => 'Add New Price',

    'fields' => [
        'product' => 'Product',
        'current_price' => 'Current Price',
        'new_price' => 'New Price',
        'price' => 'Price',
        'currency_code' => 'Currency',
        'date' => 'Date',
        'created_at' => 'Created At',
    ],

    'buttons' => [
        'save' => 'Save',
        'save_all' => 'Save All Changes',
        'saving' => 'Saving',
        'prefill' => 'Pre-fill from Latest',
        'sync_today' => 'Sync Today\'s Prices',
    ],

    'placeholders' => [
        'search' => 'Search products by name or slug...',
        'price' => 'Enter price',
    ],

    'messages' => [
        'updated' => 'Price updated successfully.',
        'bulk_updated' => ':count prices updated successfully.',
        'update_failed' => 'Failed to update price.',
        'bulk_update_failed' => 'Failed to update prices.',
        'no_price' => 'No price set',
        'price_required' => 'Price and currency are required.',
        'no_changes' => 'No changes to save.',
        'sync_completed' => 'Sync completed: :created created, :updated updated.',
        'sync_failed' => 'Failed to sync today\'s prices.',
    ],
];
