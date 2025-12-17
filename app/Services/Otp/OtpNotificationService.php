<?php

namespace App\Services\Otp;

use Illuminate\Support\Facades\Log;

class OtpNotificationService
{
    /**
     * Send OTP via email or SMS
     */
    public function send(string $code, string $type, string $destination): void
    {
        if (app()->environment('local')) {
            $this->sendLocal($code, $type, $destination);
        } else {
            match ($type) {
                'email' => $this->sendEmail($code, $destination),
                'sms' => $this->sendSms($code, $destination),
                default => Log::warning("Unknown OTP type: {$type}"),
            };
        }
    }

    /**
     * Send OTP email
     */
    private function sendEmail(string $code, string $email): void
    {
        // TODO: Implement actual email sending
        // Example: Mail::to($email)->send(new OtpCodeMail($code));
        Log::info("Email OTP sent to {$email}: {$code}");
    }

    /**
     * Send OTP via SMS
     */
    private function sendSms(string $code, string $phone): void
    {
        // TODO: Implement actual SMS sending
        // Example: Use Kavenegar, Twilio, or other SMS provider
        // $client = new \Kavenegar\Laravel\Facade\Kavenegar();
        // $client->send($phone, "Your OTP code: {$code}");
        Log::info("SMS OTP sent to {$phone}: {$code}");
    }

    /**
     * Send OTP in local environment (log only)
     */
    private function sendLocal(string $code, string $type, string $destination): void
    {
        $message = match ($type) {
            'email' => "Email OTP to {$destination}: {$code}",
            'sms' => "SMS OTP to {$destination}: {$code}",
            default => "OTP ({$type}) to {$destination}: {$code}",
        };

        Log::info("[LOCAL DEVELOPMENT] {$message}");

        // Also display in console if running in artisan command
        if (php_sapi_name() === 'cli') {
            echo "\n🔐 [LOCAL OTP] Type: {$type} | Code: {$code} | To: {$destination}\n\n";
        }
    }
}
