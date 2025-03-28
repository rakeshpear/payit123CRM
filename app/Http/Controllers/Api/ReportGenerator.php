<?php

namespace App\Http\Controllers\Api;


use App\Exports\MainExportClass;
use App\Http\Controllers\Controller;
use App\Jobs\GenerateClientExcel;
use App\Models\WeeklyReports;
use App\Models\ClientSettlementLog;
use App\Models\AgentSettlementLog;
use App\Models\ClientDetails;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ReportGenerator extends Controller
{
    public function index(Request $request)
    {

        Session()->flush();

        GenerateClientExcel::dispatch();

        return redirect()->back();
    }

    public function approveReport(string $id)
    {
        // Get the particular report detail
        $particularResult = WeeklyReports::where('id', $id)->get()->first();

        // dd($particularResult);

        // Get the agents list for that particular client
        $agentsList = ClientDetails::where('client_id', $particularResult->user_ID)
            ->pluck('agents')
            ->map(function ($item) {
                return json_decode($item, true);
            });

        $agentIds = collect($agentsList)->flatten()->all();

        // dd($agentIds);

        $dataToCheck = [
            'startDate' => $particularResult->startDate,  // First condition
            'clientName' => $particularResult->clientName   // Second condition
        ];

        // Agent Commission Calculation
        foreach ($agentIds as $agentId) {
            $agent = User::where('id', $agentId)->first();

            $commissionAmt = round(((floatval($particularResult->totalSuccessTrxAmt) * floatval($agent->commission)) / 100), 2);

            Log::info("Commission Amount :" . $commissionAmt);

            $previousCommission = str_replace(',', '', $agent->payout ?? 0);
            Log::info("Previous Commission Amount :" . $previousCommission);

            $commissionAddUp = floatval($previousCommission) + floatval($commissionAmt);
            Log::info("Commission Add Up Value :" . $commissionAddUp);

            $agent->payout = Number_format($commissionAddUp, 2);
            $agent->save();

            AgentSettlementLog::updateOrCreate(
                $dataToCheck,
                [
                    'clientName' => $particularResult->clientName,
                    'agent_id' => $agent->id,
                    'startDate' => $particularResult->startDate,
                    'endDate' => $particularResult->endDate,
                    'trxSuccessAmt' => $particularResult->totalSuccessTrxAmt,
                    'commissionAmt' => $commissionAmt,
                ]
            );
        };

        // Amt owe to Client Entry in ClientsSettlementLog table
        clientSettlementLog::updateOrCreate(
            $dataToCheck,
            [
                'clientName' => $particularResult->clientName,
                'user_ID' => $particularResult->user_ID,
                'startDate' => $particularResult->startDate,
                'endDate' => $particularResult->endDate,
                'payoutAmt' => $particularResult->payoutAmt,
            ]
        );

        $clientSettlementLog = ClientSettlementLog::where('clientName', $particularResult->clientName)->get()->all();

        $netAmount = 0;

        foreach ($clientSettlementLog as $entry) {

            if ($entry->payoutAmt !== null && $entry->paymentMade == null) {
                $netAmount += (float) $entry->payoutAmt;
            } elseif ($entry->paymentMade !== null && $entry->payoutAmt == null) {
                $netAmount -= (float) $entry->paymentMade;
            }
        }

        ClientDetails::where('client_id', $particularResult->user_ID)->update(['payOutBalance' => $netAmount]);

        $result = $particularResult->update(['status' => 1]);

        if ($result) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function revertApproval(string $id)
    {
        $particularResult = WeeklyReports::where('id', $id)->first();

        $agentsList = ClientDetails::where('client_id', $particularResult->user_ID)
            ->pluck('agents')
            ->map(function ($item) {
                return json_decode($item, true);
            });

        $agentIds = collect($agentsList)->flatten()->all();

        // Reverting Agents Commission

        foreach ($agentIds as $agentId) {
            $agent = User::where('id', $agentId)->first();

            $commissionAmt = round(((floatval($particularResult->payoutAmt) * floatval($agent->commission)) / 100), 2);

            Log::info("Commission Amt Minus :" . $commissionAmt);

            $previousCommission = str_replace(',', '', $agent->payout ?? 0);
            $previousCommission = floatval($previousCommission);
            Log::info("Previous Commission :" . $previousCommission);

            $commissionReverted = floatval($previousCommission) - floatval($commissionAmt);
            Log::info("Commission Reverted :" . $commissionReverted);

            $agent->payout = round($commissionReverted, 2);
            $agent->save();

            AgentSettlementLog::where('agent_id', $agent->id)
                ->where('startDate', $particularResult->startDate)
                ->where('endDate', $particularResult->endDate)
                ->where('clientName', $particularResult->clientName)->delete();
        };

        // Removing Client Settlement Logs
        $deleteWork = clientSettlementLog::where('user_ID', $particularResult->user_ID)
            ->where('startDate', $particularResult->startDate)
            ->where('endDate', $particularResult->endDate)->delete();

        // Revert the report status back to 0    
        $updateWork = WeeklyReports::where('id', $id)->update(['status' => 0]);

        // Reverting the Client payout value in Client_details table
        $payoutAmt = (float) $particularResult->payoutAmt;
        $existingPayoutAmt = ClientDetails::where('client_id', $particularResult->user_ID)->pluck('payOutBalance')->first();
        $newPayoutAmt = $existingPayoutAmt - $payoutAmt;
        $updateWork1 = ClientDetails::where('client_id', $particularResult->user_ID)->update(['payOutBalance' => $newPayoutAmt]);

        if ($deleteWork && $updateWork && $updateWork1) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Try Again.');
        }
    }
}
