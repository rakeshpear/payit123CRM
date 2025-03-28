<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

function processRefunds($refundsData, $currency)
{
    $refundsTotal = 0;
    $refundFeeTotal = 0;
    $refundFee = (int) preg_replace('/\D/', '', Session::get('refund_fee', 0));


    foreach ($refundsData as $entry) {
        if ($entry->currency == $currency) {
            $refundsTotal += ($entry->amount + $refundFee);
            $refundFeeTotal += $refundFee;
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
            'Refund Fee' => "$" . $refundFee,
            'Total Amount' => $item->amount + $refundFee,
            'Client Name' => $item->fullName,
            'Refunded?' => '',
            'Invoice Number' => $item->invoiceNumber,
            'Bank Name' => $item->bank_name,
        ]);
}

// Sub Function - Chargebacks Processing
function processChargebacks($chargebackData, $currency)
{
    $chargebacksTotal = 0;
    $chargebacksFeeTotal = 0;
    $chargebackFee = (int) preg_replace('/\D/', '', Session::get('chargeback_fee', 0));

    foreach ($chargebackData as $entry) {
        if ($entry->currency == $currency) {
            $chargebacksTotal += ($entry->amount + $chargebackFee);
            $chargebacksFeeTotal += $chargebackFee;
        }
    }

    Session::put("chargebacksTotal{$currency}", $chargebacksTotal);
    Session::put("chargebacks_fee_total_{$currency}", $chargebacksFeeTotal);

    return collect($chargebackData)
        ->values()
        ->map(fn($item, $index) => [
            'No' => $index + 1,
            'Dispute Date' => $item->orderDate,
            'PSP Code' => $item->transactionID,
            'Acquirer_Status' => '',
            'Amount' => $item->amount,
            'Chargeback Fee' => "$" . $chargebackFee,
            'Total Amount' => $item->amount + $chargebackFee,
            'Client Name' => $item->fullName,
            'Blocked?' => '',
            'Invoice Number' => $item->invoiceNumber,
            'Bank Name' => $item->bank_name,
        ]);
}

// Sub Function - High Risks
function highRisks($highRiskData, $currency)
{
    $highRisksTotal = 0;
    $highRisksFeeTotal = 0;
    $highRiskFee = (int) preg_replace('/\D/', '', Session::get('highRisk_fee', 0));

    foreach ($highRiskData as $entry) {
        if ($entry->currency == $currency) {
            $highRisksTotal += ($entry->amount + $highRiskFee);
            $highRisksFeeTotal += $highRiskFee;
        }
    }

    Session::put("highRisksTotal{$currency}", $highRisksTotal);
    Session::put("highRisks_fee_total_{$currency}", $highRisksFeeTotal);


    return collect($highRiskData)
        ->values()
        ->map(fn($item, $index) => [
            'No' => $index + 1,
            'Dispute Date' => $item->orderDate,
            'PSP Code' => $item->transactionID,
            'Acquirer_Status' => '',
            'Amount' => $item->amount,
            'HighRisk Fee' => "$" . $highRiskFee,
            'Total Amount' => $item->amount + $highRiskFee,
            'Client Name' => $item->fullName,
            'Blocked?' => '',
            'Invoice Number' => $item->invoiceNumber,
            'Bank Name' => $item->bank_name,
        ]);
}

// Sub Function - Fraud Warnings Processing
function fraudWarnings($fraudWarningsData, $currency)
{
    $fraudWarningsTotal = 0;
    $fraudWarningsFeeTotal = 0;
    $fraudWarningFee = (int) preg_replace('/\D/', '', Session::get('fraudWarning_fee', 0));

    foreach ($fraudWarningsData as $entry) {
        if ($entry->currency == $currency) {
            $fraudWarningsTotal += ($entry->amount + $fraudWarningFee);
            $fraudWarningsFeeTotal += 50;
        }
    }

    Session::put("fraudWarningsTotal{$currency}", $fraudWarningsTotal);
    Session::put("fraudWarnings_fee_total_{$currency}", $fraudWarningsFeeTotal);

    return collect($fraudWarningsData)
        ->values()
        ->map(fn($item, $index) => [
            'No' => $index + 1,
            'Dispute Date' => $item->orderDate,
            'PSP Code' => $item->transactionID,
            'Acquirer_Status' => '',
            'Amount' => $item->amount,
            'Fraud Warning Fee' => "$" . $fraudWarningFee,
            'Total Amount' => $item->amount + $fraudWarningFee,
            'Client Name' => $item->fullName,
            'Blocked?' => '',
            'Invoice Number' => $item->invoiceNumber,
            'Bank Name' => $item->bank_name,
        ]);
}


// Sub Function - Partial Refunds Processing
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
