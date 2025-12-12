<?php

return [
    'title' => 'Admins',
    'management' => 'Admin Management',
    'description' => 'Manage all administrators in the system',
    'add_new' => 'Add New Admin',

    'fields' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'full_name' => 'Full Name',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'is_block' => 'Status',
        'last_login' => 'Last Login',
        'avatar' => 'Avatar',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],

    'status' => [
        'active' => 'Active',
        'blocked' => 'Blocked',
        'never' => 'Never',
    ],

    'messages' => [
        'created' => 'Admin created successfully.',
        'updated' => 'Admin updated successfully.',
        'deleted' => 'Admin deleted successfully.',
        'not_found' => 'Admin not found.',
        'delete_failed' => 'Failed to delete admin.',
    ],

    'forms' => [
        'create' => [
            'title' => 'Create Admin',
            'header_title' => 'Create Admin',
            'description' => 'Add a new administrator to the system',
            'card_title' => 'Admin Information',
            'submit' => 'Create Admin',
        ],
        'edit' => [
            'title' => 'Edit Admin',
            'header_title' => 'Edit Admin',
            'description' => 'Update administrator information',
            'card_title' => 'Admin Information',
            'avatar_card_title' => 'Avatar',
            'submit' => 'Update Admin',
            'password_help' => 'Leave blank to keep current password',
        ],
        'placeholders' => [
            'first_name' => 'Enter first name',
            'last_name' => 'Enter last name',
            'email' => 'Enter email address',
            'password' => 'Enter password',
            'password_confirmation' => 'Confirm password',
            'new_password' => 'Enter new password',
            'confirm_new_password' => 'Confirm new password',
        ],
        'labels' => [
            'block_admin' => 'Block this admin',
            'upload_avatar' => 'Upload Avatar',
            'delete_avatar' => 'Delete Avatar',
            'uploading' => 'Uploading...',
            'deleting' => 'Deleting...',
        ],
        'breadcrumbs' => [
            'dashboard' => 'Dashboard',
            'admins' => 'Admins',
            'create' => 'Create',
            'edit' => 'Edit',
            'details' => 'Details',
        ],
    ],

    'show' => [
        'title' => 'Admin Details',
        'header_title' => 'Admin Details',
        'description' => 'View administrator information',
        'personal_info' => 'Personal Information',
        'activity_info' => 'Activity Information',
        'avatar_card_title' => 'Avatar',
        'buttons' => [
            'edit' => 'Edit Admin',
            'back_to_list' => 'Back to List',
        ],
        'labels' => [
            'email_verified' => 'Email Verified',
            'never_logged_in' => 'Never logged in',
            'verified' => 'Verified',
            'not_verified' => 'Not Verified',
        ],
        'javascript' => [
            'select_image' => 'Please select an image file',
            'delete_avatar_confirm' => 'Are you sure you want to delete the avatar?',
        ],
    ],
];

