<?php

return [
    'title' => 'Modals',
    'management' => 'Manage Modals',
    'description' => 'Manage all system modals',
    'add_new' => 'Add New Modal',

    'fields' => [
        'id' => 'ID',
        'title' => 'Title',
        'content' => 'Content',
        'button_text' => 'Button Text',
        'button_url' => 'Button URL',
        'close_text' => 'Close Text',
        'is_rememberable' => 'Show "Don\'t show again"',
        'is_published' => 'Status',
        'priority' => 'Priority',
        'start_at' => 'Start Date',
        'end_at' => 'End Date',
        'modalable_type' => 'Associated Model Type',
        'modalable_id' => 'Associated Model ID',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],

    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'enabled' => 'Enabled',
        'disabled' => 'Disabled',
    ],

    'messages' => [
        'created' => 'Modal created successfully.',
        'updated' => 'Modal updated successfully.',
        'deleted' => 'Modal deleted successfully.',
        'not_found' => 'Modal not found.',
        'delete_failed' => 'Failed to delete modal.',
        'create_failed' => 'Failed to create modal.',
    ],

    'forms' => [
        'create' => [
            'title' => 'Create Modal',
            'header_title' => 'Create Modal',
            'description' => 'Add a new modal',
            'card_title' => 'Modal Information',
            'submit' => 'Create Modal',
        ],
        'edit' => [
            'title' => 'Edit Modal',
            'header_title' => 'Edit Modal',
            'description' => 'Update modal information',
            'card_title' => 'Edit Modal ":title"',
            'submit' => 'Update Modal',
        ],
        'breadcrumbs' => [
            'dashboard' => 'Dashboard',
            'modals' => 'Modals',
            'create' => 'Create',
            'edit' => 'Edit',
        ],
        'placeholders' => [
            'title' => 'Enter modal title',
            'content' => 'Enter modal content',
            'button_text' => 'Enter action button text (optional)',
            'button_url' => 'Enter action button URL (optional)',
            'close_text' => 'Enter close button text (default: بستن)',
            'priority' => 'Display priority (higher number = shown first)',
            'modalable_type' => 'Example: App\\Models\\Slider',
            'modalable_id' => 'ID of the associated record',
        ],
        'labels' => [
            'active_modal' => 'This modal is active',
            'show_remember_option' => 'Show "Don\'t show again" option',
        ],
        'hints' => [
            'remember' => 'If enabled, users can choose not to see this modal again for a period of time.',
            'modalable_type' => 'Full class name of the associated model (optional). Leave empty to show this modal to all users.',
            'modalable_id' => 'ID of a specific record from the associated model (optional).',
        ],
        'sections' => [
            'polymorphic' => 'Polymorphic Association (Optional)',
        ],
    ],

    'show' => [
        'header_title' => 'Modal Details',
        'viewing_modal' => 'View complete modal details',
        'information' => 'Modal Information',
        'scheduling' => 'Scheduling',
        'association' => 'Model Association',
        'metadata' => 'System Information',
    ],
];
