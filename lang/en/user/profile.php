<?php

return [
    'title' => 'Profile',
    'management' => 'Profile Management',
    'description' => 'Manage your profile information',

    'fields' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'full_name' => 'Full Name',
        'email' => 'Email',
        'phone_number' => 'Phone Number',
        'country_code' => 'Country Code',
        'last_login' => 'Last Login',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],

    'messages' => [
        'updated' => 'Profile updated successfully.',
        'password_updated' => 'Password updated successfully.',
        'update_failed' => 'Failed to update profile.',
        'password_update_failed' => 'Failed to update password.',
    ],

    'navigation' => [
        'panel' => 'User Panel',
        'dashboard' => 'Dashboard',
        'profile' => 'Profile',
        'price_inquiries' => 'Price Inquiries',
        'home' => 'Home',
    ],

    'header' => [
        'user_menu' => 'User menu',
        'profile' => 'Profile',
        'logout' => 'Logout',
    ],

    'show' => [
        'title' => 'Profile',
        'header_title' => 'My Profile',
        'description' => 'View your profile information',
        'personal_info' => 'Personal Information',
        'activity_info' => 'Activity Information',
        'avatar_card_title' => 'Profile Picture',
        'labels' => [
            'never_logged_in' => 'Never',
            'email_verified' => 'Email Verified',
            'verified' => 'Verified',
            'not_verified' => 'Not Verified',
        ],
        'buttons' => [
            'edit' => 'Edit Profile',
        ],
    ],

    'forms' => [
        'edit' => [
            'title' => 'Edit Profile',
            'header_title' => 'Edit Profile',
            'description' => 'Update your profile information',
            'card_title' => 'Profile Information',
            'avatar_card_title' => 'Profile Picture',
            'submit' => 'Update Profile',
            'change_email' => 'Change Email',
            'change_phone' => 'Change Phone',
        ],
        'password' => [
            'title' => 'Change Password',
            'header_title' => 'Change Password',
            'description' => 'Update your account password',
            'card_title' => 'Change Password',
            'current_password' => 'Current Password',
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm New Password',
            'submit' => 'Update Password',
            'placeholders' => [
                'current_password' => 'Enter current password',
                'new_password' => 'Enter new password',
                'confirm_password' => 'Confirm new password',
            ],
        ],
        'placeholders' => [
            'first_name' => 'Enter first name',
            'last_name' => 'Enter last name',
            'email' => 'Enter email address',
            'phone_number' => 'Enter phone number',
            'country_code' => 'Enter country code',
        ],
    ],

    'breadcrumbs' => [
        'dashboard' => 'Dashboard',
        'profile' => 'Profile',
        'edit' => 'Edit',
        'password' => 'Change Password',
    ],
];
