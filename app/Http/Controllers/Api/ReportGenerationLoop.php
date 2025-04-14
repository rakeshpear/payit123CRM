<?php

namespace App\Http\Controllers\Api;


use App\Exports\MainExportClass;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WeeklyReports;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;

class ReportGenerationLoop extends Controller
{
    public function index(Request $request)
    {
        
        // Currency Conversion
        $symbol = 'JPY,AUD,AED,GBP,EUR,UAH';
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

        Session()->flush();

        $fromDate = $request->input('orderdatefrom');
        $toDate = $request->input('orderdateto');
        $toDateFull = Carbon::parse($toDate)->endOfDay();
        
        function processInput($input)
        {
            if (Str::startsWith($input, 'pay_orders_')) {
                return Str::after($input, 'pay_orders_');
            }

            return $input;
        }

        $singleReportGeneration = processInput($request->input('clientName'));

        $regenerationToken = $request->regenrationToken;

        // dd($singleReportGeneration, $regenerationToken);

        $merchant = User::where('role', 10)->where('name', $singleReportGeneration)->get()->first();

        WeeklyReports::where('clientName', 'pay_orders_' . $singleReportGeneration)->update(['status' => null]);

        $clientMDRValue = $merchant->clientDetails->psp;
        Session::put('clientMDRValue', $clientMDRValue);

        $clientTrxValue = $merchant->clientDetails->transaction_fee;
        $clientRollingReserve = $merchant->clientDetails->rolling_reserve;
        $clientpayIT123Share = $merchant->clientDetails->payit123share;
        $clientName = $merchant->name;
        $crypto_fee = $merchant->clientDetails->crypto_fee;

        Session::put('clientTrxValue', $clientTrxValue);
        Session::put('clientRollingReserve', $clientRollingReserve);
        Session::put('clientpayIT123Share', $clientpayIT123Share);
        Session::put('crypto_fee', $crypto_fee);

        $tableName = "pay_orders_" . $clientName;

        if ($tableName !== 'pay_orders_xm_refund') {

            // Sub Function - Process Refunds
            function processRefunds($refundsData, $currency)
            {

                $refundsTotal = 0;
                $refundFeeTotal = 0;

                foreach ($refundsData as $entry) {
                    if ($entry->currency == $currency) {
                        $refundsTotal += ($entry->amount + 25);
                        $refundFeeTotal += 25;
                    }
                }

                Session::put("refundsTotal{$currency}", $refundsTotal);
                Session::put("refunds_fee_total_{$currency}", $refundFeeTotal);

                return collect($refundsData)
                    ->values()
                    ->map(fn($item, $index) => [
                        'No' => $index + 1,
                        'Dispute Date' => $item->orderDate,
                        'PSP Code' => $item->transactionID,
                        'Acquirer_Status' => '',
                        'Amount' => $item->amount,
                        'Refund Fee' => "$25.00",
                        'Total Amount' => $item->amount + 25,
                        'Client Name' => $item->fullName,
                        'Refunded?' => '',
                        'Invoice Number' => $item->invoiceNumber,
                        'Bank Name' => $item->bank_name,
                    ]);
            }

            // Sub Function - Chargebacks Processing
            function processChargebacks($data1, $currency)
            {
                $chargebacksTotal = 0;
                $chargebacksFeeTotal = 0;

                foreach ($data1 as $entry) {
                    if ($entry->currency == $currency) {
                        $chargebacksTotal += ($entry->amount + 50);
                        $chargebacksFeeTotal += 50;
                    }
                }

                Session::put("chargebacksTotal{$currency}", $chargebacksTotal);
                Session::put("chargebacks_fee_total_{$currency}", $chargebacksFeeTotal);

                return collect($data1)
                    ->values()
                    ->map(fn($item, $index) => [
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
                    ]);
            }

            // Sub Function - Partial Refunds
            function processPartialRefunds($data2, $currency)
            {
                $partialRefundsTotal = 0;
                $partialRefundsFeeTotal = 0;

                foreach ($data2 as $entry) {
                    $partialRefundsTotal += ($entry->refund_amount + 25);
                    $partialRefundsFeeTotal += 25;
                }

                Session::put("partialRefundsTotal{$currency}", $partialRefundsTotal);
                Session::put("partialRefunds_fee_total_{$currency}", $partialRefundsFeeTotal);

                return collect($data2)
                    ->values()
                    ->map(fn($item, $index) => [
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
                    ]);
            }

            // Sub Function - High Risks
            function highRisks($data3, $currency)
            {
                $highRisksTotal = 0;
                $highRisksFeeTotal = 0;

                foreach ($data3 as $entry) {
                    if ($entry->currency == $currency) {
                        $highRisksTotal += ($entry->amount + 50);
                        $highRisksFeeTotal += 50;
                    }
                }

                Session::put("highRisksTotal{$currency}", $highRisksTotal);
                Session::put("highRisks_fee_total_{$currency}", $highRisksFeeTotal);


                return collect($data3)
                    ->values()
                    ->map(fn($item, $index) => [
                        'No' => $index + 1,
                        'Dispute Date' => $item->orderDate,
                        'PSP Code' => $item->transactionID,
                        'Acquirer_Status' => '',
                        'Amount' => $item->amount,
                        'HighRisk Fee' => 50,
                        'Total Amount' => $item->amount + 50,
                        'Client Name' => $item->fullName,
                        'Blocked?' => '',
                        'Invoice Number' => $item->invoiceNumber,
                        'Bank Name' => $item->bank_name,
                    ]);
            }

            // Sub Function - Chargebacks Processing
            function fraudWarnings($data4, $currency)
            {
                $fraudWarningsTotal = 0;
                $fraudWarningsFeeTotal = 0;

                foreach ($data4 as $entry) {
                    if ($entry->currency == $currency && $entry->orderStatus == 2008) {
                        $fraudWarningsTotal += ($entry->amount + 50);
                        $fraudWarningsFeeTotal += 50;
                    }
                }

                Session::put("fraudWarningsTotal{$currency}", $fraudWarningsTotal);
                Session::put("fraudWarnings_fee_total_{$currency}", $fraudWarningsFeeTotal);

                return collect($data4)
                    ->values()
                    ->map(fn($item, $index) => [
                        'No' => $index + 1,
                        'Dispute Date' => $item->orderDate,
                        'PSP Code' => $item->transactionID,
                        'Acquirer_Status' => '',
                        'Amount' => $item->amount,
                        'Fraud Warning Fee' => 50,
                        'Total Amount' => $item->amount + 50,
                        'Client Name' => $item->fullName,
                        'Blocked?' => '',
                        'Invoice Number' => $item->invoiceNumber,
                        'Bank Name' => $item->bank_name,
                    ]);
            }

            // To Calculate USD Transactions
            $data = DB::table($tableName)
                ->select('transactionID', 'fullName', 'orderDate', 'amount', 'currency', 'orderStatus', 'invoiceNumber', 'bank_name')
                ->whereBetween('orderDate', [$fromDate, $toDateFull])
                ->whereIn('orderStatus', [200, 2001, 2005, 2007, 2008, 2025]) //2005 & 2009 needs to be included
                ->orderBy('orderDate', 'desc')
                ->get()
                ->toArray();

            // // // Skip if no data
            if (empty($data)) {
                WeeklyReports::where('clientName', $tableName)->update(['filePath' => null, 'startDate' => $fromDate, 'endDate' => $toDate]);
                return;
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
            $chargebacks = [];
            $partialRefunds = [];

            foreach ($currencies as $currency) {

                if ($flags[$currency . 'Flag'] === 1) {


                    // Initialize totals for the current currency
                    $payable_to_client[$currency] = 0;
                    $total_transactions[$currency] = 0;

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
                        } elseif ($item->orderStatus == 2006) {
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
                            'Fee (MDR - ' . Session::get('clientMDRValue') . '% + Trx Fee - ' . Session::get('clientTrxValue') . 'USD)' => '',
                            'Before RR + TRX Fee' => '',
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

                    $rcfhData = DB::table($tableName)
                        ->whereBetween('chargeback_date', [$fromDate, $toDateFull])
                        ->whereIn('orderStatus', [2001, 2006, 2007, 2008, 2009]) // Includes Chargebacks (2007, 2008) and Fraud Warning (2006)
                        ->where('included_in_report', 0)
                        ->get()
                        ->groupBy('orderStatus');

                    // Process Chargebacks
                    $chargebacks[$currency] = processChargebacks(
                        collect($rcfhData->only([2007, 2008]))->collapse()->toArray(),
                        $currency
                    );


                    //Processing Refunds
                    $refunds[$currency] = processRefunds(
                        collect($rcfhData->get(2001))->collapse()->toArray(),
                        $currency
                    );

                    // Process Fraud Warnings
                    $fraudWarnings[$currency] = fraudWarnings(
                        collect($rcfhData->get(2006))->toArray(),
                        $currency
                    );

                    // Process High Risk Transactions
                    $highRisks[$currency] = highRisks(
                        collect($rcfhData->get(2009))->toArray(),
                        $currency
                    );


                    // Processing Partial Refunds USD
                    $data2 = DB::table('pay_orders_xm_refund')
                        ->whereBetween('refund_complete_date', [$fromDate, $toDateFull])
                        ->where('client', $clientName)
                        ->where('status', 1)
                        ->where('included_in_report', 1)
                        ->get()
                        ->toArray();

                    $partialRefunds[$currency] = processPartialRefunds($data2, $currency);
                }
            }


            // USD
                    $chargebacks_USD = Session::get('chargebacksTotalUSD') ?? 0;
                    $refunds_USD = Session::get('refundsTotalUSD') ?? 0;
                    $fraudWarnings_USD = Session::get('fraudWarningsTotalUSD') ?? 0;
                    $highRisks_USD = Session::get('highRisksTotalUSD') ?? 0;
                    $partialRefunds_USD = Session::get('partialRefundsTotalUSD') ?? 0;
                    $payable_to_client_usd1 = ($payable_to_client['USD'] ?? 0) - ($chargebacks_USD + $fraudWarnings_USD + $highRisks_USD + $refunds_USD + $partialRefunds_USD);

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
                    'Less : Chargebacks USD' => $chargebacksUSD ?? 0,
                    'Less : Refunds USD' => $refundsUSD ?? 0,
                    'Less : Fraud Warning USD' => $fraudWarningsUSD ?? 0,
                    'Less : High Risks USD' => $highRisksUSD ?? 0,
                    'Less : Partial Refunds USD' => $partialRefundsUSD ?? 0,
                    'Payable to Client - USD' => $payable_to_client_usd1 ?? 0,
                ]);
            }

