<?php

namespace App\Interfaces;

interface TransactionInterface
{
    public function createTransaction($product_id, $transaction_quantity);
}
