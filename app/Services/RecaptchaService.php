<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    /**
     * Get the reCAPTCHA site key
     */
    public static function getSiteKey(): string
    {
        return config('recaptcha.site_key');
    }

    /**
     * Get the reCAPTCHA secret key
     */
    public static function getSecretKey(): string
    {
        return config('recaptcha.secret_key');
    }

    /**
     * Verify reCAPTCHA response
     */
    public static function verify(string $response, string $remoteIp = null): bool
    {
        try {
            $secretKey = self::getSecretKey();
            $verifyUrl = config('recaptcha.verify_url');

            $data = [
                'secret' => $secretKey,
                'response' => $response,
            ];

            if ($remoteIp) {
                $data['remoteip'] = $remoteIp;
            }

            $response = Http::asForm()->post($verifyUrl, $data);

            if (!$response->successful()) {
                Log::error('reCAPTCHA verification failed: HTTP error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }

            $responseData = $response->json();

            if (!isset($responseData['success'])) {
                Log::error('reCAPTCHA verification failed: Invalid response format', [
                    'response' => $responseData
                ]);
                return false;
            }

            if (!$responseData['success']) {
                Log::warning('reCAPTCHA verification failed', [
                    'error_codes' => $responseData['error-codes'] ?? [],
                    'response' => $responseData
                ]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Check if reCAPTCHA is enabled
     */
    public static function isEnabled(): bool
    {
        return !empty(self::getSiteKey()) && !empty(self::getSecretKey());
    }
}