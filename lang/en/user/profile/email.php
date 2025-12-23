<?php

return [
    'messages' => [
        'otp_sent' => 'OTP code has been sent to your new email address.',
        'otp_resent' => 'OTP code has been resent to your new email address.',
        'email_updated' => 'Your email address has been updated successfully.',
        'session_expired' => 'Your session has expired. Please start again.',
        'invalid_otp' => 'Invalid OTP code. Please try again.',
    ],

    'forms' => [
        'edit' => [
            'title' => 'Change Email',
            'header_title' => 'Change Email',
            'description' => 'Update your email address with OTP verification',
            'card_title' => 'Change Email Address',
            'current_email' => 'Current Email:',
            'no_email' => 'No email address set',
            'new_email' => 'New Email Address',
            'placeholder_email' => 'Enter new email address',
            'submit' => 'Send OTP Code',
        ],
    ],

    'verify' => [
        'title' => 'Verify Email Change',
        'header_title' => 'Verify Email Change',
        'description' => 'Enter the OTP code sent to your new email address',
        'card_title' => 'Verify OTP Code',
        'sent_to' => 'Code sent to:',
        'code_label' => 'OTP Code',
        'submit' => 'Verify and Update Email',
        'resend' => 'Resend OTP Code',
        'resend_timer' => 'Resend code in :seconds seconds',
        'sending' => 'Sending...',
    ],
];
