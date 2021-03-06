<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use App\Interfaces\TransactionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    private ProductInterface $productRepository;

    private TransactionInterface $transactionRepository;

    public function __construct(ProductInterface $productRepository, TransactionInterface $transactionRepository)
    {
        $this->productRepository = $productRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function transaction(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required',
        ]);

        //if some data is null
        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Required field empty',
                'data' => $validator->errors()->toArray(),
            ]);
        }

        //execute
        $read = $this->productRepository->selectProduct($request);

        //if data exist
        if ($read->isEmpty()) {
            // preparation variable
            $product_id = $read[0]['id'];
            $product_price = $read[0]['product_price'];
            $product_quantity = $read[0]['product_quantity'];
            $transaction_name = $request->name;
            $transaction_quantity = $request->quantity;

            // summation
            $quantity_rest = $product_quantity - $transaction_quantity;
            $transaction_amount = $product_price * $transaction_quantity;

            // save data
            $create_transaction = $this->transactionRepository->createTransaction($product_id, $transaction_quantity);

            if ($create_transaction) {
                // update rest quantity
                $this->productRepository->updateProductQty($product_id, $quantity_rest);
                // return response
                return response()->json([
                    'success' => 200,
                    'message' => 'Transaction created successfully.',
                    'data' => [
                        'Product name' => $transaction_name,
                        'Quantity' => $transaction_quantity,
                        'Total' => $transaction_amount,
                    ],
                ]);
            } else {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad request !',
                ]);
            }
            //if data doesnt exist
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Not found !',
            ]);
        }
    }
}
