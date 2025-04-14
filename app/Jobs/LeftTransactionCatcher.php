<?php

namespace App\Jobs;

use App\Models\Leftout_trx;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeftTransactionCatcher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        $apiUrl = 'https://www.payit123.com/missingWebhook1.php';
        
        $leftTrx = Leftout_trx::where('status', 'leftout')->get()->all();
        
        Log::info("Hello");

        foreach ($leftTrx as $trx) {

            $queryParams = [
                'invoiceNumber' => $trx->invoiceNumber,
                'clientName' => $trx->tableName
            ];
            
            $response = Http::get($apiUrl, $queryParams);

            if ($response->successful()) {
                $responseData = json_decode($response->getBody(), true);
            } else {
                Log::error('API request failed:', ['status' => $response->status(), 'body' => $response->body()]);
                $responseData = [];
            }
            
            Log::info($response);

            $queryy = $responseData["query"];

            DB::beginTransaction();
            // Execute the query
            try {
                DB::statement($queryy);
                DB::commit();
                Log::info("Left out Trx Query Executed Successfully" . $trx->invoiceNumber);
                $result = Leftout_trx::where('id', $trx->id)->update(['status' => 'Updated']);
                
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage(), (json_decode($e->getMessage())));
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
}
