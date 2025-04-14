<?php

namespace App\Http\Controllers;

use App\Models\ApiHealthCheckerr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ApiHealthCheckController extends Controller
{
    public function index()
    {
        // $activeClients = DB::connection('mysql2')->table('active_clients')->where('date', Carbon::today())->pluck('client');
        // $activeClientsArray = explode(',', $activeClients);


        // // Removing Special Chars & Re-indexing
        // $activeClientsArray = array_map(fn($client) => trim($client, '[]"'), $activeClientsArray);
        // $uniqueClients = array_unique($activeClientsArray);
        // $uniqueClients = array_values($uniqueClients);        

        // dd($uniqueClients);
        $allApis = ApiHealthCheckerr::get();
        return view("apiHealthCheck.index", compact("allApis"));
    }

    public function addNewApi(Request $request)
    {
        $params["API"] = $request->apiName;
        $params["urlName"] = $request->apiUrl;

        ApiHealthCheckerr::create($params);
        return redirect()->back();
    }
}
