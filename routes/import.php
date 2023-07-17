<?php

/*
|--------------------------------------------------------------------------
| Import Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Import API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Import API!
|
*/

use App\Actions\Import\ImportNowAction;
use App\Actions\Import\Master\ItemMasterImportAction;
use App\Actions\Import\Master\PartyMasterImportAction;
use Illuminate\Support\Facades\Route;

/*
 *----------------------------------------------------------------
 * Sample File Download Routes
 *----------------------------------------------------------------
 */
Route::get('item-master-sample-file-download', function () {
    return jsonData(['path' => asset('sample/SAMPLE_ITEM_MASTER_IMPORT.xlsx')]);
});

Route::get('party-master-sample-file-download', function () {
    return jsonData(['path' => asset('sample/SAMPLE_PARTY_MASTER_IMPORT.xlsx')]);
});

/*
 *----------------------------------------------------------------
 * File Import Routes
 *----------------------------------------------------------------
 */

Route::post('item-master',ItemMasterImportAction::class);
Route::get('import-now', ImportNowAction::class);
Route::post('party-master', PartyMasterImportAction::class);
