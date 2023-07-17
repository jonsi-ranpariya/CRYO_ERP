<?php

use App\Http\Controllers\Pdf\GeneratePDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API PDF Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware'=>'auth:sanctum'],function (){

    Route::post('/generate-pdf',[GeneratePDF::class,'generatePdf']);
    Route::post('/delete',[GeneratePDF::class,'deletePDF']);

    //Package List Pdf
    Route::post('/generate-challan-package-list-invoice', [GeneratePDF::class, 'challanInvoicePackageList']);

    //Envelope Print
    Route::post('/get-challan-invoice-envelope-preview', [GeneratePDF::class,'getChallanInvoiceEnvelopePreview']);

    //Sticker Printing
    Route::post('/sticker-print-preview', [GeneratePDF::class,'stickerPrintPreview']);

    //Credit note
    Route::post('/generate-credit-note-invoice', [GeneratePDF::class,'creditNoteInvoice']);

    //Debit Note
    Route::post('/purchase-return-invoice-preview', [GeneratePDF::class,'purchaseReturnEInvoicePreview']);

    //party Master Envelope Print
    Route::post('/party-master-envelope', [GeneratePDF::class,'partyMasterEnvelopePrint']);
});