            if (Session::get('eurFlag') == 1) {
                $values = array_merge($values, [
                    'EURO CALCULATIONS' => 'VALUES Converted to USD (Rate : ' . $EURtoUSD . ' )',
                    'Processing EURO' => $payable_to_client['EUR'] ?? 0,
                    'Less : Chargebacks EUR' => $chargebacksEUR ?? 0,
                    'Less : Refunds EUR' => $refundsEUR ?? 0,
                    'Less : Fraud Warning EUR' => $fraudWarningsEUR ?? 0,
                    'Less : High Risks EUR' => $highRisksEUR ?? 0,
                    'Less : Partial Refunds EUR' => $partialRefundsEUR ?? 0,
                    'Payable to Client - EUR' => $payable_to_client_eur1 ?? 0,
                ]);
            }

            if (Session::get('jpyFlag') == 1) {
                $values = array_merge($values, [
                    'JPY CALCULATIONS' => 'VALUES Converted to USD (Rate :' . $JPYtoUSD . ')',
                    'Processing JPY' => $payable_to_client['JPY'] ?? 0,
                    'Less : Chargebacks JPY' => $chargebacksJPY ?? 0,
                    'Less : Refunds JPY' => $refundsJPY ?? 0,
                    'Less : Fraud Warning JPY' => $fraudWarningsJPY ?? 0,
                    'Less : High Risks JPY' => $highRisksJPY ?? 0,
                    'Less : Partial Refunds JPY' => $partialRefundsJPY ?? 0,
                    'Payable to Client - JPY' => $payable_to_client_jpy1 ?? 0,
                ]);
            }

