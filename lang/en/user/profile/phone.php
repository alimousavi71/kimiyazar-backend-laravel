<?php

return [
    'messages' => [
        'otp_sent' => 'OTP code has been sent to your new phone number.',
        'otp_resent' => 'OTP code has been resent to your new phone number.',
        'phone_updated' => 'Your phone number has been updated successfully.',
        'session_expired' => 'Your session has expired. Please start again.',
        'invalid_otp' => 'Invalid OTP code. Please try again.',
    ],

    'forms' => [
        'edit' => [
            'title' => 'Change Phone Number',
            'header_title' => 'Change Phone Number',
            'description' => 'Update your phone number with OTP verification',
            'card_title' => 'Change Phone Number',
            'current_phone' => 'Current Phone Number:',
            'no_phone' => 'No phone number set',
            'country_code' => 'Country Code',
            'phone_number' => 'Phone Number',
            'placeholder_country_code' => 'e.g., +98',
            'placeholder_phone_number' => 'Enter phone number',
            'submit' => 'Send OTP Code',
        ],
    ],

    'verify' => [
        'title' => 'Verify Phone Change',
        'header_title' => 'Verify Phone Change',
        'description' => 'Enter the OTP code sent to your new phone number',
        'card_title' => 'Verify OTP Code',
        'sent_to' => 'Code sent to:',
        'code_label' => 'OTP Code',
        'submit' => 'Verify and Update Phone',
        'resend' => 'Resend OTP Code',
        'resend_timer' => 'Resend code in :seconds seconds',
        'sending' => 'Sending...',
    ],
];
