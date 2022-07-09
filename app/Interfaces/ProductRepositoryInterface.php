<?php

namespace App\Interfaces;

interface ProductRepositoryInterface 
{
    public function getAllproduct();
    public function paginateProduct($pagePaginate);
    public function sortingProduct($sortBy, $sorting, $filterByColumn, $searchByColumn);
    public function selectProduct($request);
    public function insertProduct($request);
    public function updateProduct($request);
    public function updateQuantityproduct($product_id, $quantity_rest);
    public function deleteProduct($id);
}