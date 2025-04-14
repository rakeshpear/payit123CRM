<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class AddMissingColumns extends Controller
{
    public function index(Request $request)
    {

        // Function to add additional columns in all the Pay_Orders Tables.

        $tables = DB::select("SHOW TABLES LIKE 'pay_orders_%'");
        
        // dd($tables);

        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];

            // dd($tableName);

            // Skip tables ending with '_3ds' or '_3ds_validation'
            if (in_array(
                true,
                [
                    str_ends_with($tableName, '_3ds'),
                    str_ends_with($tableName, '_3ds_validation'),
                    str_ends_with($tableName, '_logs'),
                    str_ends_with($tableName, 'xm_refund'),
                    str_ends_with($tableName, 'xm_refund1'),
                    str_ends_with($tableName, '_demo'),
                    str_ends_with($tableName, '_apipayment'),
                    str_ends_with($tableName, '_blockedcards'),
                    str_ends_with($tableName, '_bloom'),
                    str_ends_with($tableName, '_bloomfinance'),
                    str_ends_with($tableName, '_clientd'),
                    str_ends_with($tableName, '_cliente'),
                    str_ends_with($tableName, '_gtse'),
                    str_ends_with($tableName, '_gtse_'),
                    str_ends_with($tableName, '_maxi'),
                    str_ends_with($tableName, '_mediamarket1'),
                    str_ends_with($tableName, '_'),
                    str_ends_with($tableName, '_payzone24'),
                    str_ends_with($tableName, '_skyce'),
                    str_ends_with($tableName, '_sml'),
                    str_ends_with($tableName, '_stavred'),
                    str_ends_with($tableName, '_stripe'),
                    str_ends_with($tableName, '_ultimate'),
                    str_ends_with($tableName, '_universal'),
                    str_ends_with($tableName, '_uuid'),
                    str_ends_with($tableName, '_webincv1'),
                    str_ends_with($tableName, '_wooplugin'),
                    str_ends_with($tableName, '_worldcapital1'),
                    
                ]
            )) {
                continue;
            }

            // if (!Schema::hasColumn($tableName, 'settlement_date')) {
            //     DB::statement("ALTER TABLE `$tableName` ADD COLUMN `settlement_date` DATE NULL");
            // }
            // if (!Schema::hasColumn($tableName, 'settlement_number')) {
            //     DB::statement("ALTER TABLE `$tableName` ADD COLUMN `settlement_number` VARCHAR(255) NULL");
            // }
            // if (!Schema::hasColumn($tableName, 'psp_updated')) {
            //     DB::statement("ALTER TABLE `$tableName` ADD COLUMN `psp_updated` DATETIME NULL");
            // }
            // if (!Schema::hasColumn($tableName, 'callback_receive')) {
            //     DB::statement("ALTER TABLE `$tableName` ADD COLUMN `callback_receive` INT(11) DEFAULT 0");
            // }
            // if (!Schema::hasColumn($tableName, 'mismatch')) {
            //     DB::statement("ALTER TABLE `$tableName` ADD COLUMN `mismatch` INT(1) NULL");
            // }
            
            if (!Schema::hasColumn($tableName, 'bincheck_country')) {
                DB::statement("ALTER TABLE `$tableName` ADD COLUMN `bincheck_country` VARCHAR(255) NULL AFTER `cardnum`");
            }
            Log::info("Updated table: $tableName");
        }

        Log::info('Columns added to all matching tables, excluding _3ds, _3ds_validation, _logs, xm_refund tables.');
    }
}
