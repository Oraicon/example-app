<?php

namespace App\Repositories;

use App\Interfaces\TransactionInterface;
use App\Models\Transaction;

class TransactionRepository implements TransactionInterface
{

    public function updateTransaction($request)
    {
        return Transaction::where('product_name', $request->name)
        ->update([
            'product_name'     => $request->name,
            'product_price'     => $request->price,
            'product_quantity'   => $request->quantity,
        ]);
    }

    public function Transaction($product_id, $transaction_quantity)
    {
        return Transaction::create([
            'product_id'     => $product_id,
            'transactions_quantity'   => $transaction_quantity
        ]);
    }
}
