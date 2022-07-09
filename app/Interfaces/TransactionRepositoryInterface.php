<?php

namespace App\Interfaces;

interface TransactionRepositoryInterface 
{
    public function insertTransaction($product_id, $transaction_quantity);
}