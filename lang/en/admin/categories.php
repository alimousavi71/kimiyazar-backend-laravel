<?php

return [
    'title' => 'Categories',
    'management' => 'Category Management',
    'description' => 'Manage all categories',
    'add_new' => 'Add New Category',

    'fields' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'parent' => 'Parent Category',
        'is_active' => 'Status',
        'sort_order' => 'Sort Order',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],

    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'root' => 'Root Category',
    ],

    'messages' => [
        'created' => 'Category created successfully.',
        'updated' => 'Category updated successfully.',
        'deleted' => 'Category deleted successfully.',
        'not_found' => 'Category not found.',
        'delete_failed' => 'Failed to delete category.',
        'parent_id_not_self' => 'A category cannot be its own parent.',
    ],

    'forms' => [
        'create' => [
            'title' => 'Create Category',
            'header_title' => 'Create Category',
            'description' => 'Add a new category',
            'card_title' => 'Category Information',
            'submit' => 'Create Category',
        ],
        'edit' => [
            'title' => 'Edit Category',
            'header_title' => 'Edit Category',
            'description' => 'Update category information',
            'card_title' => 'Category Information',
            'submit' => 'Update Category',
        ],
        'placeholders' => [
            'name' => 'Enter category name',
            'slug' => 'Enter category slug',
            'sort_order' => 'Enter sort order',
            'no_parent' => 'No parent (root)',
        ],
        'labels' => [
            'active_category' => 'Active category',
        ],
        'breadcrumbs' => [
            'dashboard' => 'Dashboard',
            'categories' => 'Categories',
            'create' => 'Create',
            'edit' => 'Edit',
            'details' => 'Details',
        ],
    ],

    'show' => [
        'title' => 'Category Details',
        'header_title' => 'Category Details',
        'description' => 'View category information',
        'basic_info' => 'Basic Information',
        'children_title' => 'Child Categories',
        'timestamps' => 'Timestamps',
        'quick_actions' => 'Quick Actions',
        'buttons' => [
            'edit' => 'Edit Category',
            'back_to_list' => 'Back to List',
            'add_child' => 'Add Child Category',
        ],
    ],
];

