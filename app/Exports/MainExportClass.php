<?php

namespace App\Exports;

use App\Exports\AED\AedTransactionsExport;
use App\Exports\AED\ChargebackTransactionsAedExport;
use App\Exports\AED\PartialRefundsTransactionsAedExport;
use App\Exports\AED\RefundTransactionsAedExport;

use App\Exports\AgentSettlementExport;
use App\Exports\AUD\AudTransactionsExport;
use App\Exports\AUD\ChargebackTransactionsAudExport;
use App\Exports\AUD\PartialRefundsTransactionsAudExport;


use App\Exports\AUD\RefundTransactionsAudExport;
use App\Exports\CumulativeValuesExport;
use App\Exports\EUR\ChargebackTransactionsEurExport;
use App\Exports\EUR\EuroTransactionsExport;

use App\Exports\EUR\PartialRefundsTransactionsEurExport;
use App\Exports\EUR\RefundTransactionsEurExport;
use App\Exports\GBP\ChargebackTransactionsGbpExport;
use App\Exports\GBP\GbpTransactionsExport;

use App\Exports\GBP\PartialRefundsTransactionsGbpExport;
use App\Exports\GBP\RefundTransactionsGbpExport;
use App\Exports\JPY\ChargebackTransactionsJpyExport;
use App\Exports\JPY\JpyTransactionsExport;

use App\Exports\JPY\PartialRefundsTransactionsJpyExport;
use App\Exports\JPY\RefundTransactionsJpyExport;
use App\Exports\USD\ChargebackTransactionsExport;
use App\Exports\USD\fraudWarningsTransactionsAedExport;

