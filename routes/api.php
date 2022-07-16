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

Route::controller(ProductController::class)->group(function () {
    Route::get('v1/products', 'readAllProduct');
    Route::get('v1/products/{pagePaginate}', 'paginateProduct');
    Route::get('v1/products/{sortBy}/{sorting}/{filterByColumn}/{searchByColumn}', 'sortingProduct');

    Route::post('v1/products', 'insertProduct');
    Route::put('v1/products', 'updateProduct');
    Route::delete('v1/products/{id}', 'deleteProduct');
});

Route::controller(TransactionController::class)->group(function () {
    Route::post('v1/transaction', 'transactionProduct');
});
