<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionController;
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

Route::post('product/1/create_data', [ProductController::class, 'insert']);
Route::post('product/1/read_data', [ProductController::class, 'read']);
Route::post('product/1/update_data', [ProductController::class, 'update']);
Route::post('product/1/delete_data', [ProductController::class, 'delete']);

Route::post('transaction/1/transaction_data', [TransactionController::class, 'transaction']);