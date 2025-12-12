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
];

