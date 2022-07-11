<?php

namespace App\Interfaces;

interface TransactionInterface
{
    public function Transaction($product_id, $transaction_quantity);
}
