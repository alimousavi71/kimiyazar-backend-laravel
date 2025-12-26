<?php

return [
    'title' => 'Menus',
    'management' => 'Menu Management',
    'description' => 'Manage menus and links in the system',
    'add_new' => 'Add New Menu',
    'links' => 'Links',

    'fields' => [
        'name' => 'Menu Name',
        'type' => 'Menu Type',
        'links' => 'Links',
        'links_count' => 'Links Count',
        'link_type' => 'Link Type',
        'title' => 'Title',
        'url' => 'URL',
        'select_content' => 'Select Page',
        'order' => 'Order',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],

    'types' => [
        'quick_access' => 'Quick Access',
        'services' => 'Our Services',
        'custom' => 'Custom Menu',
    ],

    'link_types' => [
        'custom' => 'Custom',
        'content' => 'Content Page',
    ],

    'messages' => [
        'created' => 'Menu created successfully.',
        'updated' => 'Menu updated successfully.',
        'deleted' => 'Menu deleted successfully.',
        'not_found' => 'Menu not found.',
        'delete_failed' => 'Failed to delete menu.',
        'update_failed' => 'Failed to update menu.',
        'create_failed' => 'Failed to create menu.',
        'no_links' => 'No links available.',
        'links_saved' => 'Links saved successfully.',
        'save_failed' => 'Failed to save links.',
        'confirm_delete_link' => 'Are you sure you want to delete this link?',
        'links_updated' => 'Links updated successfully.',
    ],

    'buttons' => [
        'add_link' => 'Add Link',
    ],

    'forms' => [
        'create' => [
            'title' => 'Create Menu',
            'header_title' => 'Create Menu',
            'description' => 'Create a new menu',
            'card_title' => 'Menu Information',
        ],
        'edit' => [
            'title' => 'Edit Menu',
            'header_title' => 'Edit Menu',
            'description' => 'Edit menu information',
            'menu_info' => 'Menu Information',
            'links_manager' => 'Links Manager',
        ],
        'breadcrumbs' => [
            'dashboard' => 'Dashboard',
            'menus' => 'Menus',
            'create' => 'Create',
            'edit' => 'Edit',
            'details' => 'Details',
        ],
        'placeholders' => [
            'name' => 'Enter menu name',
            'link_title' => 'Enter link title',
            'select_content' => 'Select a page',
        ],
    ],

    'modal' => [
        'add_link' => 'Add Link',
        'edit_link' => 'Edit Link',
    ],

    'show' => [
        'title' => 'Menu Details',
        'header_title' => 'Menu Details',
        'description' => 'Complete menu information',
        'menu_info' => 'Menu Information',
        'links' => 'Links',
    ],
];
