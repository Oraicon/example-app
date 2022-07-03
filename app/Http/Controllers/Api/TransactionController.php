<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TransactionController extends Controller
{
    //transaction
    public function transaction(Request $request){
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'quantity'   => 'required',
        ]);

        //if some data is null
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray());
        }

        //execute
        $repository = new TransactionRepository();
        $read = $repository->read_data_product($request);

        //if data exist
        if ($read) {
            $product_id = $read[0]['id'];
            $product_price = $read[0]['product_price'];
            $product_quantity = $read[0]['product_quantity'];
            $transaction_name = $request->name;
            $transaction_quantity = $request->quantity;

            $quantity_rest = $product_quantity - $transaction_quantity;
            $transaction_amount = $product_price * $transaction_quantity;

            $repository->update_data_product($product_id, $quantity_rest);
            $create_transaction = $repository->insert_data_transaction($product_id, $transaction_quantity);

            if ($create_transaction) {
                return response()->json([
                    "success" => 200,
                    "message" => "Transaction created successfully.",
                    "data" => [
                        'Product name' => $transaction_name,
                        'Quantity' => $transaction_quantity,
                        'Total' => $transaction_amount
                    ]
                ]);
            }else{
                return response()->json([
                    "code" => 404,
                    "message" => "Bad request !",
                ]);
            }
        //if data doesnt exist
        }else{
            return response()->json([
                "code" => 404,
                "message" => "not found"
            ]);
        }
    }
}

class TransactionRepository extends Controller
{
    //check data product
    public function read_data_product($request){
        $product = Product::select('id', 'product_price', 'product_quantity')
        ->where('product_name', $request->name)
        ->get();

        return $product;
    }

    //update data product
    public function update_data_product($product_id, $quantity_rest){
        Product::where('id', $product_id)
        ->update(['product_quantity' => $quantity_rest]);
    }
    
    //insert data transaction
    public function insert_data_transaction($product_id, $transaction_quantity){
        $product = Transaction::create([
            'product_id'     => $product_id,
            'transactions_quantity'   => $transaction_quantity
        ]);

        return $product;
    }
}
