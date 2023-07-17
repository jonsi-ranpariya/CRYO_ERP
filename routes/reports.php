<?php

use App\Actions\Reports\SalesEnquiryReportAction;
use App\Actions\Reports\SalesQuotationReportAction;
use App\Actions\Reports\StockLedgerReportAction;
use Illuminate\Support\Facades\Route;
use App\Actions\Reports\SalesOrderReportAction;

/*
|--------------------------------------------------------------------------
| API Reports Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'web'], function () {
    Route::get('/', function () {
        testDie('here');
    });

    Route::post('sales-order-report', SalesOrderReportAction::class);
    Route::post('sales-quotation-report', SalesQuotationReportAction::class);
    Route::post('sales-enquiry-report', SalesEnquiryReportAction::class);
    Route::post('stock-ledger-report', StockLedgerReportAction::class);

});


