<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayPalInvoiceService
{
    protected $baseUrl;
    protected $clientId;
    protected $secret;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->clientId = config('services.paypal.client_id');
        $this->secret = config('services.paypal.client_secret');

        // live / sandbox
        $this->baseUrl = config('services.paypal.mode') === 'live'
            ? 'https://api.paypal.com'
            : 'https://api-m.sandbox.paypal.com'; 
    }

    public function getAccessToken()
    {
        $response = Http::asForm()
            ->withBasicAuth($this->clientId, $this->secret)
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch PayPal access token');
        }

        return $response->json('access_token');
    }
 
 
    public function createInvoice($customer, $items = [], $note = '')
    {
        $token = $this->getAccessToken();

        if (!$token) {
            throw new \Exception('PayPal Access Token not generated');
        }
 
        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/v2/invoicing/invoices", [
                "detail" => [
                    "reference" => "Customer - $customer->email",
                    "invoice_date" => date('Y-m-d'),
                    "currency_code" => "USD",
                    "note" => $note,
                    "terms" => "Thanks for your business.",
                ],
                "invoicer" => [
                    "business_name" => "ABC Business", // Business Name
                    "email" => "abc@xyz.com", // Business Email
                    "email_address" => "abc-xyz@business.example.com",  // Paypal Business Name
                    "website" => "https://abc-xyz.com"  // Business Webside
                ],
                "primary_recipients" => [
                    [
                        "billing_info" => [
                            "email" => $customer->email,
                            "email_address" => $customer->email,
                            "first_name" => $customer->first_name,
                            "last_name" => $customer->last_name, 
                            "address" => [
                                "line1" => $customer->address,
                                "city" => $customer->city,
                                "state" => $customer->state,
                                "postal_code" => $customer->postal_code,
                                "country_code" => $customer->country
                            ]
                        ]
                    ]
                ],
                "items" => $items,
                "configuration" => [
                    "partial_payments" => [
                        "allow_partial_payments" => false
                    ],
                    "allow_tip" => false, 
                ]
            ]); 
            
        if ($response->failed()) {
            throw new \Exception('Failed to create PayPal invoice');
        }
        

        return $response->json();
    }
 
 
    public function deleteInvoice($invoiceId)
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
        ->delete("{$this->baseUrl}/v2/invoicing/invoices/{$invoiceId}");

        if ($response->failed()) {
            throw new \Exception('Failed to delete PayPal invoice: ' . $response->body());
        }

        return $response->json();
    }

    public function listInvoices($page = 1, $pageSize = 10)
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
        ->get("{$this->baseUrl}/v2/invoicing/invoices",['page' => $page,'page_size' => $pageSize,'total_required' => 'true',]);

        if ($response->failed()) {
            throw new \Exception('Failed to list PayPal invoice');
        }

        return $response->json();
    }
}
