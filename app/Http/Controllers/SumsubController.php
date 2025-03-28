<?php

namespace App\Http\Controllers;

use App\Services\SumsubService;
use Illuminate\Http\Request;

class SumsubController extends Controller
{
    protected $sumsubService;

    public function __construct(SumsubService $sumsubService)
    {
        $this->sumsubService = $sumsubService;
    }

    /**
     * Create an applicant on Sumsub
     */
    public function createApplicant(Request $request)
    {
        $path =  '/resources/applicants';

        // Prepare the request body for creating an applicant.
        // You can modify this according to your application's needs.
        $body = [
            'externalUserId' => $request->userId, // Unique ID from your system
            'levelName' => 'basic-kyc-level',           // KYC level, e.g., "basic-kyc-level"
            'metadata' => [
                [
                    'key' => 'email',                             // Custom metadata for the applicant
                    'value' => $request->email,
                ],
            ]
        ];

        // Make the request to Sumsub API
        $response = $this->sumsubService->makeRequest('POST', $path, $body);

        // if (!$response) {
        //     return response()->json(['error' => 'Failed to create applicant. Please try again.'], 500);
        // }

        // Return the API response back to the client
        return response()->json($response);
    }
}