            if (Session::get('audFlag') == 1) {
                $values = array_merge($values, [
                    'AUD CALCULATIONS' => 'VALUES Converted to USD (Rate :' . $AUDtoUSD . ')',
                    'Processing AUD' => $payable_to_client['AUD'] ?? 0,
                    'Less : Chargebacks AUD' => $chargebacksAUD ?? 0,
                    'Less : Refunds AUD' => $refundsAUD ?? 0,
                    'Less : Fraud Warning AUD' => $fraudWarningsAUD ?? 0,
                    'Less : High Risks AUD' => $highRisksAUD ?? 0,
                    'Less : Partial Refunds AUD' => $partialRefundsAUD ?? 0,
                    'Payable to Client - AUD' => $payable_to_client_aud1 ?? 0,
                ]);
            }

            if (Session::get('aedFlag') == 1) {
                $values = array_merge($values, [
                    'AED CALCULATIONS' => 'VALUES Converted to USD (Rate :' . $AEDtoUSD . ')',
                    'Processing AED' => $payable_to_client['AED'] ?? 0,
                    'Less : Chargebacks AED' => $chargebacksAED ?? 0,
                    'Less : Refunds AED' => $refundsAED ?? 0,
                    'Less : Fraud Warning AED' => $fraudWarningsAED ?? 0,
                    'Less : High Risks AED' => $highRisksAED ?? 0,
                    'Less : Partial Refunds AED' => $partialRefundsAED ?? 0,
                    'Payable to Client - AED' => $payable_to_client_aed1 ?? 0,
                ]);
            }

