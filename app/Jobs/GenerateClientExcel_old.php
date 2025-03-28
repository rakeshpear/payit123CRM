<?php

namespace App\Jobs;

use App\Exports\MainExportClass;
use App\Models\User;
use App\Models\WeeklyReports;
use App\Models\ClientSettlementLog;
use App\Models\ClientDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use App\Helpers;


class GenerateClientExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;

    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle()
    {

     try{
     
        Log::info('Queue job started: ' . get_class($this));
     
        // Currency Conversion
        $symbol = 'JPY,AUD,AED,GBP,EUR';
        $apiUrl = 'http://data.fixer.io/api/latest?access_key=' . env('CURRENCY_CONVERSION_KEY') . '&base=USD&symbols=' . $symbol;

        $response = Http::get($apiUrl);

        Log::info($response);

        $data = $response->json();

        $JPYtoUSD = number_format(1 / (float) $data['rates']['JPY'], 4);
        $AUDtoUSD = number_format(1 / (float) $data['rates']['AUD'], 4);
        $AEDtoUSD = number_format(1 / (float) $data['rates']['AED'], 4);
        $GBPtoUSD = number_format(1 / (float) $data['rates']['GBP'], 4);
        $EURtoUSD = number_format(1 / (float) $data['rates']['EUR'], 4);

        Session::put('JPYtoUSD', $JPYtoUSD);
        Session::put('AUDtoUSD', $AUDtoUSD);
        Session::put('AEDtoUSD', $AEDtoUSD);
        Session::put('GBPtoUSD', $GBPtoUSD);
        Session::put('EURtoUSD', $EURtoUSD);

        $JPYtoUSD_1 = number_format($data['rates']['JPY'], 4);
        $AUDtoUSD_1 = number_format($data['rates']['AUD'], 4);
        $AEDtoUSD_1 = number_format($data['rates']['AED'], 4);
        $GBPtoUSD_1 = number_format($data['rates']['GBP'], 4);
        $EURtoUSD_1 = number_format($data['rates']['EUR'], 4);

        Session::put('JPYtoUSD_1', $JPYtoUSD_1);
        Session::put('AUDtoUSD_1', $AUDtoUSD_1);
        Session::put('AEDtoUSD_1', $AEDtoUSD_1);
        Session::put('GBPtoUSD_1', $GBPtoUSD_1);
        Session::put('EURtoUSD_1', $EURtoUSD_1);

        try {

            Session()->flush();

            $currentDate = Carbon::now();
            Log::info($currentDate);

            // Find the Monday of the current week
            $currentWeekStart = $currentDate->startOfWeek(Carbon::MONDAY);

            // Go back one week to find the previous week's Monday
            $previousWeekStart = $currentWeekStart->subWeek();

            // Find the Sunday of the previous week
            $previousWeekEnd = $previousWeekStart->copy()->endOfWeek(Carbon::SUNDAY);

            $fromDate = $previousWeekStart->toDateString();
            $toDate = $previousWeekEnd->toDateString();

            // $fromDate = "2024-11-15";
            // $toDate = "2024-11-21";

            $toDateFull = Carbon::parse($toDate)->endOfDay();

            Log::info("Hi");
            Log::info("From Date : " . $fromDate);
            Log::info("To Date : " . $toDate);

            $merchants = User::where('role', 10)->get();

            foreach ($merchants as $merchant) {

                $clientMDRValue = $merchant->clientDetails->psp;
                Session::put('clientMDRValue', $clientMDRValue);

                $clientTrxValue = $merchant->clientDetails->transaction_fee;
                $clientRollingReserve = $merchant->clientDetails->rolling_reserve;
                $clientpayIT123Share = $merchant->clientDetails->payit123share;
                $clientName = $merchant->name;
                $crypto_fee = $merchant->clientDetails->crypto_fee;
                $chargeback_fee = $merchant->clientDetails->chargeback_fee;
                $refund_fee = $merchant->clientDetails->refund_fee;
                $highRisk_fee = $merchant->clientDetails->highRisk_fee;
                $fraudWarning_fee = $merchant->clientDetails->fraudWarning_fee;

                Session::put('clientTrxValue', $clientTrxValue);
                Session::put('clientRollingReserve', $clientRollingReserve);
                Session::put('clientpayIT123Share', $clientpayIT123Share);
                Session::put('crypto_fee', $crypto_fee);
                Session::put('chargeback_fee', $chargeback_fee);
                Session::put('refund_fee', $refund_fee);
                Session::put('highRisk_fee', $highRisk_fee);
                Session::put('fraudWarning_fee', $fraudWarning_fee);


                $tableName = "pay_orders_" . $clientName;

                if ($tableName !== 'pay_orders_xm_refund') {

                    // To Calculate USD Transactions 
                    $data = DB::connection('mysql2')->table($tableName)
                        ->select('transactionID', 'fullName', 'orderDate', 'amount', 'currency', 'orderStatus', 'invoiceNumber', 'bank_name')
                        ->whereBetween('orderDate', [$fromDate, $toDateFull])
                        ->whereIn('orderStatus', [200, 2001, 2006, 2007, 2008, 2009, 2025])
                        ->orderBy('orderDate', 'desc')
                        ->get()
                        ->toArray();

                    // // // Skip if no data
                    if (empty($data)) {
                        WeeklyReports::where('clientName', $tableName)->update(['filePath' => null, 'startDate' => $fromDate, 'endDate' => $toDate]);
                        continue;
                    }

                    $currencies = ['USD', 'EUR', 'JPY', 'GBP', 'AUD', 'AED'];
                    $flags = [];

                    foreach ($currencies as $currency) {
                        // Check if there are rows with the specified currency
                        $currencyRows = collect($data)->where('currency', $currency);

                        // Set the corresponding flag based on whether the rows are empty
                        $flags[$currency . 'Flag'] = $currencyRows->isEmpty() ? 0 : 1;
                    }

                    Session::put([
                        'usdFlag' => $flags['USDFlag'],
                        'eurFlag' => $flags['EURFlag'],
                        'jpyFlag' => $flags['JPYFlag'],
                        'gbpFlag' => $flags['GBPFlag'],
                        'audFlag' => $flags['AUDFlag'],
                        'aedFlag' => $flags['AEDFlag'],
                    ]);

                    // Initialize results
                    $payable_to_client = [];
                    $total_transactions = [];
                    $processedData = [];
                    $refunds = [];
                    $fraudWarnings = [];
                    $highRisks = [];
                    $chargebacks = [];
                    $partialRefunds = [];

                    foreach ($currencies as $currency) {

                        if ($flags[$currency . 'Flag'] === 1) {
                            // Initialize totals for the current currency
                            $payable_to_client[$currency] = 0;
                            $total_transactions[$currency] = 0;
                        }

                        if ($currency !== 'USD') {
                            $exchangeRates = [
                                'EUR' => $EURtoUSD_1 ?? null,
                                'JPY' => $JPYtoUSD_1 ?? null,
                                'AUD' => $AUDtoUSD_1 ?? null,
                                'AED' => $AEDtoUSD_1 ?? null,
                                'GBP' => $GBPtoUSD_1 ?? null,
                            ];

                            if (isset($exchangeRates[$currency]) && is_numeric($exchangeRates[$currency])) {
                                $clientTrxValue *= $exchangeRates[$currency];
                            }
                        }


                        foreach ($data as $entry) {
                            if ($entry->currency == $currency) {
                                $amountMinusFee = $entry->amount - (($entry->amount * Session::get('clientMDRValue')) / 100);
                                $amountPlusTrxFee = $amountMinusFee - $clientTrxValue;
                                $afterRRValue = $amountPlusTrxFee - (($entry->amount * Session::get('clientRollingReserve')) / 100);
                                $payable_to_client[$currency] += $afterRRValue;
                                $total_transactions[$currency] += $entry->amount;
                            }
                        }

                        $processedData[$currency] = collect($data)->where('currency', $currency)->filter(function ($item) {
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

                            $orderStatusValue = "";

                            if ($item->orderStatus == 200) {
                                $orderStatusValue = "Success";
                            } elseif ($item->orderStatus == 2001) {
                                $orderStatusValue = "Refunded";
                            } elseif ($item->orderStatus == 2005) {
                                $orderStatusValue = "Fraud Warning";
                            } elseif ($item->orderStatus == 2007) {
                                $orderStatusValue = "Ethoca CB";
                            } elseif ($item->orderStatus == 2008) {
                                $orderStatusValue = "Chargeback";
                            } elseif ($item->orderStatus == 2009) {
                                $orderStatusValue = "High Risk";
                            } elseif ($item->orderStatus == 2025) {
                                $orderStatusValue = "Partial Refund";
                            }

                            return [
                                'No' => $index + 1,
                                'Transaction ID' => $item->transactionID,
                                'Order Date' => $item->orderDate,
                                'Order Status' => $orderStatusValue,
                                'Currency' => $item->currency,
                                'Acquirer_Status' => '',
                                'Amount' => $item->amount,
                                'Fee (MDR - ' . Session::get('clientMDRValue') => '',
                                'Before RR - TRX Fee ( ' . Session::get('clientTrxValue') . 'USD)' => '',
                                'RR - ' . Session::get('clientRollingReserve') . '%' => '',
                                'Payable To Client - Final' => '',
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

                        // Query to process Refunds, Chargebacks, Fraud Warning & High Risk Transactions

                        $rcfhData_2025DB = DB::connection('mysql2')->table($tableName)
                            ->whereBetween('chargeback_date', [$fromDate, $toDateFull])
                            ->whereIn('orderStatus', [2001, 2006, 2007, 2008, 2009]) // Includes Chargebacks (2007, 2008) and Fraud Warning (2006)
                            ->where('included_in_report', 0)
                            ->get();

                        $rcfhData_2024DB = DB::connection('mysql4')->table($tableName)
                            ->whereBetween('chargeback_date', [$fromDate, $toDateFull])
                            ->whereIn('orderStatus', [2001, 2006, 2007, 2008, 2009]) // Includes Chargebacks (2007, 2008) and Fraud Warning (2006)
                            ->where('included_in_report', 0)
                            ->get();

                        $rcfhDataMerged = $rcfhData_2025DB->merge($rcfhData_2024DB);

                        $rcfhData = $rcfhDataMerged->sortByDesc('orderDate')->values();

                        $rcfhDataGrouped = $rcfhData->groupBy('orderStatus')->map(function ($items) {
                            return $items->toArray(); // Convert collection to array
                        });

                        $refundsData = $rcfhDataGrouped->get(2001, []);
                        $chargebacksData = array_merge(
                            $rcfhDataGrouped->get(2007, []),
                            $rcfhDataGrouped->get(2008, [])
                        );
                        $fraudWarningsData = $rcfhDataGrouped->get(2006, []);
                        $highRiskData = $rcfhDataGrouped->get(2009, []);

                        // Process Chargebacks
                        $chargebacks[$currency] = \App\Helpers\processChargebacks($chargebacksData, $currency);


                        //Processing Refunds
                        $refunds[$currency] = \App\Helpers\processRefunds($refundsData, $currency);

                        // Process Fraud Warnings
                        $fraudWarnings[$currency] = \App\Helpers\fraudWarnings($fraudWarningsData, $currency);

                        // Process High Risk Transactions
                        $highRisks[$currency] = \App\Helpers\highRisks($highRiskData, $currency);

                        // Processing Partial Refunds USD
                        $data2 = DB::connection('mysql2')->table('pay_orders_xm_refund')
                            ->whereBetween('refund_complete_date', [$fromDate, $toDateFull])
                            ->where('client', $clientName)
                            ->where('status', 0)
                            ->where('currency', $currency)
                            ->where('included_in_report', 0)
                            ->get()
                            ->toArray();

                        $partialRefunds[$currency] = \App\Helpers\processPartialRefunds($data2, $currency);
                    }
                }

                // USD
                $chargebacks_USD = Session::get('chargebacksTotalUSD') ?? 0;
                $refunds_USD = Session::get('refundsTotalUSD') ?? 0;
                $fraudWarnings_USD = Session::get('fraudWarningsTotalUSD') ?? 0;
                $highRisks_USD = Session::get('highRisksTotalUSD') ?? 0;
                $partialRefunds_USD = Session::get('partialRefundsTotalUSD') ?? 0;
                $payable_to_client_usd1 = round((($payable_to_client['USD'] ?? 0) - ($chargebacks_USD + $fraudWarnings_USD + $highRisks_USD + $refunds_USD + $partialRefunds_USD)), 2);

                // EUR
                $chargebacks_EUR = Session::get('chargebacksTotalEUR') * $EURtoUSD ?? 0;
                $refunds_EUR = Session::get('refundsTotalEUR') * $EURtoUSD ?? 0;
                $fraudWarnings_EUR = Session::get('fraudWarningsTotalEUR') * $EURtoUSD ?? 0;
                $highRisks_EUR = Session::get('highRisksTotalEUR') * $EURtoUSD ?? 0;
                $partialRefunds_EUR = Session::get('partialRefundsTotalEUR') * $EURtoUSD ?? 0;
                $payable_to_client_eur1 = round(((($payable_to_client['EUR'] ?? 0) * $EURtoUSD) - ($chargebacks_EUR + $fraudWarnings_EUR + $highRisks_EUR + $refunds_EUR + $partialRefunds_EUR)), 2);

                // JPY
                $chargebacks_JPY = Session::get('chargebacksTotalJPY') * $JPYtoUSD ?? 0;
                $refunds_JPY = Session::get('refundsTotalJPY') * $JPYtoUSD ?? 0;
                $fraudWarnings_JPY = Session::get('fraudWarningsTotalJPY') * $JPYtoUSD ?? 0;
                $highRisks_JPY = Session::get('highRisksTotalJPY') * $JPYtoUSD ?? 0;
                $partialRefunds_JPY = Session::get('partialRefundsTotalJPY') * $JPYtoUSD ?? 0;
                $payable_to_client_jpy1 = round(((($payable_to_client['JPY'] ?? 0)  * $JPYtoUSD) - ($chargebacks_JPY + $fraudWarnings_JPY + $highRisks_JPY + $refunds_JPY + $partialRefunds_JPY)), 2);

                // AUD
                $chargebacks_AUD = Session::get('chargebacksTotalAUD') * $AUDtoUSD ?? 0;
                $refunds_AUD = Session::get('refundsTotalAUD') * $AUDtoUSD ?? 0;
                $fraudWarnings_AUD = Session::get('fraudWarningsTotalAUD') * $AUDtoUSD ?? 0;
                $highRisks_AUD = Session::get('highRisksTotalAUD') * $AUDtoUSD ?? 0;
                $partialRefunds_AUD = Session::get('partialRefundsTotalAUD') * $AUDtoUSD ?? 0;
                $payable_to_client_aud1 = round(((($payable_to_client['AUD']  ?? 0) * $AUDtoUSD) - ($chargebacks_AUD + $fraudWarnings_AUD + $highRisks_AUD + $refunds_AUD + $partialRefunds_AUD)), 2);

                // AED
                $chargebacks_AED = Session::get('chargebacksTotalAED') * $AEDtoUSD ?? 0;
                $refunds_AED = Session::get('refundsTotalAED') * $AEDtoUSD ?? 0;
                $fraudWarnings_AED = Session::get('fraudWarningsTotalAED') * $AEDtoUSD ?? 0;
                $highRisks_AED = Session::get('highRisksTotalAED') * $AEDtoUSD ?? 0;
                $partialRefunds_AED = Session::get('partialRefundsTotalAED') * $AEDtoUSD ?? 0;
                $payable_to_client_aed1 = round(((($payable_to_client['AED'] ?? 0) * $AEDtoUSD ?? 0) - ($chargebacks_AED + $fraudWarnings_AED + $highRisks_AED + $refunds_AED + $partialRefunds_AED)), 2);

                // GBP
                $chargebacks_GBP = Session::get('chargebacksTotalGBP') * $GBPtoUSD ?? 0;
                $refunds_GBP = Session::get('refundsTotalGBP') * $GBPtoUSD ?? 0;
                $fraudWarnings_GBP = Session::get('fraudWarningsTotalGBP') * $GBPtoUSD ?? 0;
                $highRisks_GBP = Session::get('highRisksTotalGBP') * $GBPtoUSD ?? 0;
                $partialRefunds_GBP = Session::get('partialRefundsTotalGBP') * $GBPtoUSD ?? 0;
                $payable_to_client_gbp1 = round(((($payable_to_client['GBP'] ?? 0) * $GBPtoUSD)  - ($chargebacks_GBP + $fraudWarnings_GBP + $highRisks_GBP + $refunds_GBP + $partialRefunds_GBP)), 2);

                $payable_to_client_total = round($payable_to_client_usd1 + $payable_to_client_eur1 + $payable_to_client_jpy1 + $payable_to_client_aud1 + $payable_to_client_aed1 + $payable_to_client_gbp1, 2);
                $crypto_charge = round($payable_to_client_total * ($crypto_fee / 100), 2);
                $amt_owe_to_client = round($payable_to_client_total - $crypto_charge, 2);


                $cumulativeValues = [
                    ['Description', 'Value (in $)'], // Header row
                ];

                Session::put('cryptoCharge', $crypto_charge);

                $values = [];


                if (Session::get('usdFlag') == 1) {
                    $values = array_merge($values, [
                        'USD CALCULATIONS' => 'VALUES',
                        'Processing USD' => $payable_to_client['USD'] ?? 0,
                        'Less : Chargebacks USD' => Session::get('chargebacksTotalUSD') ?? 0,
                        'Less : Refunds USD' => Session::get('refundsTotalUSD') ?? 0,
                        'Less : Fraud Warning USD' => Session::get('fraudWarningsTotalUSD') ?? 0,
                        'Less : High Risks USD' => Session::get('highRisksTotalUSD') ?? 0,
                        'Less : Partial Refunds USD' => Session::get('partialRefundsTotalUSD') ?? 0,
                        'Payable to Client - USD' => $payable_to_client_usd1 ?? 0,
                    ]);
                }

                if (Session::get('eurFlag') == 1) {
                    $values = array_merge($values, [
                        'EURO CALCULATIONS' => 'VALUES Converted to USD (Rate : ' . $EURtoUSD . ' )',
                        'Processing EURO' => $payable_to_client['EUR'] ?? 0,
                        'Less : Chargebacks EUR' => Session::get('chargebacksTotalEUR') ?? 0,
                        'Less : Refunds EUR' => Session::get('refundsTotalEUR') ?? 0,
                        'Less : Fraud Warning EUR' => Session::get('fraudWarningsTotalEUR') ?? 0,
                        'Less : High Risks EUR' => Session::get('highRisksTotalEUR') ?? 0,
                        'Less : Partial Refunds EUR' => Session::get('partialRefundsTotalEUR') ?? 0,
                        'Payable to Client - EUR (** Converted to USD ** - Conversion Rate' . $EURtoUSD . ')' => $payable_to_client_eur1 ?? 0,
                    ]);
                }

                if (Session::get('jpyFlag') == 1) {
                    $values = array_merge($values, [
                        'JPY CALCULATIONS' => 'VALUES Converted to USD (Rate :' . $JPYtoUSD . ')',
                        'Processing JPY' => $payable_to_client['JPY'] ?? 0,
                        'Less : Chargebacks JPY' => Session::get('chargebacksTotalJPY') ?? 0,
                        'Less : Refunds JPY' => Session::get('refundsTotalJPY') ?? 0,
                        'Less : Fraud Warning JPY' => Session::get('fraudWarningsTotalJPY') ?? 0,
                        'Less : High Risks JPY' => Session::get('highRisksTotalJPY') ?? 0,
                        'Less : Partial Refunds JPY' => Session::get('partialRefundsTotalJPY') ?? 0,
                        'Payable to Client - JPY (** Converted to USD ** - Conversion Rate' . $JPYtoUSD . ')' => $payable_to_client_jpy1 ?? 0,
                    ]);
                }

                if (Session::get('audFlag') == 1) {
                    $values = array_merge($values, [
                        'AUD CALCULATIONS' => 'VALUES Converted to USD (Rate :' . $AUDtoUSD . ')',
                        'Processing AUD' => $payable_to_client['AUD'] ?? 0,
                        'Less : Chargebacks AUD' => Session::get('chargebacksTotalAUD') ?? 0,
                        'Less : Refunds AUD' => Session::get('refundsTotalAUD') ?? 0,
                        'Less : Fraud Warning AUD' => Session::get('fraudWarningsTotalAUD') ?? 0,
                        'Less : High Risks AUD' => Session::get('highRisksTotalAUD') ?? 0,
                        'Less : Partial Refunds AUD' => Session::get('partialRefundsTotalAUD') ?? 0,
                        'Payable to Client - AUD (** Converted to USD ** - Conversion Rate' . $AUDtoUSD . ')' => $payable_to_client_aud1 ?? 0,
                    ]);
                }

                if (Session::get('aedFlag') == 1) {
                    $values = array_merge($values, [
                        'AED CALCULATIONS' => 'VALUES Converted to USD (Rate :' . $AEDtoUSD . ')',
                        'Processing AED' => $payable_to_client['AED'] ?? 0,
                        'Less : Chargebacks AED' => Session::get('chargebacksTotalAED') ?? 0,
                        'Less : Refunds AED' => Session::get('refundsTotalAED') ?? 0,
                        'Less : Fraud Warning AED' => Session::get('fraudWarningsTotalAED') ?? 0,
                        'Less : High Risks AED' => Session::get('highRisksTotalAED') ?? 0,
                        'Less : Partial Refunds AED' => Session::get('partialRefundsTotalAED') ?? 0,
                        'Payable to Client - AED (** Converted to USD ** - Conversion Rate' . $AEDtoUSD . ')' => $payable_to_client_aed1 ?? 0,
                    ]);
                }

                if (Session::get('gbpFlag') == 1) {
                    $values = array_merge($values, [
                        'GBP CALCULATIONS' => 'VALUES Converted to USD (Rate :' . $GBPtoUSD . ')',
                        'Processing GBP' => $payable_to_client['GBP'] ?? 0,
                        'Less : Chargebacks GBP' => Session::get('chargebacksTotalGBP') ?? 0,
                        'Less : Refunds GBP' => Session::get('refundsTotalGBP') ?? 0,
                        'Less : Fraud Warning GBP' => Session::get('fraudWarningsTotalGBP') ?? 0,
                        'Less : High Risks GBP' => Session::get('highRisksTotalGBP') ?? 0,
                        'Less : Partial Refunds GBP' => Session::get('partialRefundsTotalGBP') ?? 0,
                        'Payable to Client - GBP (** Converted to USD ** - Conversion Rate' . $GBPtoUSD . ')' => $payable_to_client_gbp1 ?? 0,
                    ]);
                }


                $values = array_merge($values, [
                    'NET CALCULATIONS' => 'VALUES',
                    'Payable to Client - TOTAL' => $payable_to_client_total ?? 0,
                    'Less : ' . Session::get('crypto_fee') . ' - Settlement Fee in Crypto' => $crypto_charge ?? 0,
                    'Amount we owe to Client - FINAL' => $amt_owe_to_client ?? 0,
                ]);


                foreach ($values as $key => $value) {
                    // Append a row as [key, value]
                    $cumulativeValues[] = [$key, $value];
                }

                $totalSuccessTrxAmt =
                    ($total_transactions['USD'] ?? 0) +
                    (($total_transactions['EUR'] ?? 0) * $EURtoUSD) +
                    (($total_transactions['JPY'] ?? 0) * $JPYtoUSD) +
                    (($total_transactions['AUD'] ?? 0) * $AUDtoUSD) +
                    (($total_transactions['AED'] ?? 0) * $AEDtoUSD) +
                    (($total_transactions['GBP'] ?? 0) * $GBPtoUSD);

                // Export data to Excel
                $fileName = "/exports/{$tableName}.xlsx";
                $fileHeading = strtoupper($tableName) . ' ' . "Clearing Report for the Period from " . $fromDate . ' to ' . $toDateFull;

                Excel::store(new MainExportClass(
                    $processedData,
                    $refunds,
                    $chargebacks,
                    $fraudWarnings,
                    $highRisks,
                    $partialRefunds,
                    $cumulativeValues,
                    $fileHeading
                ), $fileName, 'custom_public');

                $filePath = $fileName . '?v=' . time();

                WeeklyReports::updateOrCreate(
                    ['clientName' => $tableName],
                    ['clientName' => $tableName, 'startDate' => $fromDate, 'endDate' => $toDateFull, 'user_ID' => $merchant->clientDetails->client_id, 'payoutAmt' => $amt_owe_to_client, 'totalSuccessTrxAmt' => number_format($totalSuccessTrxAmt, 2), 'status' => null, 'filePath' => $filePath]
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e; // Re-throw the exception to ensure Laravel marks it as failed
        }
    }catch (Throwable $e) {
        Log::error('Queue job failed: ' . $e->getMessage());
        throw $e; // Rethrow to let Laravel handle retries
    }
    }

    public function failed(Throwable $exception)
    {
        Log::error('Queue Job Failed', [
            'job' => self::class,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
