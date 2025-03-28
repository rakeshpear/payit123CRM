<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Models\Countrie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Exists;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportController extends Controller
{
    public function upload(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

           

        $import = new ExcelImport();
        Excel::import($import, $request->file('file'));

        $dataArray = $import->data;

        array_shift($dataArray);

        // dd($dataArray);

        $tableName = "pay_orders_" . strtolower($dataArray[0][22]);

        // dd($tableName);

        foreach ($dataArray as $data) {

            $invoiceNumber = $data[21];
            $exists = DB::table($tableName)->where('invoiceNumber', $invoiceNumber)->exists();

            if (!$exists) {

                try {

                    $newEntry = [
                        'orderDate' => Date::excelToDateTimeObject($data[0])->format('Y-m-d H:i:s'),
                        'orderStatus' => $data[1],
                        'decline_date' => $data[2],
                        'chargeback_date' => $data[3],
                        'included_in_report' => $data[4] === "Yes" ? 1 : 0,
                        'success_reported' => $data[5] === "Yes" ? 1 : 0,
                        'paid_by_psp' => $data[6] === "Yes" ? 1 : 0,
                        'settlement_date' => $data[7],
                        'settlement_number' => $data[8],
                        'merchantName' => $data[9],
                        'fullName' => $data[10],
                        'email' => $data[11],
                        'country' => $data[12],
                        'phone' => $data[13],
                        'cardnum' => $data[14],
                        'bank_name' => $data[15],
                        'descriptor' => $data[16],
                        'card_type' => $data[18],
                        'currency' => $data[19],
                        'amount' => str_replace('$', '', $data[20]),
                        'invoiceNumber' => $data[21],
                        'refund_id' => $data[23] === "N/A" ? null : $data[23],
                        'orderMessage' => $data[25],
                        'transactionID' => $data[26],
                        'gatewayID' => $data[27],
                        'extra_gatewayID' => $data[28],
                        'chargeID' => $data[29],
                        'orderPaid' => Date::excelToDateTimeObject($data[30])->format('Y-m-d H:i:s'),
                        'psp_time' => Date::excelToDateTimeObject($data[31])->format('Y-m-d H:i:s'),
                        // 'auth_code' => $data[32]
                    ];

                    $newEntry['country'] = Countrie::where('full_name', $data[12])->value('code');

                    $orderStatusValue = $data[1];

                    switch ($orderStatusValue) {
                        case "Success":
                            $newEntry['orderStatus'] = 200;
                            break;

                        case "Failed":
                            $newEntry['orderStatus'] = 400;
                            break;

                        case "Refunded":
                            $newEntry['orderStatus'] = 2001;
                            break;

                        case "Fraud":
                            $newEntry['orderStatus'] = 2005;
                            break;

                        case "Fraud Warning":
                            $newEntry['orderStatus'] = 2006;
                            break;

                        case "Ethoca Chargeback":
                            $newEntry['orderStatus'] = 2007;
                            break;

                        case "Chargeback":
                            $newEntry['orderStatus'] = 2008;
                            break;

                        case "Very High Risk Transaction":
                            $newEntry['orderStatus'] = 2009;
                            break;

                        case "Merchant Request":
                            $newEntry['orderStatus'] = 2025;
                            break;

                        default:
                            $newEntry['orderStatus'] = 0;
                    }

                    // dd($newEntry);

                    DB::table($tableName)->insert($newEntry);

                } catch (\Exception $e) {

                    Log::error("Error inserting data into $tableName: " . $e->getMessage());

                    dd("Error inserting data: " . $e->getMessage());
                }
            } else {
                Log::info("Invoice Number: `{$data[21]}` already exists. Execution aborted.");
            }
            
            
        }
        
        dd("Data inserted into table: " . $tableName);
    }
}