            if (Session::get('gbpFlag') == 1) {
                $values = array_merge($values, [
                    'GBP CALCULATIONS' => 'VALUES Converted to USD (Rate :' . $GBPtoUSD . ')',
                    'Processing GBP' => $payable_to_client['GBP'] ?? 0,
                    'Less : Chargebacks GBP' => $chargebacksGBP ?? 0,
                    'Less : Refunds GBP' => $refundsGBP ?? 0,
                    'Less : Fraud Warning GBP' => $fraudWarningsGBP ?? 0,
                    'Less : High Risks GBP' => $highRisksGBP ?? 0,
                    'Less : Partial Refunds GBP' => $partialRefundsGBP ?? 0,
                    'Payable to Client - GBP' => $payable_to_client_gbp1 ?? 0,
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

            // dd($processedData["USD"]->toArray());

            // Export data to Excel
            $fileName = "/exports/{$tableName}.xlsx";
            $fileHeading = strtoupper($tableName) . ' ' . "Clearing Report for the Period from " . $fromDate . ' to ' . $toDateFull;

            if ($singleReportGeneration !== null && $regenerationToken == '') {

                $newFileName = $singleReportGeneration . '_' . $fromDate . '_' . $toDateFull  . '.xlsx';
                return Excel::download(new MainExportClass(
                    $processedData,
                    $refunds,
                    $chargebacks,
                    $fraudWarnings,
                    $highRisks,
                    $partialRefunds,
                    $cumulativeValues,
                    $fileHeading
                ), $newFileName);
            } elseif ($singleReportGeneration !== null && $regenerationToken == "Regeneration") {

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
                        ['clientName' => $tableName, 'startDate' => $fromDate, 'endDate' => $toDateFull, 'user_ID' => $merchant->clientDetails->client_id, 'payoutAmt' => $amt_owe_to_client, 'filePath' => $filePath]
                );
            }
        }
        return redirect()->back();
    }
}
