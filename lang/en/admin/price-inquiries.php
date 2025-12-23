<?php

return [
    'title' => 'Price Inquiries',
    'management' => 'Price Inquiries Management',
    'description' => 'Manage and review price inquiries from customers',

    'fields' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'full_name' => 'Full Name',
        'email' => 'Email',
        'phone_number' => 'Phone Number',
        'product' => 'Product',
        'quantity' => 'Quantity',
        'variant' => 'Variant',
        'products' => 'Products',
        'products_count' => 'Products Count',
        'is_reviewed' => 'Review Status',
        'user' => 'User',
        'user_id' => 'User ID',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],

    'labels' => [
        'registered_user' => 'Registered User',
        'not_found' => 'Not Found',
    ],

    'status' => [
        'reviewed' => 'Reviewed',
        'pending' => 'Pending',
    ],

    'messages' => [
        'status_toggled' => 'Review status updated successfully.',
        'deleted' => 'Price inquiry deleted successfully.',
        'delete_confirm' => 'Are you sure you want to delete this price inquiry?',
    ],

    'show' => [
        'title' => 'Price Inquiry Details',
        'header_title' => 'Price Inquiry Details',
        'description' => 'View and manage price inquiry details',
        'contact_info' => 'Contact Information',
        'products' => 'Products',
        'product' => 'Product',
        'timestamps' => 'Timestamps',
        'quick_actions' => 'Quick Actions',
        'no_products' => 'No products found',
        'buttons' => [
            'back_to_list' => 'Back to List',
        ],
    ],

    'buttons' => [
        'mark_reviewed' => 'Mark as Reviewed',
        'mark_unreviewed' => 'Mark as Unreviewed',
    ],
];
