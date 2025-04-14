<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExcelImportController;
use Illuminate\Support\Facades\Route;
use App\Export\ReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Artisan;
use Database\Seeders\PermissionSeeder;

// To Create Permissions 
// Route::get('/run-seeder', function () {
//     (new PermissionSeeder())->run();
//     return 'Seeder executed!';
// });

Route::get('/test-log', function () {
    Log::info('Logging test message!');
    return 'Check laravel.log';
});


Route::get('/account/form', [App\Http\Controllers\HomeController::class, 'account_form'])->name('account.form');

Route::get('/account/form1', [App\Http\Controllers\HomeController::class, 'account_form1'])->name('account.form1');

Route::post('/store/account/form', [App\Http\Controllers\HomeController::class, 'account_store'])->name('store.account');

Route::get('/ApiHealthCheckController', [\App\Http\Controllers\ApiHealthCheckController::class, 'index'])->name('apiHealthCheck');

Route::post('/Api/addNewApi', [\App\Http\Controllers\ApiHealthCheckController::class, 'addNewApi'])->name('addNewApi');


Route::get('/dataImport', function () {
    return view('dataImporter');
});

Route::post('/upload-excel', [ExcelImportController::class, 'upload'])->name('ExcelDataImporter');

// Route::get('/get-tables', function () {
//     $prefix = 'pay_orders_';

//     // Query the database to get table names with the specified prefix
//     $tables = DB::select("SHOW TABLES LIKE '{$prefix}%'");

//     $tableNames = array_map(function ($table) {
//         return reset($table); // Adjust the key based on your database configuration
//     }, $tables);
    
    
//   DB::statement("SET SESSION sql_mode = ''");
   
//   foreach ($tableNames as $tableName) {
//     try {
        
//         // DB::table($tableName)->where('orderPaid', '0000-00-00 00:00:00')->update(['orderPaid' => null]);
        
//         Schema::table($tableName, function (Blueprint $table) {
//             $table->datetime('orderPaid')->nullable()->default(null)->change();
//             $table->string('phone', 15)->nullable()->change(); // Modify as needed
//         });
//         Log::info("Successfully updated table: $tableName");
//     } catch (\Exception $e) {
//         Log::error("Failed to update table: $tableName. Error: " . $e->getMessage());
//     }
//     }

//     dd($tableNames); // Outputs all matching table names
// });

// RK

Route::get('/uploadDoc/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'uploadDoc'])->name('kycrequests.uploadDoc');

Route::get('/uploadPassport/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'uploadPassport'])->name('kycrequests.uploadPassport');

Route::post('/storePassport/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'storePassport'])->name('kycrequests.storePassport');

Route::get('/uploadContract/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'uploadContract'])->name('kycrequests.uploadContract');

Route::post('/storeDoc/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'storeDoc'])->name('kycrequests.storeDoc');

Route::post('/storeContract/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'storeContract'])->name('kycrequests.storeContract');

Route::get('/success', [\App\Http\Controllers\KYCRequestsController::class, 'success'])->name('kycrequests.success');

Route::get('/kycrequests/newKYCform/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newKYCform'])->name('kycrequests.newKYCform');

Route::get('/kycrequests/newKYCform1/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newKYCform1'])->name('kycrequests.newKYCform1');

Route::get('/kycrequests/newKYCform2/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newKYCform2'])->name('kycrequests.newKYCform2');

Route::get('/kycrequests/newKYCform3/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newKYCform3'])->name('kycrequests.newKYCform3');

Route::get('/kycrequests/newKYCform4/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newKYCform4'])->name('kycrequests.newKYCform4');

Route::post('/kycrequests/store1', [\App\Http\Controllers\KYCRequestsController::class, 'store1'])->name('kycrequests.store1');

Route::post('/kycrequests/store2', [\App\Http\Controllers\KYCRequestsController::class, 'store2'])->name('kycrequests.store2');

Route::post('/kycrequests/store3', [\App\Http\Controllers\KYCRequestsController::class, 'store3'])->name('kycrequests.store3');

Route::post('/kycrequests/store4', [\App\Http\Controllers\KYCRequestsController::class, 'store4'])->name('kycrequests.store4');

Route::get('/kycrequests/declaration/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'declaration'])->name('kycrequests.declaration');

Route::get('/kycrequests/newEDDform/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newEDDform'])->name('kycrequests.newEDDform');

Route::get('/kycrequests/newEDDform1/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newEDDform1'])->name('kycrequests.newEDDform1');

Route::get('/kycrequests/newEDDform2/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newEDDform2'])->name('kycrequests.newEDDform2');

