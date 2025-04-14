<?php

namespace App\Jobs;
use App\Services\ApiHealthCheckService;
use App\Models\ApiHealthCheckerr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiHealthMonitor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $midUrls = [
            ["midName" => "ES AMEX", "midUrl" => "www.googe.com" ],
            ["midName" => "Leopard Stripe", "midUrl" => "https://mrleopard.com.cy" ],
            ["midName" => "DesignerLounge Stripe", "midUrl" => "https://designerloungecy.com/" ],
            ["midName" => "FX AMEX", "midUrl" => "www.fxcareer.eu" ],
            ["midName" => "MH AMEX", "midUrl" => "https://moriihub.com" ],
            ["midName" => "CR AMEX", "midUrl" => "www.crosschannelrecruitment.com" ],
            ["midName" => "Broadpay", "midUrl" => "www.googe.com" ],
            ["midName" => "VersationAdvisor Stripe", "midUrl" => "https://versationadvisors.com" ],
        ];
        
        $activeClients = DB::connection('mysql2')->table('active_clients')->where('date', Carbon::today())->pluck('client');
        $activeClientsArray = explode(',', $activeClients);


        // Removing Special Chars & Re-indexing
        $activeClientsArray = array_map(fn($client) => trim($client, '[]"'), $activeClientsArray);
        $uniqueClients = array_unique($activeClientsArray);
        $uniqueClients = array_values($uniqueClients);        

        dd($uniqueClients);
        
        $totalMidUrls = [];
        
        // dd(json_decode($clientBank->configuration));
        
        foreach($uniqueClients as $client){
            
            $configValue = DB::connection('mysql2')->table('client_psp')->where('client', $client)->select('configuration')->first();
            
            if (!$configValue || empty($configValue->configuration)) {
                array_push($totalMidUrls, ["client" => $client, "bank" => null]);
                continue; 
            }
    
            $clientBank = json_decode($configValue->configuration, true);
            
            array_push($totalMidUrls, ["client" => $client, "bank" => $clientBank[0]['bank']]);

        }
        
        // dd($totalMidUrls);
        
        $bankNames = array_column($totalMidUrls, 'bank');

        // Removing NULL, Removing Duplicate, Re-indexing Array
        $uniqueBankNames = array_filter($bankNames);
        $uniqueBankNames = array_unique($uniqueBankNames);
        $uniqueBankNames = array_values($uniqueBankNames); 
        
        // dd($uniqueBankNames);
        
        foreach ($uniqueBankNames as $bank) {
            
             $apiUrl = ApiHealthCheckerr::where('API' , $bank)->get();
                
                if($apiUrl !== null){
                    
                    ApiHealthCheckService::checkApiHealth($apiUrl);
                    
                }
                else{
                    
                    foreach ($midUrls as $mid) {
                        if ($mid["midName"] === $bank) {
                            $midUrl = $mid["midUrl"];
                            break;
                        }
                    }
                    
                    $newApi = [
                        'API' => $bank,
                        'urlName' => $midUrl,
                    ];
                    
                    $newEntry = ApiHealthCheckerr::create($newApi);
                    ApiHealthCheckService::checkApiHealth($newEntry);
                    
                }
            
        }
    }
}
