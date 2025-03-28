<?php

namespace App\Http\Controllers\Api;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\MainExportClass;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\WeeklyReports;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ReportGenerator extends Controller
{
    public function index(Request $request)
    {

        $fromDate = $request->input('orderdatefrom');
        $toDate = $request->input('orderdateto');

        $singleReportGeneration = $request->input('clientName');
        $regenerationToken = $request->regenrationToken;

        $pattern = 'pay_orders_%'; 
        $excludePattern = '%_3ds';

        if ($singleReportGeneration) {
            $tables = DB::select("SHOW TABLES LIKE '{$singleReportGeneration}'");
            $tableKey = 'Tables_in_' . env('DB_DATABASE') . " ($singleReportGeneration)";
            WeeklyReports::where('clientName', $singleReportGeneration)->update(['status' => null]);
        } else {
            // Query for tables matching a pattern
            $allTables = DB::select("SHOW TABLES LIKE '{$pattern}'");
            
            $tables = array_filter($allTables, function ($table) {
            
            $tableName = current((array) $table); // Convert object to array and get the first value
            return !preg_match('/(_3ds|_logs|_uuid|_3ds_validation)$/', $tableName); // Exclude tables ending with '_3ds'
            });
            
            $tableKey = 'Tables_in_' . env('DB_DATABASE') . " (pay_orders_%)";
        }
        
        // dd($tables);


        foreach ($tables as $table) {

            $tableName = $table->$tableKey;

            if ($tableName !== 'pay_orders_xm_refund') {

                // To Calculate USD Transactions
                $data = DB::table($tableName)
                    ->whereBetween('orderDate', [$fromDate, $toDate])
                    ->whereIn('orderStatus', [200, 2001, 2007, 2008, 2025]) //200 - Success , 2001 - Refunded, 2007 - Ethoca CB, 2008 - Chargebacks, 2025 - Partial Refunds
                    ->get()
                    ->toArray();

                // // // Skip if no data
                if (empty($data)) {

                    WeeklyReports::where('clientName', $tableName)->update(['filePath' => null, 'startDate' => $fromDate, 'endDate' => $toDate, 'status'=>null]);
                    continue;
                }

                // Processing USD Data
                $payable_to_client_usd = 0;
                $total_usd_transactions = 0;
                foreach ($data as $entry) {
                    if ($entry->currency == 'USD' && $entry->orderStatus == 200) {
                        $payable_to_client_usd += ($entry->amount) - ($entry->amount * 0.08);
                        $total_usd_transactions += $entry->amount;
                    }
                }

                $ProcessingUsdData = collect($data)->where('currency', 'USD')->whereIn('orderStatus', [200, 2001, 2007, 2008, 2025])->filter(function ($item) {
                    return $item !== null; // Exclude null values
                })->map(function ($item, $index) {

                    $leopartStripe = 0;
                    $leopartStripe_usdt = 0;
                    $designerLoungeStripe = 0;
                    $designerLoungeStripe_usdt = 0;
                    $crAmex = 0;
                    $emAmex = 0;
                    $fxAmex = 0;
                    $wembleyStripe = 0;
                    $wembleyStripe_usdt = 0;
                    $automatestripe = 0;
                    $automatestripe_usdt = 0;
                    $vtaxiscyStripe = 0;
                    $vtaxiscyStripe_usdt = 0;
                    $eMerchantPay = 0;

                    if ($item->bank_name == "Leopard Stripe") {
                        $leopartStripe += ($item->amount * 3.41) / 100;
                        $leopartStripe_usdt += $item->amount * 0.01;
                    } elseif ($item->bank_name == "DesignerLounge Stripe") {
                        $designerLoungeStripe += ($item->amount * 3.40) / 100;
                        $designerLoungeStripe_usdt += $item->amount * 0.01;
                    } elseif ($item->bank_name == "CR AMEX") {
                        $crAmex += ($item->amount * 3.10) / 100;
                    } elseif ($item->bank_name == "EM AMEX") {
                        $emAmex += ($item->amount * 3.10) / 100;
                    } elseif ($item->bank_name == "FX AMEX") {
                        $fxAmex += ($item->amount * 3.10) / 100;
                    } elseif ($item->bank_name == "Wembley Stripe") {
                        $wembleyStripe += ($item->amount * 3.36) / 100;
                        $wembleyStripe_usdt += $item->amount * 0.01;
                    } elseif ($item->bank_name == "Automate Stripe") {
                        $automatestripe += ($item->amount * 3.36) / 100;
                        $automatestripe_usdt += $item->amount * 0.01;
                    } elseif ($item->bank_name == "Vtaxiscy Stripe") {
                        $vtaxiscyStripe += ($item->amount * 4.1) / 100;
                        $vtaxiscyStripe_usdt += $item->amount * 0.01;
                    } elseif ($item->bank_name == "EmerchantPay 2D" || "EmerchantPayLiberty 3D" || "EmerchantPay") {
                        $eMerchantPay += ($item->amount * 4.75) / 100;
                    }


                    return [
                        'No' => $index + 1,
                        'Transaction ID' => $item->transactionID,
                        'Order Date' => $item->orderDate,
                        'Order Status' => "Success",
                        'Currency' => $item->currency,
                        'Acquirer_Status' => '',
                        'Amount' => $item->amount,
                        'Fee (8%)' => $item->amount * 0.08,
                        'Payable To Client' => ($item->amount) - ($item->amount * 0.08),
                        'Invoice Number' => $item->invoiceNumber,
                        'Bank Name' => $item->bank_name,
                        'Leopard Stripe (3.41%)' => $leopartStripe,
                        'Leopart Stripe USDt (1.00%)' => $leopartStripe_usdt,
                        'Designer Lounge Stripe (3.4%)' => $designerLoungeStripe,
                        'Designer Lounge Stripe USDt (1.00%)' => $designerLoungeStripe_usdt,
                        'CR Amex (3.10%)' => $crAmex,
                        'EM Amex (3.10%)' => $emAmex,
                        'FX Amex (3.10%)' => $fxAmex,
                        'Wembley Stripe (3.36%)' => $wembleyStripe,
                        'Wembley Stripe USDt (1.00%)' => $wembleyStripe_usdt,
                        'Automate Stripe (3.36%)' => $automatestripe,
                        'Automate Stripe USDt (1.00%)' => $automatestripe_usdt,
                        'Vtaxiscy Stripe (4.1%)' => $vtaxiscyStripe,
                        'Vtaxiscy Stripe USDt (1.00%)' => $vtaxiscyStripe_usdt,
                        'EMerchant Pay' => $eMerchantPay,
                        'Total PSP Fee' => ''
                    ];
                });

                //Processing Refunds USD
                $refunds_usd = 0;
                $refunds_fee_total = 0;
                foreach ($data as $entry) {
                    if ($entry->currency == 'USD' && $entry->orderStatus == 2001) {
                        $refunds_usd += ($entry->amount + 25);
                        $refunds_fee_total += 25;
                    }
                }

                Session::put('refunds_fee_total', $refunds_fee_total);

                $RefundsUsdData = collect($data)->where('currency', 'USD')->where('orderStatus', 2001)->filter(function ($item) {
                    return $item !== null; // Exclude null values
                })->map(function ($item, $index) {

                    return [
                        'No' => $index + 1,
                        'Dispute Date' => $item->orderDate,
                        'PSP Code' => $item->transactionID,
                        'Acquirer_Status' => '',
                        'Amount' => $item->amount,
                        'Refund Fee' => "$25.00",
                        'Total Amount' => $item->amount + 25,
                        'Client Name' => $item->fullName,
                        'Refunded?' => "Yes",
                        'Invoice Number' => $item->invoiceNumber,
                        'Bank Name' => $item->bank_name,
                    ];
                });

                // Processing Chargebacks USD
                $data1 = DB::table($tableName)
                    ->whereBetween('chargeback_date', [$fromDate, $toDate])
                    ->where('orderStatus', 2008) // 2008 - Chargebacks
                    ->where('included_in_report', 1)
                    ->get()
                    ->toArray();

                $chargebacks_usd = 0;
                $chargebacks_fee_total = 0;
                foreach ($data1 as $entry) {
                    if ($entry->currency == 'USD' && $entry->orderStatus == 2008) {
                        $chargebacks_usd += ($entry->amount + 50);
                        $chargebacks_fee_total += 50;
                    }
                }

                Session::put('chargebacks_fee_total', $chargebacks_fee_total);

                $ChargebackUSDData = collect($data1)->where('currency', 'USD')->whereIn('orderStatus', [2008, 2007])->filter(function ($item) {
                    return $item !== null; // Exclude null values
                })->map(function ($item, $index) {

                    return [
                        'No' => $index + 1,
                        'Dispute Date' => $item->orderDate,
                        'PSP Code' => $item->transactionID,
                        'Acquirer_Status' => '',
                        'Amount' => $item->amount,
                        'Chargeback Fee' => 50,
                        'Total Amount' => $item->amount + 50,
                        'Client Name' => $item->fullName,
                        'Blocked?' => '',
                        'Invoice Number' => $item->invoiceNumber,
                        'Bank Name' => $item->bank_name,
                    ];
                });

                $clientName = str_replace('pay_orders_', '', $tableName);

                // Processing Partial Refunds USD
                $data2 = DB::table('pay_orders_xm_refund')
                    ->whereBetween('refund_complete_date', [$fromDate, $toDate])
                    ->where('client', $clientName)
                    ->where('status', 1)
                    ->where('included_in_report', 0)
                    ->get()
                    ->toArray();

                $partialRefunds_usd = 0;
                $partialRefunds_fee_total = 0;
                foreach ($data2 as $entry) {
                    $partialRefunds_usd += ($entry->refund_amount + 25);
                    $partialRefunds_fee_total += 25;
                }

                Session::put('partialRefunds_fee_total', $partialRefunds_fee_total);

                $PartialRefundsUSDData = collect($data2)->filter(function ($item) {
                    return $item !== null; // Exclude null values
                })->map(function ($item, $index) {

                    return [
                        'No' => $index + 1,
                        'Refund Request Date' => $item->refund_request_date,
                        'Refund Complete Date' => $item->refund_complete_date,
                        'Acquirer_Status' => '',
                        'Amount' => $item->refund_amount,
                        'Refund Fee' => "$25.00",
                        'Total Amount' => $item->refund_amount + 25,
                        'Refunded?' => '',
                        'Blocked?' => '',
                        'Invoice Number' => $item->invoiceNumber,
                        'Refund_ID' => $item->refund_id,
                    ];
                });

                // Processing EURO Data
                $payable_to_client_eur = 0;
                $total_eur_transactions = 0;
                foreach ($data as $entry) {
                    if ($entry->currency == 'EUR' && $entry->orderStatus == 200) {
                        $payable_to_client_eur += ($entry->amount) - ($entry->amount * 0.08);
                        $total_eur_transactions += $entry->amount;
                    }
                }

                $ProcessingEuroData = collect($data)->where('currency', 'EUR')->whereIn('orderStatus', [200, 2001, 2007, 2008, 2025])->filter(function ($item) {
                    return $item !== null; // Exclude null values
                })->map(function ($item, $index) {


                    $leopartStripe = 0;
                    $leopartStripe_usdt = 0;
                    $designerLoungeStripe = 0;
                    $designerLoungeStripe_usdt = 0;
                    $crAmex = 0;
                    $emAmex = 0;
                    $fxAmex = 0;
                    $wembleyStripe = 0;
                    $wembleyStripe_usdt = 0;
                    $automatestripe = 0;
                    $automatestripe_usdt = 0;
                    $vtaxiscyStripe = 0;
                    $vtaxiscyStripe_usdt = 0;
                    $eMerchantPay = 0;

                    if ($item->bank_name == "Leopard Stripe") {
                        $leopartStripe += ($item->amount * 3.41) / 100;
                        $leopartStripe_usdt += $item->amount * 0.01;
                    } elseif ($item->bank_name == "DesignerLounge Stripe") {
                        $designerLoungeStripe += ($item->amount * 3.40) / 100;
                        $designerLoungeStripe_usdt += $item->amount * 0.01;
                    } elseif ($item->bank_name == "CR AMEX") {
                        $crAmex += ($item->amount * 3.10) / 100;
                    } elseif ($item->bank_name == "EM AMEX") {
                        $emAmex += ($item->amount * 3.10) / 100;
                    } elseif ($item->bank_name == "FX AMEX") {
                        $fxAmex += ($item->amount * 3.10) / 100;
                    } elseif ($item->bank_name == "Wembley Stripe") {
                        $wembleyStripe += ($item->amount * 3.36) / 100;
                        $wembleyStripe_usdt += $item->amount * 0.01;
                    } elseif ($item->bank_name == "Automate Stripe") {
                        $automatestripe += ($item->amount * 3.36) / 100;
                        $automatestripe_usdt += $item->amount * 0.01;
                    } elseif ($item->bank_name == "Vtaxiscy Stripe") {
                        $vtaxiscyStripe += ($item->amount * 4.1) / 100;
                        $vtaxiscyStripe_usdt += $item->amount * 0.01;
                    } elseif ($item->bank_name == "EmerchantPay 2D" || $item->bank_name == "EmerchantPayLiberty 3D" || $item->bank_name == "EmerchantPay") {
                        $eMerchantPay += ($item->amount * 4.75) / 100;
                    }

                    return [
                        'No' => $index + 1,
                        'Transaction ID' => $item->transactionID,
                        'Order Date' => $item->orderDate,
                        'Order Status' => "Success",
                        'Currency' => $item->currency,
                        'Acquirer_Status' => '',
                        'Amount' => $item->amount,
                        'Fee (8%)' => $item->amount * 0.08,
                        'Payable To Client' => ($item->amount) - ($item->amount * 0.08),
                        'Invoice Number' => $item->invoiceNumber,
                        'Bank Name' => $item->bank_name,
                        'Leopard Stripe (3.41%)' => $leopartStripe,
                        'Leopart Stripe USDt (1.00%)' => $leopartStripe_usdt,
                        'Designer Lounge Stripe (3.4%)' => $designerLoungeStripe,
                        'Designer Lounge Stripe USDt (1.00%)' => $designerLoungeStripe_usdt,
                        'CR Amex (3.10%)' => $crAmex,
                        'EM Amex (3.10%)' => $emAmex,
                        'FX Amex (3.10%)' => $fxAmex,
                        'Wembley Stripe (3.36%)' => $wembleyStripe,
                        'Wembley Stripe USDt (1.00%)' => $wembleyStripe_usdt,
                        'Automate Stripe (3.36%)' => $automatestripe,
                        'Automate Stripe USDt (1.00%)' => $automatestripe_usdt,
                        'Vtaxiscy Stripe (4.1%)' => $vtaxiscyStripe,
                        'Vtaxiscy Stripe USDt (1.00%)' => $vtaxiscyStripe_usdt,
                        'EMerchant Pay' => $eMerchantPay,
                        'Total PSP Fee' => ''
                    ];
                });

                //Processing Refunds EUR
                $refunds_eur = 0;
                $refunds_fee_total_eur = 0;
                foreach ($data as $entry) {
                    if ($entry->currency == 'EUR' && $entry->orderStatus == 2001) {
                        $refunds_eur += ($entry->amount + 25);
                        $refunds_fee_total_eur += 25;
                    }
                }

                Session::put('refunds_fee_total_eur', $refunds_fee_total_eur);

                $RefundsEurData = collect($data)->where('currency', 'EUR')->where('orderStatus', 2001)->filter(function ($item) {
                    return $item !== null; // Exclude null values
                })->map(function ($item, $index) {

                    return [
                        'No' => $index + 1,
                        'Dispute Date' => $item->orderDate,
                        'PSP Code' => $item->transactionID,
                        'Acquirer_Status' => '',
                        'Amount' => $item->amount,
                        'Refund Fee' => "$25.00",
                        'Total Amount' => $item->amount + 25,
                        'Client Name' => $item->fullName,
                        'Refunded?' => "Yes",
                        'Invoice Number' => $item->invoiceNumber,
                        'Bank Name' => $item->bank_name,
                    ];
                });

                $chargebacks_eur = 0;
                $chargebacks_fee_total_eur = 0;
                foreach ($data1 as $entry) {
                    if ($entry->currency == 'EUR' && $entry->orderStatus == 2008) {
                        $chargebacks_eur += ($entry->amount + 50);
                        $chargebacks_fee_total_eur += 50;
                    }
                }

                Session::put('chargebacks_fee_total_eur', $chargebacks_fee_total_eur);

                $ChargebackEurData = collect($data1)->where('currency', 'EUR')->whereIn('orderStatus', [2008, 2007])->filter(function ($item) {
                    return $item !== null; // Exclude null values
                })->map(function ($item, $index) {

                    return [
                        'No' => $index + 1,
                        'Dispute Date' => $item->orderDate,
                        'PSP Code' => $item->transactionID,
                        'Acquirer_Status' => '',
                        'Amount' => $item->amount,
                        'Chargeback Fee' => 50,
                        'Total Amount' => $item->amount + 50,
                        'Client Name' => $item->fullName,
                        'Blocked?' => '',
                        'Invoice Number' => $item->invoiceNumber,
                        'Bank Name' => $item->bank_name,
                    ];
                });

                $clientName = str_replace('pay_orders_', '', $tableName);

                // Processing Partial Refunds
                $partialRefunds_eur = 0;
                $partialRefunds_fee_total_eur = 0;
                foreach ($data2 as $entry) {
                    $partialRefunds_eur += ($entry->refund_amount + 25);
                    $partialRefunds_fee_total_eur += 25;
                }

                Session::put('partialRefunds_fee_total_eur', $partialRefunds_fee_total_eur);

                $PartialRefundsEurData = collect($data2)->filter(function ($item) {
                    return $item !== null; // Exclude null values
                })->map(function ($item, $index) {

                    return [
                        'No' => $index + 1,
                        'Refund Request Date' => $item->refund_request_date,
                        'Refund Complete Date' => $item->refund_complete_date,
                        'Acquirer_Status' => '',
                        'Amount' => $item->refund_amount,
                        'Refund Fee' => "$25.00",
                        'Total Amount' => $item->refund_amount + 25,
                        'Refunded?' => '',
                        'Blocked?' => '',
                        'Invoice Number' => $item->invoiceNumber,
                        'Refund_ID' => $item->refund_id,
                    ];
                });

                //Cumulative Sheet Calculations
                $payable_to_client_usd1 = round($payable_to_client_usd - ($chargebacks_usd + $refunds_usd + $partialRefunds_usd), 2);
                $payable_to_client_eur1 = round(($payable_to_client_eur - (($chargebacks_eur + $refunds_eur + $partialRefunds_eur))) * 1.03, 2);
                $payable_to_client_total = round($payable_to_client_usd1 + $payable_to_client_eur1, 2);
                $crypto_charge = round($payable_to_client_total * 0.02, 2);
                $amt_owe_to_client = round($payable_to_client_total - $crypto_charge, 2);
                $cumulativeValues = [
                    ['Description', 'Value (in $)'], // Header row
                ];

                Session::put('cryptoCharge', $crypto_charge);

                $values = [
                    'USD CALCULATIONS' => '',
                    'Processing USD' => $payable_to_client_usd ?? 0,
                    'Less : Chargebacks USD' => $chargebacks_usd ?? 0,
                    'Less : Refunds USD' => $refunds_usd ?? 0,
                    'Less : Partial Refunds USD' => $partialRefunds_usd ?? 0,
                    'Payable to Client - USD' => $payable_to_client_usd1 ?? 0,
                    'EURO CALCULATIONS' => '',
                    'Processing EUR (*Converted to USD*) ' => ($payable_to_client_eur * 1.03) ?? 0,
                    'Less : Chargebacks EUR' => $chargebacks_eur ?? 0,
                    'Less : Refunds EUR' => $refunds_eur ?? 0,
                    'Less : Partial Refunds EUR' => $partialRefunds_eur ?? 0,
                    'Payable to Client - EUR' => $payable_to_client_eur1 ?? 0,
                    'NET CALCULATIONS' => '',
                    'Payable to Client - TOTAL' => $payable_to_client_total ?? 0,
                    'Less : 2% Settlement Fee in Crypto' => $crypto_charge ?? 0,
                    'Amount we owe to Client - FINAL' => $amt_owe_to_client ?? 0,
                ];

                foreach ($values as $key => $value) {
                    // Append a row as [key, value]
                    $cumulativeValues[] = [$key, $value];
                }

                // Agents Settlement Calculation
                $volume_transaction_successfull = $total_usd_transactions + $total_eur_transactions;
                $payit123_mdr_fees = $volume_transaction_successfull * 0.07;
                $camitrade_mdr_fees = $volume_transaction_successfull * 0.01;
                $total_mdr_fees = $volume_transaction_successfull * 0.08;

                $agentSettlementValues = [];

                $agentSettlementValues = [
                    ['AGENT SETTLEMENT', '', '', ''], // Header row
                    ['', '', '', ''],
                    ['Volume Transacted Successfully', '', '', $volume_transaction_successfull],
                    ['', '', '', ''],
                    ['', 'PAYIT123', 'CAMITRADE', 'TOTAL'],
                    ['Setup Fees', '$  -', '$   -', '$   -'],
                    ['', '', '', ''],
                    ['MDR Rate', '7.00%', '1.00%', '8.00%'],
                    ['', '', '', ''],
                    ['MDR Fees', $payit123_mdr_fees, $camitrade_mdr_fees, $total_mdr_fees],
                    ['', '', '', ''],
                    ['', '', '', ''],
                    ['', '', '', ''],
                    ['', '', '', ''],
                    ['', '', '', ''],
                    ['USDt Profit of 2%', $crypto_charge, '', ''],
                    ['', '', '', ''],
                    ['USDt Cost', '', '', ''],
                    ['', '', '', ''],
                    ['Less : 2% USDt Payout', '', '', ''],
                    ['', '', '', ''],
                    ['Final Payout', '', '', ''],
                    ['', '', '', ''],
                    ['', '', '', ''],
                    ['', '', '', ''],
                    ['Crypto', '', '', ''],
                    ['Total', '', '', ''],
                    ['', '', '', ''],
                    ['PYY - S2S', '', '', ''],
                    ['', '', '', ''],
                    ['PYY - Limegrove', '', '', ''],
                    ['', '', '', ''],
                    ['50 Cents', '', '', ''],
                    ['', '', '', ''],
                    ['Crypto Waves', '', '', ''],
                    ['', '', '', ''],
                    ['CBS Fees', '', '', ''],
                ];

                // Export data to Excel
                $fileName = "/exports/{$tableName}.xlsx";
                $fileHeading = strtoupper($tableName) . ' ' . "Clearing Report for the Period from " . $fromDate . ' to ' . $toDate;

                if ($singleReportGeneration !== null && $regenerationToken == '') {

                    $newFileName = $singleReportGeneration . '_' . $fromDate . '_' . $toDate  . '.xlsx';
                    return Excel::download(new MainExportClass(
                        $ProcessingUsdData->toArray(),
                        $RefundsUsdData->toArray(),
                        $ChargebackUSDData->toArray(),
                        $PartialRefundsUSDData->toArray(),
                        $ProcessingEuroData->toArray(),
                        $RefundsEurData->toArray(),
                        $ChargebackEurData->toArray(),
                        $PartialRefundsEurData->toArray(),
                        $cumulativeValues,
                        $agentSettlementValues,
                        $fileHeading
                    ), $newFileName);
                } elseif ($singleReportGeneration !== null && $regenerationToken == "Regeneration") {

                    Excel::store(new MainExportClass(
                        $ProcessingUsdData->toArray(),
                        $RefundsUsdData->toArray(),
                        $ChargebackUSDData->toArray(),
                        $PartialRefundsUSDData->toArray(),
                        $ProcessingEuroData->toArray(),
                        $RefundsEurData->toArray(),
                        $ChargebackEurData->toArray(),
                        $PartialRefundsEurData->toArray(),
                        $cumulativeValues,
                        $agentSettlementValues,
                        $fileHeading
                    ), $fileName, 'public');

                    $fileUrl = "https://payit123crm.com/CRM/storage/app/public/exports/". $tableName . ".xlsx";

                    WeeklyReports::updateOrCreate(
                        ['clientName' => $tableName],
                        ['clientName' => $tableName, 'startDate' => $fromDate, 'endDate' => $toDate, 'filePath' => $fileUrl]
                    );
                } elseif ($singleReportGeneration === null && $regenerationToken == "") {

                    Excel::store(new MainExportClass(
                        $ProcessingUsdData->toArray(),
                        $RefundsUsdData->toArray(),
                        $ChargebackUSDData->toArray(),
                        $PartialRefundsUSDData->toArray(),
                        $ProcessingEuroData->toArray(),
                        $RefundsEurData->toArray(),
                        $ChargebackEurData->toArray(),
                        $PartialRefundsEurData->toArray(),
                        $cumulativeValues,
                        $agentSettlementValues,
                        $fileHeading
                    ), $fileName, 'public');

                    $fileUrl = "https://payit123crm.com/CRM/storage/app/public/exports/". $tableName . ".xlsx";

                    WeeklyReports::updateOrCreate(
                        ['clientName' => $tableName],
                        ['clientName' => $tableName, 'startDate' => $fromDate, 'endDate' => $toDate, 'filePath' => $fileUrl]
                    );
                }
            }
        }

        // return response()->json(['message' => 'Data exported successfully']);
        return redirect()->back();
    }

    public function approveReport(string $id)
    {
        $result = WeeklyReports::where('id', $id)->update(['status' => 1]);
        if ($result) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function revertApproval(string $id)
    {
        $result = WeeklyReports::where('id', $id)->update(['status' => 0]);
        if ($result) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Try Again.');
        }
    }
}
