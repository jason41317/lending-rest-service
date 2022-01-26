<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    // Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('/customers', 'CustomerController');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/suppliers', 'SupplierController');
    Route::resource('/units', 'UnitController');
    Route::resource('/products', 'ProductController');
    Route::resource('/purchase-orders', 'PurchaseOrderController');
    Route::resource('/receivings', 'ReceivingController');
    Route::resource('/issuances', 'IssuanceController');
    Route::resource('/adjustments', 'AdjustmentController');
    // }
});
