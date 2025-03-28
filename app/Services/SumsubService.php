<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SumsubService
{
    protected $client;
    protected $apiKey;
    protected $secretKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.sumsub.com',
            'timeout'  => 5.0,
        ]);

        $this->apiKey = env('SUMSUB_API_KEY');
        $this->secretKey = env('SUMSUB_SECRET_KEY');
    }

    public function createSignature($method, $path, $body)
    {
        // Get the current timestamp in seconds
        $ts = time() * 1000;

        // Create a string to sign (method + path + ts + body)
        $stringToSign =  $method . ' ' . $path . ' ' . $ts . ' ' . $body;

        // dd($stringToSign);
        // Generate HMAC SHA256 signature using the secret key
        $signature = hash_hmac('sha256', $stringToSign, $this->secretKey);

        return [
            'signature' => $signature,
            'ts' => $ts
        ];
    }

    public function makeRequest($method, $path, $body = [])
    {
        $jsonBody = !empty($body) ? json_encode($body) : '';
        $headers = $this->createSignature($method, $path, $jsonBody);

        try {
            $response = $this->client->request($method, $path, [
                'headers' => [
                    'X-App-Token' => $this->apiKey,
                    'X-App-Access-Sig' => $headers['signature'],
                    'X-App-Access-Ts' => $headers['ts'],
                    'Content-Type' => 'application/json',
                ],
                'body' => $jsonBody
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // dd('Sumsub API error: ' . $e->getMessage());
            Log::error('Sumsub API error: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
}
