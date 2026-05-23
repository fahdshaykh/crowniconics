<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MpesaService
{
    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;
    protected $businessShortCode;
    protected $passkey;
    protected $callbackUrl;
    protected $environment;

    public function __construct()
    {
        $this->baseUrl = config('mpesa.base_url');
        $this->consumerKey = config('mpesa.consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret');
        $this->businessShortCode = config('mpesa.business_short_code');
        $this->passkey = config('mpesa.passkey');
        $this->callbackUrl = config('mpesa.callback_url');
        $this->environment = config('mpesa.environment');
    }

    /**
     * Generate access token for M-Pesa API
     */
    public function generateAccessToken()
    {
        try {
            $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
                ->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');

            if ($response->successful()) {
                $data = $response->json();
                return $data['access_token'] ?? null;
            }

            Log::error('M-Pesa Access Token Generation Failed', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('M-Pesa Access Token Exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Generate password for STK Push
     */
    private function generatePassword()
    {
        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($this->businessShortCode . $this->passkey . $timestamp);
        
        return [
            'password' => $password,
            'timestamp' => $timestamp
        ];
    }

    /**
     * Initiate STK Push payment
     */
    public function stkPush($phoneNumber, $amount, $accountReference, $transactionDesc, $callbackUrl = null)
    {
        try {
            $accessToken = $this->generateAccessToken();
            
            if (!$accessToken) {
                return [
                    'success' => false,
                    'message' => 'Failed to generate access token'
                ];
            }

            $passwordData = $this->generatePassword();
            $callbackUrl = $callbackUrl ?? $this->callbackUrl;

            $payload = [
                'BusinessShortCode' => $this->businessShortCode,
                'Password' => $passwordData['password'],
                'Timestamp' => $passwordData['timestamp'],
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phoneNumber,
                'PartyB' => $this->businessShortCode,
                'PhoneNumber' => $phoneNumber,
                'CallBackURL' => $callbackUrl,
                'AccountReference' => $accountReference,
                'TransactionDesc' => $transactionDesc
            ];

            $response = Http::withToken($accessToken)
                ->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['ResponseCode'] == '0') {
                    return [
                        'success' => true,
                        'checkout_request_id' => $data['CheckoutRequestID'],
                        'merchant_request_id' => $data['MerchantRequestID'],
                        'response_code' => $data['ResponseCode'],
                        'response_description' => $data['ResponseDescription'],
                        'customer_message' => $data['CustomerMessage']
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => $data['ResponseDescription'] ?? 'Payment request failed',
                        'response_code' => $data['ResponseCode']
                    ];
                }
            }

            Log::error('M-Pesa STK Push Failed', [
                'status' => $response->status(),
                'response' => $response->body(),
                'payload' => $payload
            ]);

            return [
                'success' => false,
                'message' => 'Failed to initiate payment request'
            ];

        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push Exception', [
                'message' => $e->getMessage(),
                'phone' => $phoneNumber,
                'amount' => $amount
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while processing payment'
            ];
        }
    }

    /**
     * Query STK Push transaction status
     */
    public function queryStkPush($checkoutRequestId)
    {
        try {
            $accessToken = $this->generateAccessToken();
            
            if (!$accessToken) {
                return [
                    'success' => false,
                    'message' => 'Failed to generate access token'
                ];
            }

            $passwordData = $this->generatePassword();

            $payload = [
                'BusinessShortCode' => $this->businessShortCode,
                'Password' => $passwordData['password'],
                'Timestamp' => $passwordData['timestamp'],
                'CheckoutRequestID' => $checkoutRequestId
            ];

            $response = Http::withToken($accessToken)
                ->post($this->baseUrl . '/mpesa/stkpushquery/v1/query', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'response_code' => $data['ResponseCode'],
                    'response_description' => $data['ResponseDescription'],
                    'merchant_request_id' => $data['MerchantRequestID'],
                    'checkout_request_id' => $data['CheckoutRequestID'],
                    'result_code' => $data['ResultCode'] ?? null,
                    'result_description' => $data['ResultDesc'] ?? null
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to query transaction status'
            ];

        } catch (\Exception $e) {
            Log::error('M-Pesa Query Exception', [
                'message' => $e->getMessage(),
                'checkout_request_id' => $checkoutRequestId
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while querying transaction'
            ];
        }
    }

    /**
     * Format phone number for M-Pesa (254XXXXXXXXX)
     */
    public function formatPhoneNumber($phoneNumber)
    {
        // Remove any non-numeric characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Handle different formats
        if (strlen($phoneNumber) == 9 && substr($phoneNumber, 0, 1) == '0') {
            // Format: 07XXXXXXXX -> 2547XXXXXXXX
            return '254' . substr($phoneNumber, 1);
        } elseif (strlen($phoneNumber) == 10 && substr($phoneNumber, 0, 1) == '0') {
            // Format: 07XXXXXXXXX -> 2547XXXXXXXXX
            return '254' . substr($phoneNumber, 1);
        } elseif (strlen($phoneNumber) == 12 && substr($phoneNumber, 0, 3) == '254') {
            // Already in correct format
            return $phoneNumber;
        } elseif (strlen($phoneNumber) == 13 && substr($phoneNumber, 0, 4) == '+254') {
            // Format: +2547XXXXXXXXX -> 2547XXXXXXXXX
            return substr($phoneNumber, 1);
        }
        
        // Default: assume it needs 254 prefix
        if (strlen($phoneNumber) == 9) {
            return '254' . $phoneNumber;
        }
        
        return $phoneNumber;
    }

    /**
     * Validate phone number format
     */
    public function validatePhoneNumber($phoneNumber)
    {
        $formatted = $this->formatPhoneNumber($phoneNumber);
        
        // Check if it's a valid Kenyan mobile number
        return preg_match('/^254[17][0-9]{8}$/', $formatted);
    }

    /**
     * Get transaction status from callback data
     */
    public function parseCallbackData($callbackData)
    {
        try {
            $data = json_decode($callbackData, true);
            
            if (!$data || !isset($data['Body']['stkCallback'])) {
                return null;
            }
            
            $stkCallback = $data['Body']['stkCallback'];
            $callbackMetadata = $stkCallback['CallbackMetadata']['Item'] ?? [];
            
            $metadata = [];
            foreach ($callbackMetadata as $item) {
                $metadata[$item['Name']] = $item['Value'] ?? null;
            }
            
            return [
                'merchant_request_id' => $stkCallback['MerchantRequestID'],
                'checkout_request_id' => $stkCallback['CheckoutRequestID'],
                'result_code' => $stkCallback['ResultCode'],
                'result_description' => $stkCallback['ResultDesc'],
                'amount' => $metadata['Amount'] ?? null,
                'mpesa_receipt_number' => $metadata['MpesaReceiptNumber'] ?? null,
                'transaction_date' => $metadata['TransactionDate'] ?? null,
                'phone_number' => $metadata['PhoneNumber'] ?? null,
                'is_successful' => $stkCallback['ResultCode'] == 0
            ];
            
        } catch (\Exception $e) {
            Log::error('M-Pesa Callback Parse Error', [
                'message' => $e->getMessage(),
                'callback_data' => $callbackData
            ]);
            
            return null;
        }
    }
}
