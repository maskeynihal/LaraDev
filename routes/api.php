<?php

use App\Http\Controllers\KhaltiFrontendController;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/pin-verify', 'KhaltiFrontendController@pinVerify')->name('khalti.pinVerify');
Route::post('/khalti-confirm-payment', 'KhaltiFrontendController@confirmPayment')->name('khalti.confirmPayment');
