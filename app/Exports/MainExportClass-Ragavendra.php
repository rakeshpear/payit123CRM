<?php

namespace App\Exports;

// use App\Models\PayOrder;

use App\Exports\AgentSettlementExport;
use App\Exports\UsdTransactionsExport;
use App\Exports\CumulativeValuesExport;
use App\Exports\EuroTransactionsExport;
use App\Exports\ChargebackTransactionsExport;
use App\Exports\PartialRefundsTransactionsExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MainExportClass implements WithMultipleSheets
{
    protected $ProcessingUsdData;
    protected $RefundsUsdData;
    protected $ChargebackUsdData;
    protected $PartialRefundsUsdData;
    protected $ProcessingEuroData;
    protected $RefundsEurData;
    protected $ChargebackEurData;
    protected $PartialRefundsEurData;
    protected $fileHeading;
    protected $cumulativeValues;
    protected $agentSettlementValues;

    public function __construct($ProcessingUsdData, $RefundsUsdData, $ChargebackUsdData, $PartialRefundsUsdData, $ProcessingEuroData, $RefundsEurData, $ChargebackEurData, $PartialRefundsEurData, $cumulativeValues, $agentSettlementValues, $fileHeading)
    {
        $this->ProcessingUsdData = $ProcessingUsdData;
        $this->RefundsUsdData = $RefundsUsdData;
        $this->ChargebackUsdData = $ChargebackUsdData;
        $this->PartialRefundsUsdData = $PartialRefundsUsdData;
        $this->ProcessingEuroData = $ProcessingEuroData;
        $this->RefundsEurData = $RefundsEurData;
        $this->ChargebackEurData = $ChargebackEurData;
        $this->PartialRefundsEurData = $PartialRefundsEurData;
        $this->cumulativeValues = $cumulativeValues;
        $this->agentSettlementValues = $agentSettlementValues;
        $this->fileHeading = $fileHeading;
    }


    public function sheets(): array
    {
        return [
            new UsdTransactionsExport($this->ProcessingUsdData, $this->fileHeading),    // Sheet for USD transactions
            new RefundTransactionsExport($this->RefundsUsdData, $this->fileHeading),    // Sheet for USD Refund transactions
            new ChargebackTransactionsExport($this->ChargebackUsdData, $this->fileHeading), // Sheet for USD Chargeback transactions
            new PartialRefundsTransactionsExport($this->PartialRefundsUsdData, $this->fileHeading), // Sheet for USD Partial Refund transactions
            new EuroTransactionsExport($this->ProcessingEuroData, $this->fileHeading),    // Sheet for EUR transactions
            new RefundTransactionsEurExport($this->RefundsEurData, $this->fileHeading),    // Sheet for EUR Refund transactions
            new ChargebackTransactionsEurExport($this->ChargebackEurData, $this->fileHeading), // Sheet for EUR Chargeback transactions
            new PartialRefundsTransactionsEurExport($this->PartialRefundsEurData, $this->fileHeading), // Sheet for EUR Partial Refund transactions
            new CumulativeValuesExport($this->cumulativeValues, $this->fileHeading), // Sheet for Cumulative Values
            // new AgentSettlementExport($this->agentSettlementValues, $this->fileHeading) // Sheet for Cumulative Values
        ];
    }
}
