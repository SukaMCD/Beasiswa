<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class XenditService
{
    protected $baseUrl = 'https://api.xendit.co';
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = config('services.xendit.key');
    }

    public function createInvoice($externalId, $amount, $payerEmail, $description, $successRedirectUrl = null)
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->post($this->baseUrl . '/v2/invoices', [
                'external_id' => $externalId,
                'amount' => $amount,
                'payer_email' => $payerEmail,
                'description' => $description,
                'success_redirect_url' => $successRedirectUrl,
                'currency' => 'IDR'
            ]);

        if ($response->failed()) {
            throw new \Exception('Xendit Error: ' . $response->body());
        }

        return $response->json();
    }
}