use App\Exports\AUD\fraudWarningsTransactionsAudExport;
use App\Exports\EUR\fraudWarningsTransactionsEurExport;
use App\Exports\USD\fraudWarningsTransactionsExport;
use App\Exports\GBP\fraudWarningsTransactionsGbpExport;
use App\Exports\JPY\fraudWarningsTransactionsJpyExport;
use App\Exports\AED\highRisksTransactionsAedExport;
use App\Exports\AUD\highRisksTransactionsAudExport;
use App\Exports\EUR\highRisksTransactionsEurExport;
use App\Exports\USD\highRisksTransactionsExport;
use App\Exports\GBP\highRisksTransactionsGbpExport;
use App\Exports\JPY\highRisksTransactionsJpyExport;
use App\Exports\USD\PartialRefundsTransactionsExport;
use App\Exports\USD\RefundTransactionsExport;
use App\Exports\USD\UsdTransactionsExport;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MainExportClass implements WithMultipleSheets
{
    protected $processedData;
    protected $refunds;
    protected $chargebacks;
    protected $fraudWarnings;
    protected $highRisks;
    protected $partialRefunds;
    protected $fileHeading;
    protected $cumulativeValues;
    protected $agentSettlementValues;

    public function __construct($processedData, $refunds, $chargebacks, $fraudWarnings, $highRisks, $partialRefunds, $cumulativeValues, $fileHeading)
    {

        $this->processedData = $processedData;
        $this->refunds = $refunds;
        $this->chargebacks = $chargebacks;
        $this->fraudWarnings = $fraudWarnings;
        $this->highRisks = $highRisks;
        $this->partialRefunds = $partialRefunds;
        $this->cumulativeValues = $cumulativeValues;
        $this->fileHeading = $fileHeading;
    }


    public function sheets(): array
    {

        $sheets = [];

        // dd(Session::get('usdFlag'), Session::get('eurFlag'));

        if (Session::get('usdFlag') == 1) {
            $sheets[] = new UsdTransactionsExport($this->processedData["USD"], $this->fileHeading);   // Sheet for USD transactions
            $sheets[] = new RefundTransactionsExport($this->refunds["USD"], $this->fileHeading);   // Sheet for USD Refund transactions
            $sheets[] = new ChargebackTransactionsExport($this->chargebacks["USD"], $this->fileHeading); // Sheet for USD Chargeback transactions
            $sheets[] = new highRisksTransactionsExport($this->highRisks["USD"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new fraudWarningsTransactionsExport($this->fraudWarnings["USD"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new PartialRefundsTransactionsExport($this->partialRefunds["USD"], $this->fileHeading); // Sheet for USD Partial Refund transactions
        }

        if (Session::get('eurFlag') == 1) {
            $sheets[] = new EuroTransactionsExport($this->processedData["EUR"], $this->fileHeading);   // Sheet for USD transactions
            $sheets[] = new RefundTransactionsEurExport($this->refunds["EUR"], $this->fileHeading);   // Sheet for USD Refund transactions
            $sheets[] = new ChargebackTransactionsEurExport($this->chargebacks["EUR"], $this->fileHeading); // Sheet for USD Chargeback transactions
            $sheets[] = new highRisksTransactionsEurExport($this->highRisks["EUR"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new fraudWarningsTransactionsEurExport($this->fraudWarnings["EUR"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new PartialRefundsTransactionsEurExport($this->partialRefunds["EUR"], $this->fileHeading); // Sheet for USD Partial Refund transactions
        }

        if (Session::get('jpyFlag') == 1) {
            $sheets[] = new JpyTransactionsExport($this->processedData["JPY"], $this->fileHeading);   // Sheet for USD transactions
            $sheets[] = new RefundTransactionsJpyExport($this->refunds["JPY"], $this->fileHeading);   // Sheet for USD Refund transactions
            $sheets[] = new ChargebackTransactionsJpyExport($this->chargebacks["JPY"], $this->fileHeading); // Sheet for USD Chargeback transactions
            $sheets[] = new highRisksTransactionsJpyExport($this->highRisks["JPY"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new fraudWarningsTransactionsJpyExport($this->fraudWarnings["JPY"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new PartialRefundsTransactionsJpyExport($this->partialRefunds["JPY"], $this->fileHeading); // Sheet for USD Partial Refund transactions
        }

        if (Session::get('audFlag') == 1) {
            $sheets[] = new AudTransactionsExport($this->processedData["AUD"], $this->fileHeading);   // Sheet for USD transactions
            $sheets[] = new RefundTransactionsAudExport($this->refunds["AUD"], $this->fileHeading);   // Sheet for USD Refund transactions
            $sheets[] = new ChargebackTransactionsAudExport($this->chargebacks["AUD"], $this->fileHeading); // Sheet for USD Chargeback transactions
            $sheets[] = new highRisksTransactionsAudExport($this->highRisks["AUD"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new fraudWarningsTransactionsAudExport($this->fraudWarnings["AUD"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new PartialRefundsTransactionsAudExport($this->partialRefunds["AUD"], $this->fileHeading); // Sheet for USD Partial Refund transactions
        }

        if (Session::get('aedFlag') == 1) {
            $sheets[] = new AedTransactionsExport($this->processedData["AED"], $this->fileHeading);   // Sheet for USD transactions
            $sheets[] = new RefundTransactionsAedExport($this->refunds["AED"], $this->fileHeading);   // Sheet for USD Refund transactions
            $sheets[] = new ChargebackTransactionsAedExport($this->chargebacks["AED"], $this->fileHeading); // Sheet for USD Chargeback transactions
            $sheets[] = new highRisksTransactionsAedExport($this->highRisks["AED"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new fraudWarningsTransactionsAedExport($this->fraudWarnings["AED"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new PartialRefundsTransactionsAedExport($this->partialRefunds["AED"], $this->fileHeading); // Sheet for USD Partial Refund transactions
        }

        if (Session::get('gbpFlag') == 1) {
            $sheets[] = new GbpTransactionsExport($this->processedData["GBP"], $this->fileHeading);   // Sheet for USD transactions
            $sheets[] = new RefundTransactionsGbpExport($this->refunds["GBP"], $this->fileHeading);   // Sheet for USD Refund transactions
            $sheets[] = new ChargebackTransactionsGbpExport($this->chargebacks["GBP"], $this->fileHeading); // Sheet for USD Chargeback transactions
            $sheets[] = new highRisksTransactionsGbpExport($this->highRisks["GBP"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new fraudWarningsTransactionsGbpExport($this->fraudWarnings["GBP"], $this->fileHeading); // Sheet for USD High Risks transactions
            $sheets[] = new PartialRefundsTransactionsGbpExport($this->partialRefunds["GBP"], $this->fileHeading); // Sheet for USD Partial Refund transactions
        }

        $sheets[] = new CumulativeValuesExport($this->cumulativeValues, $this->fileHeading); // Sheet for Cumulative Values
        // new AgentSettlementExport($this->agentSettlementValues, $this->fileHeading) // Sheet for Cumulative Values

        // dd($sheets);

        return $sheets;
    }
}
