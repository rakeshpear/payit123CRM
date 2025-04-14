<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ApiHealthCheckerr;

class ApiHealthCheckService
{
    public static function checkApiHealth($apiUrl)
    {
        try {
            
            $status = "";
            $reason = "";
            $responseTime = 0;
            $error = null;

            $startTime = microtime(true);
            $response = Http::timeout(20)->get($apiUrl->urlName);
            $endTime = microtime(true);

            $responseTime = round(($endTime - $startTime), 2); // Convert to milliseconds

            // Check if response is successful
            if ($response->successful()) {
                if ($responseTime <= 5) {
                    $status = 'Good Health';
                } elseif ($responseTime > 5 && $responseTime <= 20) {
                    $status = 'Degraded';
                } else {
                    $status = 'Unreachable';
                }
            } else {
                $status = 'Unreachable';
                $reason = 'Unsuccessful response';
            }

            // Prepare data for update
            $params = [
                'currentStatus' => $status,
                'responseTime' => $responseTime,
                'reason' => $error ?? $reason,
            ];

            if ($status == "Good Health") {
                $params["lastHealthyStatus"] = DB::raw('CURRENT_TIMESTAMP');
            } elseif ($status == "Degraded" || $status == "Unhealthy") {
                $params["lastDegradedStatus"] = DB::raw('CURRENT_TIMESTAMP');
            }
            
            if($status !== "Good Health"){
                Log::channel('api_health')->info("Checked API: {$apiUrl} - Response Time: {$responseTime}s - Status: {$status} at " . now());
            }

            // Update database
            ApiHealthCheckerr::where('API',  )->update($params);
            
        } catch (\Exception $e) {
            $status = 'Unhealthy';
            $reason = 'API is unreachable';
            $error = $e->getMessage();

            Log::error("Error fetching API: {$apiUrl->urlName} - {$error}");
            Log::channel('api_health')->info("Checked API: {$apiUrl} - Response Time: {$responseTime}s - Status: {$status} - Reason - {$reason} at " . now());
            
            // Update database with error details
            ApiHealthCheckerr::whereId($apiUrl->id)->update([
                'currentStatus' => $status,
                'responseTime' => null, // No valid response time
                'reason' => $error,
                'lastDegradedStatus' => DB::raw('CURRENT_TIMESTAMP'),
            ]);
        }
    }
}
