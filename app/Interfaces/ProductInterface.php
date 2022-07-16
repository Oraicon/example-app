<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function getAllProduct();

    public function paginateProduct($pagePaginate);

    public function sortingProduct($sortBy, $sorting, $filterByColumn, $searchByColumn);

    public function selectProduct($request);

    public function insertProduct($request);

    public function updateProduct($request);

    public function updateProductQty($product_id, $quantity_rest);

    public function deleteProduct($id);
}
