<?php

use App\Http\Controllers\Api\CacheController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReportGenerationLoop;
use App\Http\Controllers\Api\ReportGeneratorSingle;

use App\Http\Controllers\PayOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::apiResource('datahandler', DataController::class);

Route::post('/dataHandler', [App\Http\Controllers\Api\DataController::class, 'index'])->name('dataHandler');

Route::get('/export-data', [App\Http\Controllers\Api\ReportGenerator::class, 'index'])->name('exportData');

Route::get('/clear-cache', [App\Http\Controllers\Api\CacheController::class, 'clearCache']);

// Route::get('/export-data-single', [ReportGeneratorSingle::class, 'index'])->name('exportDataSingle');

Route::get('/export-data-single', [ReportGenerationLoop::class, 'index'])->name('exportDataSingle');

Route::post('/approveReport/{id}', [App\Http\Controllers\Api\ReportGenerator::class, 'approveReport'])->name('approveReport');

Route::post('/revertApproval/{id}', [App\Http\Controllers\Api\ReportGenerator::class, 'revertApproval'])->name('revertApproval');

Route::get('/leftOutTrxFinder', [App\Http\Controllers\Api\LeftoutTrxFinder::class, 'index'])->name('leftOutTrxFinder');

Route::get('/addMissingColumns', [App\Http\Controllers\Api\AddMissingColumns::class, 'index'])->name('addMissingColumns');

Route::get('/apiHealthChecker', [App\Http\Controllers\Api\ApiHealthChecker::class, 'index'])->name('apiHealthChecker');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
