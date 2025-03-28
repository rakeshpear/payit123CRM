<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ReportMainHelper
{
    public static function processTransactionData(array $data, string $currency, string $clientName)
    {

        
        $agentsArray = json_decode(Session::get('agentsData'),true);
        $pspsArray = json_decode(Session::get('pspsData'),true);
        
        
    
        return collect($data)
            ->where('currency', $currency)
            ->filter(function ($item) {return $item !== null;})
            ->map(function ($item, $index) use ($agentsArray, $pspsArray) {

                $orderStatusMap = [
                    200 => "Success",
                    2001 => "Refunded",
                    2005 => "Fraud Warning",
                    2007 => "Ethoca CB",
                    2008 => "Chargeback",
                    2009 => "High Risk",
                    2025 => "Partial Refund",
                ];

                $row = [
                    'No' => $index + 1,
                    'Transaction ID' => $item->transactionID,
                    'Order Date' => $item->orderDate,
                    'Order Status' => $orderStatusMap[$item->orderStatus] ?? '',
                    'Currency' => $item->currency,
                    'Acquirer_Status' => '',
                    'Amount' => $item->amount,
                    'Fee (MDR - ' . Session::get('clientMDRValue') . ')' => '',
                    'Before RR - TRX Fee ( ' . Session::get('clientTrxValue') . $item->currency . ' )' => '',
                    'RR - ' . Session::get('clientRollingReserve') . '%' => '',
                    'Payable To Client - Final' => '',
                    'Invoice Number' => $item->invoiceNumber,
                ];


                if (!empty($agentsArray) && is_array($agentsArray)) {
                    foreach ($agentsArray as $agent) {
                        $row[$agent['agent'] . ' - ' . $agent['share']] = round(((float) $item->amount * (float) $agent['share']) / 100, 2);
                    }
                }

                // MDR Value
                $tempMDRValue = ($item->amount * Session::get('clientMDRValue')) / 100;

                //Total Agent Fee
                $totalAgentFee = 0;
                foreach ($agentsArray as $agent) {
                    $totalAgentFee += round(((float) $item->amount * (float) $agent['share']) / 100, 2);
                }

                // Total PSP Fee
                $totalPSPFee = 0;
                foreach ($pspsArray as $psp) {
                    if ($psp['pspName'] == $item->bank_name) {
                        $tempPSPFee = round(((float) ($item->amount ?? 0) * (float) ($psp['pspFee'] ?? 0)) / 100, 2);
                        $totalPSPFee += $tempPSPFee ?? 0;
                    }
                }

                $netAfter = $tempMDRValue - $totalAgentFee - $totalPSPFee;

                $limegrove = round((float) $netAfter / 2, 2);
                $pyyShare = round((float) $netAfter / 2, 2);


                $row += [
                    'Net after PSP & Client' => $netAfter,
                    'Limegrove 50%' => $limegrove,
                    'PYY Share' => $pyyShare,
                    'Bank Name' => $item->bank_name,
                ];

                // if (!empty($pspsArray) && is_array($pspsArray)) {
                //     foreach ($pspsArray as $psp) {
                //         if ($psp['pspName'] == $item->bank_name) {
                //             $row[$psp['pspName'] . ' - ' . $psp['pspFee']] = round(((float) $item->amount * (float) $psp['pspFee']) / 100, 2);
                //         } else {
                //             $row[$psp['pspName'] . ' - ' . $psp['pspFee']] = 0.00;
                //         }
                //     }
                // }
                
                if (!empty($pspsArray) && is_array($pspsArray)) {
                    foreach ($pspsArray as $psp) {

                        $currency = strtolower($item->currency);

                        if ($psp['pspName'] == $item->bank_name && isset($psp[$currency])) {
                            $pspFee = (float) $psp[$currency];

                            // Calculate the fee only if it's greater than zero
                            if ($pspFee > 0) {
                                $row[$psp['pspName'] . ' - ' . strtoupper($currency)] = round(((float) $item->amount * $pspFee) / 100, 2);
                            } else {
                                $row[$psp['pspName'] . ' - ' . strtoupper($currency)] = 0.00;
                            }
                        }
                    }
                }

                $row += [
                    'Total PSP Fee' => $totalPSPFee,
                ];

                return $row;
            });
    }
}
