<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;


class DataController extends Controller
{
    public function index(Request $request)
    {
        

        if (Schema::hasTable(strtolower($request->clients))) {

            Log::info('Incoming request data:', $request->all());
            
            $clientName = strtolower($request->input('clients'));
            $invoiceNumber = $request->input('invoiceNumber');
            
            Log::info("Incoming request client:", ['clients' => $clientName, 'Invoice Number' => $invoiceNumber]);

            $query = $request->input('query');
            
            $queryType = substr($query, 0, 6);
            Log::info("First 6 characters of query:", ['query_snippet' => $queryType]);

            if (!is_string($query)) {
                return response()->json(['error' => 'Invalid query format. Query must be a string.'], 400);
            }
            
            if($queryType == "update"){
                
                $exists = DB::table($clientName)->where('invoiceNumber', $invoiceNumber)->exists();
                    
                Log::info("Checking invoice existence:", [
                    'table' => $clientName,
                    'invoiceNumber' => $invoiceNumber,
                    'exists' => $exists ? 'Yes' : 'No'
                ]);
                
                if($exists){
                    DB::beginTransaction();
                    // Execute the query
                    try {
                        DB::statement($query);
                        DB::commit();
                        Log::info("Query Executed Successfully");
                        return response()->json(['success' => 'Query executed successfully.']);
                    } catch (\Exception $e) {
                        
                        DB::rollBack();
                        Log::error("Query Failed: " . $query . " | Error: " . $e->getMessage());
                        
                        // $newTableName = 'leftout_trx';
                        // DB::table($newTableName)->insert([
                        // 'invoiceNumber' => $invoiceNumber,
                        // 'tableName' => $clientName,
                        // ]);
                
                        // Log::info("New record inserted:", [
                        //     'table' => $clientName,
                        //     'invoiceNumber' => $invoiceNumber,
                        //     'clientName' => $clientName
                        // ]);
    
                        // return response()->json(['success' => 'New record inserted successfully.']);
                        
                        return response()->json(['error' => $e->getMessage()], 500);
                    }
                }
                else{
                    
                    $newTableName = 'leftout_trx';
                    
                    $leftOutExists = DB::table($newTableName)->where('invoiceNumber', $invoiceNumber)->exists();
                    
                    if(!$leftOutExists){
                        
                        DB::table($newTableName)->insert([
                        'invoiceNumber' => $invoiceNumber,
                        'tableName' => $clientName,
                        ]);
                
                        Log::info("New record inserted:", [
                            'table' => $clientName,
                            'invoiceNumber' => $invoiceNumber,
                            'clientName' => $clientName
                        ]);
                        Mail::raw('Transactions Gets Missing !', fn($message) => $message->to(['thamarayan@gmail.com', 'ta5711299@gmail.com'])->subject('ALERT - TRANSACTIONS MISSING'));
                        return response()->json(['success' => 'New record inserted successfully.']);
                        
                    }
                    
                    
                }
        
            }
            else{
                DB::beginTransaction();
                    // Execute the query
                    try {
                        DB::statement($query);
                        DB::commit();
                        Log::info("Query Inserted Successfully");
                        return response()->json(['success' => 'Query Inserted successfully.']);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error("Query Failed: " . $query . " | Error: " . $e->getMessage());
                        return response()->json(['error' => $e->getMessage()], 500);
                    }
            }
            
            
        }
        
        else {

            Schema::create($request->clients, function ($table) {
                $table->id('orderId');
                $table->string('fullName', 255)->nullable();
                $table->string('email', 255)->nullable();
                $table->string('phone', 10)->nullable();
                $table->float('amount', 10, 2)->nullable();
                $table->string('currency', 3)->nullable();
                $table->string('country', 255)->nullable();
                $table->string('street1', 255)->nullable();
                $table->string('city', 255)->nullable();
                $table->string('state', 255)->nullable();
                $table->string('postal_code', 255)->nullable();
                $table->string('invoiceNumber', 100)->nullable();
                $table->text('comments')->nullable();
                $table->integer('orderStatus')->length(5)->nullable()->default(1000);
                $table->text('orderMessage')->nullable();
                $table->string('transactionID', 255)->nullable();
                $table->dateTime('orderDate')->nullable();
                $table->dateTime('orderPaid')->nullable();
                $table->string('paymentMethod', 255)->nullable();
                $table->text('report')->nullable();
                $table->decimal('interchange', 6, 2)->nullable();
                $table->decimal('fee_scheme_fee', 6, 2)->nullable();
                $table->decimal('service_fee', 6, 2)->nullable();
                $table->string('card_type', 255)->nullable();
                $table->string('bank_name', 255)->nullable();
                $table->string('descriptor', 255)->nullable();
                $table->string('mid', 255)->nullable();
                $table->string('merchantName', 255)->nullable();
                $table->dateTime('chargeback_date')->nullable();
                $table->dateTime('decline_date')->nullable();
                $table->string('cardnum', 255)->nullable();
                $table->integer('included_in_report')->length(1)->default(0);
                $table->integer('meps_profile_id')->length(11)->default(0);
                $table->text('chargeback_callbackurl')->nullable();
                $table->text('fraud_callbackurl')->nullable();
                $table->text('refund_callbackurl')->nullable();
                $table->text('status_url')->nullable();
                $table->text('redirect_url')->nullable();
                $table->text('chargeback_callback')->nullable();
                $table->text('fraud_callback')->nullable();
                $table->text('refund_callback')->nullable();
                $table->integer('banks_mid')->length(11)->nullable();
                $table->text('return_url')->nullable();
                $table->integer('mode')->length(11)->default(0);
                $table->float('refund_amount', 10, 2)->nullable();
                $table->dateTime('psp_time')->nullable();
                $table->string('ARN_Number', 255)->nullable();
                $table->char('api_test', 1)->nullable();
                $table->float('partial_amount', 10, 2)->nullable();
                $table->integer('paid_by_psp')->length(1)->default(0);
                $table->string('xref', 255)->nullable();
                $table->string('refund_id', 255)->nullable();
                $table->float('partial_refund', 10, 2)->nullable();
                $table->integer('callback_send')->length(11)->nullable();
                $table->integer('success_reported')->length(1)->nullable();
                $table->char('3ds-started', 1)->default("N");
                $table->string('bank_status', 255)->nullable();
                $table->string('ip_address', 50)->nullable();
                $table->string('status_history', 255)->nullable();
                $table->string('auth_code', 255)->nullable();
                $table->string('akur_status', 255)->nullable();
                $table->string('gatewayID', 255)->nullable();
                $table->string('extra_gatewayID', 255)->nullable();
                $table->string('chargeID', 255)->nullable();
                $table->dateTime('akuratecoDate')->nullable();
                $table->dateTime('StripeDate')->nullable();
                $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });

            $query = $request->input('query');

            if (!is_string($query)) {
                return response()->json(['error' => 'Invalid query format. Query must be a string.'], 400);
            }

            // Execute the query
            try {
                DB::statement($query);
                return response()->json(['success' => 'Query executed successfully.']);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
}