Route::get('/kycrequests/newEDDform3/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newEDDform3'])->name('kycrequests.newEDDform3');

Route::get('/kycrequests/newEDDform4/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newEDDform4'])->name('kycrequests.newEDDform4');

Route::post('/kycrequests/eddStore', [\App\Http\Controllers\KYCRequestsController::class, 'eddStore'])->name('kycrequests.eddStore');

Route::post('/kycrequests/eddStore1', [\App\Http\Controllers\KYCRequestsController::class, 'eddStore1'])->name('kycrequests.eddStore1');

Route::post('/kycrequests/eddStore2', [\App\Http\Controllers\KYCRequestsController::class, 'eddStore2'])->name('kycrequests.eddStore2');

Route::post('/kycrequests/eddStore2File', [\App\Http\Controllers\KYCRequestsController::class, 'eddStore2File'])->name('kycrequests.eddStore2File');

Route::post('/kycrequests/eddStore3', [\App\Http\Controllers\KYCRequestsController::class, 'eddStore3'])->name('kycrequests.eddStore3');

Route::get('/kycrequests/declaration1/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'declaration1'])->name('kycrequests.declaration1');

Route::get('/kycrequests/viewEDD/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'viewEDD'])->name('kycrequests.viewEDD');

Route::get('/kycrequests/removeTeamMember/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'removeTeamMember'])->name('kycrequests.removeTeamMember');

Route::get('/kycrequests/removeDemographyCountry/{id}/{cid}', [\App\Http\Controllers\KYCRequestsController::class, 'removeDemographyCountry'])->name('kycrequests.removeDemographyCountry');

Route::post('/kycrequests/eddFormSubmission', [\App\Http\Controllers\KYCRequestsController::class, 'eddFormSubmission'])->name('kycrequests.eddFormSubmission');

Route::get('/kycrequests/approveResponse/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'approveResponse'])->name('kycrequests.approveResponse');

Route::get('/kycrequests/rejectResponse/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'rejectResponse'])->name('kycrequests.rejectResponse');

Route::get('/sendPrekycResponseLink/{id}', [App\Http\Controllers\MailConroller::class, 'sendPrekycResponseLink'])->name('sendPrekycResponseLink.mail');

Route::post('/kycrequests/preKycClarification/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'preKycClarification'])->name('kycrequesets.preKycClarification');

Route::post('/kycrequests/recordpreKycResponse', [\App\Http\Controllers\KYCRequestsController::class, 'recordpreKycResponse'])->name('kycrequests.recordpreKycResponse');

Route::get('/kycrequests/prekycResponseLink/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'prekycResponseLink'])->name('kycrequests.prekycResponseLink');

Route::get('/kycrequests/viewKYCLive/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'viewKYCLive'])->name('kycrequests.viewKYCLive');

Route::get('/kycrequests/viewEddLive/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'viewEddLive'])->name('kycrequests.viewEddLive');

Route::get('/kycrequests/eddResponse/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'eddResponse'])->name('kycrequests.eddResponse');

Route::post('/kycrequests/recordResponse', [\App\Http\Controllers\KYCRequestsController::class, 'recordResponse'])->name('kycrequests.recordResponse');


// RK


Route::group(['middleware' => 'web'], function () {

    Route::get('/', function () {

        if (Auth::check()) {

            $role = Role::where('name', 'Customer')->first();

            if (Auth::user()->role == $role->id) {

                return redirect('/customer/clients');
            } else {

                return view('index');
            }
        } else {
            return view("auth.login");
        }
    })->name('/');

    Route::post('/index', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

    Route::get('/index', [App\Http\Controllers\HomeController::class, 'Dashboard'])->name('index');
});

Route::group(['middleware' => ['auth']], function () {
    /**
     * Logout Route
     */
    Route::post('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/PYY/create', [App\Http\Controllers\HomeController::class, 'PYY_create'])->name('PYY.create');

    Route::get('download_excel', function () {
        return (new ReportExport)->download('report.xlsx');
    });

    Route::get('download_pdf', function () {
        return (new ReportExport)->download('report.pdf');
    });

    //Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

    //User start

    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');

    Route::get('user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');

    Route::post('user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');

    Route::get('user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');

    Route::post('user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

    Route::get('user/delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');

    Route::get('user/view/more/{id}', [App\Http\Controllers\UserController::class, 'User_Viewmore'])->name('user.view.more');

    Route::post('/SaveTaskWorkingHours', [App\Http\Controllers\UserController::class, 'Save_Task_Working_Hours'])->name('SaveTaskWorkingHours');

    // Payment Method

    Route::get('/payment/method', [App\Http\Controllers\PaymentMethodController::class, 'index'])->name('payment.method');

    Route::get('/payment/method/create', [App\Http\Controllers\PaymentMethodController::class, 'create'])->name('payment.method.create');

    Route::post('/payment/method/store', [App\Http\Controllers\PaymentMethodController::class, 'store'])->name('payment.method.store');

    Route::get('/payment/method/status/{status}/{id}', [App\Http\Controllers\PaymentMethodController::class, 'status'])->name('payment.method.status');

    Route::get('/payment/method/edit/{id}', [App\Http\Controllers\PaymentMethodController::class, 'edit'])->name('payment.method.edit');

    Route::post('/payment/method/update', [App\Http\Controllers\PaymentMethodController::class, 'update'])->name('payment.method.update');


    //Agent Add all Routes

    Route::get('/agent/users', [App\Http\Controllers\UserController::class, 'index_Agent'])->name('agentusers');

    Route::get('/agent/create', [App\Http\Controllers\UserController::class, 'create_Agent'])->name('agentcreate');

    Route::post('/agent/store', [App\Http\Controllers\UserController::class, 'store_Agent'])->name('agent.store');

    Route::get('/agent/edit/{id}', [App\Http\Controllers\UserController::class, 'edit_Agent'])->name('agent.edit');

    Route::post('/agent/update/{id}', [App\Http\Controllers\UserController::class, 'update_Agent'])->name('agent.update');

    Route::get('/agent/delete/{id}', [App\Http\Controllers\UserController::class, 'delete_Agent'])->name('agentdelete');

    Route::get('agent/view/more/{id}', [App\Http\Controllers\UserController::class, 'Agent_Viewmore'])->name('agent.view.more');


    Route::get('/onboardings', [App\Http\Controllers\OnboardingController::class, 'index'])->name('onboardings');

    Route::get('/change/onboarding/status/{id}', [App\Http\Controllers\OnboardingController::class, 'status'])->name('change.onboarding.status');

    // RK

    Route::get('/onboardings/edit/{id}', [\App\Http\Controllers\OnboardingController::class, 'edit'])->name('onboarding.edit');

    Route::post('/onboardings/update/{id}', [\App\Http\Controllers\OnboardingController::class, 'update'])->name('onboarding.update');

    Route::get('/onboarding/view/{id}', [\App\Http\Controllers\OnboardingController::class, 'view'])->name('onboarding.view');

    Route::get('/onboarding/deleteUBO/{id}', [\App\Http\Controllers\OnboardingController::class, 'deleteUbo'])->name('onboarding.deleteUbo');

    Route::get('/onboarding/deleteBoard/{id}', [\App\Http\Controllers\OnboardingController::class, 'deleteBoard'])->name('onboarding.deleteBoard');

    Route::get('/onboarding/deleteSignatory/{id}', [\App\Http\Controllers\OnboardingController::class, 'deleteSignatory'])->name('onboarding.deleteSignatory');

    // Mail 

    Route::get('/send/{id}', [App\Http\Controllers\MailConroller::class, 'sendRequestMail'])->name('send.mail');

    Route::post('/sendContract/{id}', [App\Http\Controllers\MailConroller::class, 'sendContractMail'])->name('sendContract.mail');

    Route::get('/sendNewKYC/{id}', [App\Http\Controllers\MailConroller::class, 'sendNewKYC'])->name('NewKYCMail.mail');

    Route::get('/sendEDDLink/{id}', [App\Http\Controllers\MailConroller::class, 'sendEDDLink'])->name('SendEDDMail.mail');

    Route::get('/sendEDDLink/{id}', [App\Http\Controllers\MailConroller::class, 'sendEDDLink'])->name('SendEDDMail.mail');

    Route::get('/sendEDDResponseLink/{id}', [App\Http\Controllers\MailConroller::class, 'sendEDDResponseLink'])->name('SendEDDResponseMail.mail');

    // KYC Requests

    Route::get('/kycrequests', [\App\Http\Controllers\KYCRequestsController::class, 'index'])->name('kycrequests');

    Route::get('/kycrequests/create', [\App\Http\Controllers\KYCRequestsController::class, 'create'])->name('kycrequests.create');

    Route::get('/kycrequests/view/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'view'])->name('kycrequests.view');

    Route::post('/newKYCrequest', [\App\Http\Controllers\KYCRequestsController::class, 'store'])->name('kycrequests.store');

    Route::get('/kycrequests/edit/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'edit'])->name('kycrequests.edit');

    Route::post('/kycrequests/update/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'update'])->name('kycrequests.update');

    Route::get('/kycrequests/closeWithLowRisk/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'closeWithLowRisk'])->name('kycrequests.closeWithLowRisk');

    Route::get('/kycrequests/closeWithHighRisk/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'closeWithHighRisk'])->name('kycrequests.closeWithHighRisk');

    Route::get('/kycrequests/approve/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'approve'])->name('kycrequests.approve');

    Route::get('/kycrequests/rejectClient/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'rejectClient'])->name('kycrequests.rejectClient');

    Route::get('/kycrequests/revertRejection/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'revertRejection'])->name('kycrequests.revertRejection');

    Route::get('/kycrequests/disapprove/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'disapprove'])->name('kycrequests.disapprove');

    Route::get('/kycrequests/newKYC/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'newKYC'])->name('kycrequests.newKYC');

    Route::get('/kycRequests/docApprove/{id}/{docName}/{docReasonName}', [\App\Http\Controllers\KYCRequestsController::class, 'docApprove'])->name('kycrequests.docApprove');

    Route::post('/kycRequests/docReject/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'docReject'])->name('kycrequests.docReject');

    Route::get('/kycRequests/intimateClient/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'intimateClient'])->name('kycrequests.intimateClient');

    Route::get('/kycrequests/passportApprove/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'passportApprove'])->name('kycrequests.passportApprove');

    Route::post('/kycrequests/passportReject/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'passportReject'])->name('kycrequests.passportReject');

    Route::get('/kycrequests/passportReask/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'passportReask'])->name('kycrequests.passportReask');

    Route::get('/kycrequests/worldCheckApprove/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'worldCheckApprove'])->name('kycrequests.worldCheckApprove');

    Route::get('/kycrequests/worldCheckDecline/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'worldCheckDecline'])->name('kycrequests.worldCheckDecline');

    Route::get('/kycrequests/sumsubApprove/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'sumsubApprove'])->name('kycrequests.sumsubApprove');

    Route::get('/kycrequests/sumsubDecline/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'sumsubDecline'])->name('kycrequests.sumsubDecline');

    Route::get('/kycrequests/preKYCapproval/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'preKYCapproval'])->name('kycrequests.preKYCapproval');

    Route::get('/kycrequests/riskFactorToggle/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'riskFactorToggle'])->name('kycrequests.riskFactorToggle');

    Route::get('/kycrequests/closeEdd/{id}', [\App\Http\Controllers\KYCRequestsController::class, 'closeEdd'])->name('kycrequests.closeEdd');

    Route::get('/kycrequests/sumSub', [\App\Http\Controllers\KYCRequestsController::class, 'sumSub'])->name('kycrequests.sumSub');

    Route::get('/sumsub/access-token', [SumsubController::class, 'getAccessToken']);



    // RK

    // All customers from Agent


    Route::get('/customer/index/{id}', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');

    Route::get('/create_customer_from_agent/{id}', [App\Http\Controllers\CustomerController::class, 'create'])->name('create_customer_from_agent');

    Route::post('/agent/customer/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('agent.customer.store');

    Route::get('/customer/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customer.edit');

    Route::post('/customer/update/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('customer.update');

    Route::get('/customer/delete/{id}', [App\Http\Controllers\CustomerController::class, 'delete'])->name('customerdelete');

    Route::get('customer/view/more/{id}', [App\Http\Controllers\CustomerController::class, 'Customer_Viewmore'])->name('customer.view.more');

    Route::get('export/client/transaction/{id?}', [App\Http\Controllers\CustomerController::class, 'export_client_transaction'])->name('export.client.transaction');

    Route::get('/agent/customer/transaction/calculation/{id}', [App\Http\Controllers\CustomerController::class, 'Agent_Customer_Transaction'])->name('agent.customer.transaction.calculation');

    Route::get('/agent/customer/refunded/{id}', [App\Http\Controllers\CustomerController::class, 'Agent_Customer_Refunded'])->name('agent.customer.refunded');

    Route::get('/agent/customer/chargeback/{id}', [App\Http\Controllers\CustomerController::class, 'Agent_Customer_Chargeback'])->name('agent.customer.chargeback');



    // Client Individual routes
    Route::get('/customer/clients', [App\Http\Controllers\CustomerController::class, 'Customer_Account'])->name('customer.clients');

    Route::get('/customer/transaction/{id}', [App\Http\Controllers\CustomerController::class, 'Customer_Transaction'])->name('customer.transaction');

    Route::get('/customer/refunded/{id}', [App\Http\Controllers\CustomerController::class, 'Customer_Refunded'])->name('customer.refunded');

    Route::get('/customer/chargeback/{id}', [App\Http\Controllers\CustomerController::class, 'Customer_Chargeback'])->name('customer.chargeback');





    // Admin Clients Route
    Route::get('/admin/allclients', [App\Http\Controllers\CustomerController::class, 'Admin_Client_Index'])->name('admin.allclients');

    Route::get('admin/client/create', [App\Http\Controllers\CustomerController::class, 'Admin_Client_Create'])->name('admin.client.create');

    Route::get('create/client/payment/{id}', [App\Http\Controllers\CustomerController::class, 'create_Client_Create'])->name('create.client.payment');

    Route::post('admin/client/store', [App\Http\Controllers\CustomerController::class, 'Admin_Client_Store'])->name('admin.client.store');

    Route::get('admin/client/edit/{id}', [App\Http\Controllers\CustomerController::class, 'Admin_Client_Edit'])->name('admin.client.edit');

    Route::post('admin/client/update/{id}', [App\Http\Controllers\CustomerController::class, 'Admin_Client_Update'])->name('admin.client.update');

    Route::get('admin/client/delete/{id}', [App\Http\Controllers\CustomerController::class, 'Admin_Client_Delete'])->name('admin.client.delete');

    Route::get('admin/client/view/more/{id}', [App\Http\Controllers\CustomerController::class, 'Admin_Client_ViewMore'])->name('admin.client.view.more');

    Route::get('/admin/client/transaction/calculation/{id}', [App\Http\Controllers\CustomerController::class, 'Admin_Customer_Transaction'])->name('admin.client.transaction.calculation');

    Route::get('/admin/client/refunded/{id}', [App\Http\Controllers\CustomerController::class, 'Admin_Customer_Refunded'])->name('admin.client.refunded');

    Route::get('/admin/client/chargeback/{id}', [App\Http\Controllers\CustomerController::class, 'Admin_Customer_Chargeback'])->name('admin.client.chargeback');


    Route::get('/admin/client/payment', [App\Http\Controllers\CustomerController::class, 'client_payment'])->name('admin.client.payment');
    Route::get('/client/payment/status/{status}/{id}', [App\Http\Controllers\CustomerController::class, 'client_payment_status']);
    Route::post('/admin/hide', [App\Http\Controllers\CustomerController::class, 'hide_cc']);
    Route::post('/admin/store_hide_cc', [App\Http\Controllers\CustomerController::class, 'store_hide_cc'])->name('store_hide_cc');




    // Agent Setting

    Route::get('/agent/setting', [App\Http\Controllers\UserController::class, 'Agent_Setting'])->name('agent.setting');

    Route::post('/updateCommissionSchedule', [App\Http\Controllers\UserController::class, 'Commission_Update'])->name('updateCommissionSchedule');

    Route::post('/updateCharges', [App\Http\Controllers\UserController::class, 'Charges_Update'])->name('Charges_Update');


    // Employee Routes


    Route::get('employee/users', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.users');

    Route::get('employee/create', [App\Http\Controllers\EmployeeController::class, 'create'])->name('employee.create');

    Route::post('employee/store', [App\Http\Controllers\EmployeeController::class, 'store'])->name('employee.store');

    Route::get('employee/edit/{id}', [App\Http\Controllers\EmployeeController::class, 'edit'])->name('employee.edit');

    Route::post('employee/update/{id}', [App\Http\Controllers\EmployeeController::class, 'update'])->name('employee.update');

    Route::get('employee/delete/{id}', [App\Http\Controllers\EmployeeController::class, 'delete'])->name('employee.delete');

    Route::get('employee/view/more/{id}', [App\Http\Controllers\EmployeeController::class, 'User_Viewmore'])->name('employee.view.more');


    // Route::post('/SaveTaskWorkingHours', [App\Http\Controllers\EmployeeController::class,'Save_Task_Working_Hours'])->name('SaveTaskWorkingHours');


    // Employee..etc All User  Attendance

    Route::get('/user/attendance/{id}', [App\Http\Controllers\EmployeeController::class, 'Attendance_index'])->name('user.attendance');



    //role Start

    Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles');

    Route::get('role/create', [App\Http\Controllers\RoleController::class, 'create'])->name('role.create');

    Route::post('role/store', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store');

    Route::get('role/edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit');

    Route::post('role/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('role.update');

    Route::get('role/delete/{id}', [App\Http\Controllers\RoleController::class, 'delete'])->name('role.delete');

    Route::get('role/permissions/{id}', [App\Http\Controllers\RoleController::class, 'role_permissions'])->name('role.permissions');

    Route::post('assign/permission', [App\Http\Controllers\RoleController::class, 'update_assign_permission'])->name('assign.permission');

    //Accountants Start

    Route::get('/accounts', [App\Http\Controllers\AccountantsController::class, 'index'])->name('accounts');

    Route::get('/view/more/{id}', [App\Http\Controllers\AccountantsController::class, 'Viewmore'])->name('view.more');


    Route::get('accounts/create', [App\Http\Controllers\AccountantsController::class, 'create'])->name('accounts.create');

    Route::post('accounts/store', [App\Http\Controllers\AccountantsController::class, 'store'])->name('accounts.store');

    //deposit Start

    Route::get('deposit', [App\Http\Controllers\DepositController::class, 'index'])->name('deposit');

    Route::get('/depositedit', [App\Http\Controllers\DepositController::class, 'edit'])->name('depositedit');

    //expense Start

    Route::get('/expense', [App\Http\Controllers\ExpenseController::class, 'index'])->name('expense');

    Route::get('/expenseedit', [App\Http\Controllers\ExpenseController::class, 'edit'])->name('expenseedit');

    //transfer Start

    Route::get('/transfer', [App\Http\Controllers\TransferController::class, 'index'])->name('transfer');

    Route::get('/transferedit', [App\Http\Controllers\TransferController::class, 'edit'])->name('transferedit');

    //bill Start

    Route::get('/bills', [App\Http\Controllers\BillsController::class, 'index'])->name('bills');

    Route::get('/billsedit', [App\Http\Controllers\BillsController::class, 'edit'])->name('billsedit');

    //Report Start

    Route::get('/reporting', [App\Http\Controllers\ReportingController::class, 'index'])->name('reporting');

    Route::get('/monitoring', [App\Http\Controllers\MonitoringController::class, 'index'])->name('monitoring');

    //Project Start

    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects');


    Route::get('/projects/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('projects.create');

    Route::post('projects/store', [App\Http\Controllers\ProjectController::class, 'project_store'])->name('projects.store');

    // Route::get('projects/edit/{id}', [App\Http\Controllers\ProjectController::class,'edit'])->name('projects.edit');

    Route::post('project/edit', [App\Http\Controllers\ProjectController::class, 'edit'])->name('edit.project');

    Route::post('statu/edit', [App\Http\Controllers\ProjectController::class, 'edit_status'])->name('edit.status');

    Route::post('projects/update', [App\Http\Controllers\ProjectController::class, 'update'])->name('project.update');

    Route::get('projects/task/done/{id}', [App\Http\Controllers\ProjectController::class, 'task_done'])->name('projects.task.done');

    Route::get('projects/task/undone/{id}', [App\Http\Controllers\ProjectController::class, 'task_undone'])->name('projects.task.undone');


    Route::delete('/projects/delete/{id}', [App\Http\Controllers\ProjectController::class, 'delete'])->name('projects.delete');

    Route::post('comment/post', [App\Http\Controllers\ProjectController::class, 'comment_store'])->name('comment.post');

    Route::post('comment/get', [App\Http\Controllers\ProjectController::class, 'comment_get'])->name('get.comment');

    // task section start

    Route::post('/projects/task/store/{id}', [App\Http\Controllers\ProjectController::class, 'task_store'])->name('projects.task.store');

    Route::get('projects/details/{id}', [App\Http\Controllers\ProjectController::class, 'task_list'])->name('projects.details');

    Route::post('projects/task/update/{id}', [App\Http\Controllers\ProjectController::class, 'task_update'])->name('projects.task.update');

    Route::get('projects/tasks/done/{id}', [App\Http\Controllers\ProjectController::class, 'tasks_done'])->name('projects.tasks.done');

    Route::get('projects/tasks/undone/{id}', [App\Http\Controllers\ProjectController::class, 'tasks_undone'])->name('projects.tasks.undone');


    Route::delete('projects/tasks/delete/{id}', [App\Http\Controllers\ProjectController::class, 'tasks_delete'])->name('projects.tasks.delete');


    Route::get('/team/show', [App\Http\Controllers\ProjectController::class, 'team'])->name('team.show');


    Route::get('/team/search', [App\Http\Controllers\ProjectController::class, 'team_search'])->name('team.search');

    Route::post('user/client/store', [App\Http\Controllers\ProjectController::class, 'store'])->name('user.client.store');


    Route::get('projects/add/comments/{id}', [App\Http\Controllers\ProjectController::class, 'add_comments'])->name('projects.add.comments');

    Route::post('documents/store', [App\Http\Controllers\ProjectController::class, 'document_store'])->name('documents.store');

    Route::post('get/docs', [App\Http\Controllers\ProjectController::class, 'Docs_get'])->name('get.docs');

    // doenload image

    Route::get('/download-image/{imageFileName}', [App\Http\Controllers\ProjectController::class, 'DownloadImage'])->name('image.download');

    Route::get('view/comment/{id}', [App\Http\Controllers\ProjectController::class, 'Viewmore'])->name('view.comment');


    Route::get('/times', [App\Http\Controllers\TimerController::class, 'index'])->name('times');

    Route::post('/start-timer', [App\Http\Controllers\TimerController::class, 'startTimer']);

    Route::post('/stop-timer', [App\Http\Controllers\TimerController::class, 'stopTimer']);

    // task Master

    Route::get('/tasks_master', [App\Http\Controllers\TaskController::class, 'index']);

    Route::post('/task_master_store', [App\Http\Controllers\TaskController::class, 'store'])->name('task_master_store');

    Route::post('/task_master_update', [App\Http\Controllers\TaskController::class, 'edit'])->name('task_master_update');

    Route::get('/taskMaster/delete/{id}', [App\Http\Controllers\TaskController::class, 'delete'])->name('taskMaster.delete');

    // payments route
    Route::get('/payments', [App\Http\Controllers\PaymentController::class, 'index'])->name('payments');

    Route::get('/createpayments', [App\Http\Controllers\PaymentController::class, 'create'])->name('createpayments');

    Route::post('/payments/store', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');

    Route::get('/payment/edit/{id}', [App\Http\Controllers\PaymentController::class, 'edit'])->name('payment.edit');

    Route::post('/payments/update/{id}', [App\Http\Controllers\PaymentController::class, 'update'])->name('payments.update');


    Route::get('/request/payment', [App\Http\Controllers\PaymentController::class, 'request_payment'])->name('request.payment');

    Route::post('/request/payment/post', [App\Http\Controllers\PaymentController::class, 'request_payment_post'])->name('request.payment.post');

    Route::post('/get/customer/payment', [App\Http\Controllers\PaymentController::class, 'get_customer_payment'])->name('get.customer.payment');

    Route::get('/requested/payment', [App\Http\Controllers\PaymentController::class, 'requested_payment'])->name('requested.payment');

    Route::get('/change/request/payment/status/{id}', [App\Http\Controllers\PaymentController::class, 'change_request_payment_status'])->name('change.request.payment.status');

    // Crypto

    Route::get('/crypto', [App\Http\Controllers\CryptoController::class, 'index'])->name('crypto');

    Route::get('/crypto/create', [App\Http\Controllers\CryptoController::class, 'create'])->name('crypto.create');

    Route::post('/crypto/store', [App\Http\Controllers\CryptoController::class, 'store'])->name('crypto.store');

    Route::get('/crypto/edit/{id}', [App\Http\Controllers\CryptoController::class, 'edit'])->name('crypto.edit');

    Route::post('/crypto/update', [App\Http\Controllers\CryptoController::class, 'update'])->name('crypto.update');

    Route::get('/crypto/status/{id}', [App\Http\Controllers\CryptoController::class, 'status'])->name('crypto.status');

    Route::get('/crypto/delete/{id}', [App\Http\Controllers\CryptoController::class, 'delete'])->name('crypto.delete');

    // Network

    Route::get('/network', [App\Http\Controllers\NetworkController::class, 'index'])->name('network');

    Route::get('/network/create', [App\Http\Controllers\NetworkController::class, 'create'])->name('network.create');

    Route::post('/network/store', [App\Http\Controllers\NetworkController::class, 'store'])->name('network.store');

    Route::get('/network/edit/{id}', [App\Http\Controllers\NetworkController::class, 'edit'])->name('network.edit');

    Route::post('/network/update', [App\Http\Controllers\NetworkController::class, 'update'])->name('network.update');

    Route::get('/network/status/{id}', [App\Http\Controllers\NetworkController::class, 'status'])->name('network.status');

    Route::get('/network/delete/{id}', [App\Http\Controllers\NetworkController::class, 'delete'])->name('network.delete');


    //Sales And Reporting

    Route::get('/adminstatssales', [App\Http\Controllers\ReportingController::class, 'Sales_index'])->name('adminstatssales');

    // Route::get('/new/adminstatsreports', [App\Http\Controllers\ReportingController::class, 'new_Report_Index'])->name('new.adminstatssales');
    Route::get('/new/adminstatsreports', [App\Http\Controllers\ReportingController::class, 'admin_client_tran'])->name('new.adminstatssales');

    // Route::post('/post/adminstatsreports', [App\Http\Controllers\ReportingController::class, 'new_Post_Report_Index'])->name('post.adminstatssales');

    Route::post('/post/adminstatsreports', [App\Http\Controllers\ReportingController::class, 'Post_Report_Index'])->name('post.adminstatssales');

    Route::post('/download/pdf/report', [App\Http\Controllers\ReportingController::class, 'Download_Report_Pdf'])->name('download.pdf.report');

    Route::get('/clients/data/pay_orders/{data}', [App\Http\Controllers\ReportingController::class, 'new_Sales_Report'])->name('clients.data.pay_orders');

    Route::match(['get', 'post'], 'post/clients/data/pay_orders/{data}', [App\Http\Controllers\ReportingController::class, 'post_Sales_Reports'])->name('post.clients.data.pay_orders');

    Route::get('/admin/adminstatssales', [App\Http\Controllers\ReportingController::class, 'admin_client_tran'])->name('admin.adminstatssales');

    Route::post('/post/client/adminstatsreports', [App\Http\Controllers\ReportingController::class, 'Post_admin_client_tran'])->name('post.client.adminstatssales');
    
    Route::get('/weeklyreports', [App\Http\Controllers\ReportingController::class, 'weeklyreports'])->name('weeklyreports');
    
    Route::get('/get_agent_details/{id}', [App\Http\Controllers\ReportingController::class, 'get_agent_details'])->name('agentDetails');

    Route::post('/updateAgentDetails', [App\Http\Controllers\ReportingController::class, 'updateAgentDetails'])->name('updateAgentDetails');

    Route::post('/deleteAgent', [App\Http\Controllers\ReportingController::class, 'deleteAgent'])->name('deleteAgent');

    Route::get('/get_psp_details/{id}', [App\Http\Controllers\ReportingController::class, 'get_psp_details'])->name('pspDetails');

    Route::post('/updatePSPDetails', [App\Http\Controllers\ReportingController::class, 'updatePSPDetails'])->name('updatePSPDetails');

    Route::post('/deletePSP', [App\Http\Controllers\ReportingController::class, 'deletePSP'])->name('deletePSP');


    // invoice

    Route::get('/invoice/generate/{data}/{id}', [App\Http\Controllers\ReportingController::class, 'InvoiceGenerate'])->name('invoice.generate');



    // Employee Attendance Routes
    Route::get('employee/attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('employee.attendance');

    Route::get('monthly/attendance', [App\Http\Controllers\AttendanceController::class, 'Monthly_Attendance_Index'])->name('monthly.attendance');

    Route::post('attendance/in/time', [App\Http\Controllers\AttendanceController::class, 'Attendance_In_Store'])->name('attendance.in.time');

    Route::post('attendance/out/time', [App\Http\Controllers\AttendanceController::class, 'Attendance_Out_Store'])->name('attendance.out.time');

    Route::get('/employee/attendance/details/{id}', [App\Http\Controllers\AttendanceController::class, 'Attendance_Details'])->name('employee.attendance.details');


    // employee Leaves Route
    Route::get('employee/leaves', [App\Http\Controllers\AttendanceController::class, 'Leave_Index'])->name('employee.leaves');

    Route::get('leave/application', [App\Http\Controllers\AttendanceController::class, 'Leave_Create'])->name('leave.application');

    Route::post('leave/store', [App\Http\Controllers\AttendanceController::class, 'Leave_Store'])->name('leave.store');


    // Leave Type Routes

    Route::get('leave_types/index/', [App\Http\Controllers\AttendanceController::class, 'Leave_Type_Index'])->name('leave_types.index');

    Route::get('leave_type/create/', [App\Http\Controllers\AttendanceController::class, 'Leave_Type_Create'])->name('leave_type.create');

    Route::post('leave_type/store/', [App\Http\Controllers\AttendanceController::class, 'Leave_Type_Store'])->name('leave_type.store');

    Route::get('leave_type/edit/{id}', [App\Http\Controllers\AttendanceController::class, 'Leave_Type_Edit'])->name('leave_type.edit');

    Route::post('leave_type/update/{id}', [App\Http\Controllers\AttendanceController::class, 'Leave_Type_Update'])->name('leave_type.update');


    Route::get('merchant/application', [App\Http\Controllers\MerchantApplicationController::class, 'index'])->name('merchant.application');

    Route::get('merchant/application/form', [App\Http\Controllers\MerchantApplicationController::class, 'form'])->name('merchant.application.form');

    Route::post('merchant/application/store', [App\Http\Controllers\MerchantApplicationController::class, 'store'])->name('merchant.application.store');

    Route::get('merchant/application/edit/{id}', [App\Http\Controllers\MerchantApplicationController::class, 'edit'])->name('merchant.application.edit');

    Route::get('merchant/application/detail/{id}', [App\Http\Controllers\MerchantApplicationController::class, 'detail'])->name('merchant.application.detail');
});
