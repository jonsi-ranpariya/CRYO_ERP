<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
/*
 * This is for vue route
 * Do not change anything in this first route */


Route::get('/{hash}', [ApplicationController::class,'index'])->where('hash', '[\/\w\.-]*');
/* -=-=-=-=-=-=-=-=-==-=-= */
