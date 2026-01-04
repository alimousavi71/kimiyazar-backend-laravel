<?php

namespace App\Services\Sms;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsIrService
{
    private string $apiKey;
    private string $lineNumber;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.smsir.api_key', '');
        $this->lineNumber = config('services.smsir.line_number', '');
        $this->baseUrl = config('services.smsir.base_url', 'https://api.sms.ir/v1');
    }

    /**
     * Check if SMS.ir service is properly configured.
     *
     * @return bool
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && !empty($this->lineNumber);
    }

    /**
     * Send normal SMS to one or multiple recipients.
     *
     * @param string|array $mobiles Phone number(s) - can be string or array
     * @param string $messageText Message content
     * @param string|null $sendDateTime Optional scheduled send date (ISO 8601 format or timestamp)
     * @return array
     */
    public function send(string|array $mobiles, string $messageText, ?string $sendDateTime = null): array
    {
        // Normalize mobiles to array
        $mobilesArray = is_array($mobiles) ? $mobiles : [$mobiles];

        // Validate credentials
        if (empty($this->apiKey) || empty($this->lineNumber)) {
            Log::error('SMS.ir credentials not configured');
            return [
                'success' => false,
                'message' => 'SMS service not configured',
            ];
        }

        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/send/bulk", [
                        'lineNumber' => (int) $this->lineNumber,
                        'messageText' => $messageText,
                        'mobiles' => $mobilesArray,
                        'sendDateTime' => $sendDateTime,
                    ]);

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error('SMS.ir send error: ' . $e->getMessage(), [
                'mobiles' => $mobilesArray,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send SMS: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Send verification SMS using template.
     *
     * @param string $mobile Phone number
     * @param int $templateId Template ID from SMS.ir panel
     * @param array $parameters Template parameters (e.g., [['name' => 'PARAMETER1', 'value' => '123456']])
     * @return array
     */
    public function sendVerification(string $mobile, int $templateId, array $parameters = []): array
    {
        // Validate credentials
        if (empty($this->apiKey)) {
            Log::error('SMS.ir credentials not configured');
            return [
                'success' => false,
                'message' => 'SMS service not configured',
            ];
        }

        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Accept' => 'text/plain',
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/send/verify", [
                        'mobile' => $mobile,
                        'templateId' => $templateId,
                        'parameters' => $parameters,
                    ]);

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error('SMS.ir verification send error: ' . $e->getMessage(), [
                'mobile' => $mobile,
                'templateId' => $templateId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send verification SMS: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get account credit balance.
     *
     * @return array
     */
    public function getCredit(): array
    {
        // Validate credentials
        if (empty($this->apiKey)) {
            Log::error('SMS.ir credentials not configured');
            return [
                'success' => false,
                'message' => 'SMS service not configured',
                'credit' => 0,
            ];
        }

        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Accept' => 'application/json',
            ])->get("{$this->baseUrl}/credit");

            $result = $this->handleResponse($response);

            // Extract credit from response if available
            if (isset($result['data']['returnedCreditCount'])) {
                $result['credit'] = $result['data']['returnedCreditCount'];
            } elseif (isset($result['data']['credit'])) {
                $result['credit'] = $result['data']['credit'];
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('SMS.ir get credit error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to get credit: ' . $e->getMessage(),
                'credit' => 0,
            ];
        }
    }

    /**
     * Send OTP verification SMS using template (convenience method).
     *
     * @param string $mobile Phone number
     * @param string $otpCode OTP code to send
     * @param int $templateId Template ID from SMS.ir panel
     * @param string $parameterName Parameter name in template (default: 'CODE' or 'PARAMETER1')
     * @return array
     */
    public function sendOtpVerification(string $mobile, string $otpCode, int $templateId, string $parameterName = 'CODE'): array
    {
        $parameters = [
            [
                'name' => $parameterName,
                'value' => $otpCode,
            ],
        ];

        return $this->sendVerification($mobile, $templateId, $parameters);
    }

    /**
     * Handle API response and normalize format.
     *
     * @param Response $response
     * @return array
     */
    private function handleResponse(Response $response): array
    {
        $statusCode = $response->status();
        $body = $response->json();

        // Check if request was successful
        if ($statusCode >= 200 && $statusCode < 300) {
            // SMS.ir API returns status in body, check it
            $apiStatus = $body['status'] ?? null;

            // Status codes: positive = success, negative = error
            if ($apiStatus !== null && $apiStatus > 0) {
                return [
                    'success' => true,
                    'message' => $body['message'] ?? 'SMS sent successfully',
                    'data' => $body['data'] ?? [],
                    'status' => $apiStatus,
                ];
            } else {
                // API returned error status
                return [
                    'success' => false,
                    'message' => $body['message'] ?? 'SMS sending failed',
                    'data' => $body['data'] ?? [],
                    'status' => $apiStatus,
                ];
            }
        } else {
            // HTTP error
            $errorMessage = $body['message'] ?? "HTTP {$statusCode} error";
            return [
                'success' => false,
                'message' => $errorMessage,
                'data' => $body['data'] ?? [],
                'status' => $statusCode,
            ];
        }
    }
}
