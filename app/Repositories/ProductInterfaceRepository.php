<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;

class ProductInterfaceRepository implements ProductInterface
{
    public function getAllProduct(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::all();
    }

    public function paginateProduct($pagePaginate)
    {
        return Product::fastPaginate($pagePaginate);
    }

    public function sortingProduct($sortBy, $sorting, $filterByColumn, $searchByColumn)
    {
        return Product::select($searchByColumn)->where('product_price', '=>', $filterByColumn)->orderBy($sortBy, $sorting)->get();
    }

    public function selectProduct($request)
    {
        return Product::select('id', 'product_price', 'product_quantity')
        ->where('product_name', $request->name)
        ->get();
    }

    public function insertProduct($request)
    {
        return Product::create([
            'product_name' => $request->name,
            'product_price' => $request->price,
            'product_quantity' => $request->quantity,
        ]);
    }

    public function updateProduct($request)
    {
        return Product::where('product_name', $request->name)
        ->update([
            'product_name' => $request->name,
            'product_price' => $request->price,
            'product_quantity' => $request->quantity,
        ]);
    }

    public function updateProductQty($product_id, $quantity_rest)
    {
        Product::where('id', $product_id)
        ->update(['product_quantity' => $quantity_rest]);
    }

    public function deleteProduct($id): int
    {
        return Product::destroy($id);
    }
}
