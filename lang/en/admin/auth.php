<?php

return [
    'login' => [
        'title' => 'Admin Login',
        'welcome' => 'Welcome Back',
        'subtitle' => 'Sign in to your admin account to continue',
        'remember_me' => 'Remember me',
        'forgot_password' => 'Forgot password?',
        'submit' => 'Sign In',
        'error_title' => 'Authentication Error',
    ],

    'forgot_password' => [
        'title' => 'Forgot Password?',
        'subtitle' => 'No worries, we\'ll send you reset instructions',
        'submit' => 'Send Reset Link',
        'back_to_login' => 'Back to login',
        'error_title' => 'Error',
    ],

    'reset_password' => [
        'title' => 'Reset Password',
        'subtitle' => 'Enter your new password below',
        'submit' => 'Reset Password',
        'back_to_login' => 'Back to login',
        'error_title' => 'Error',
        'email_subject' => 'Reset Password Notification',
        'email_line1' => 'You are receiving this email because we received a password reset request for your account.',
        'email_action' => 'Reset Password',
        'email_line2' => 'This password reset link will expire in :count minutes.',
        'email_line3' => 'If you did not request a password reset, no further action is required.',
    ],

    'fields' => [
        'email' => 'Email Address',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
    ],

    'placeholders' => [
        'email' => 'Enter your email',
        'password' => 'Enter your password',
        'new_password' => 'Enter new password',
        'confirm_password' => 'Confirm new password',
    ],

    'messages' => [
        'invalid_credentials' => 'These credentials do not match our records.',
        'account_blocked' => 'Your account has been blocked. Please contact administrator.',
        'logged_out' => 'You have been logged out successfully.',
    ],
];

