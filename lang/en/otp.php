<?php

return [
    'messages' => [
        'not_found' => 'OTP code not found.',
        'already_used' => 'This code has already been used.',
        'expired' => 'This code has expired.',
        'max_attempts_reached' => 'Maximum attempts reached. Please request a new code.',
        'invalid_code' => 'The entered code is incorrect.',
        'verified_successfully' => 'Code verified successfully.',
        'resent_successfully' => 'Code resent successfully.',
        'verification_failed' => 'Code verification failed.',
    ],

    'types' => [
        'sms' => 'SMS',
        'email' => 'Email',
        'authenticator' => 'Authenticator',
    ],
];
