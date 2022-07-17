<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('product', 'productAll');
        Route::get('product/{pagePaginate}', 'productPaginate');
        Route::get('product/{sortBy}/{sorting}/{filterByColumn}/{searchByColumn}', 'productSorting');
    
        Route::post('product', 'productInsert');
        Route::put('product', 'productUpdate');
        Route::delete('product/{id}', 'productDelete');
    });
    
    Route::controller(TransactionController::class)->group(function () {
        Route::post('transaction', 'productTransaction');
    });
});
