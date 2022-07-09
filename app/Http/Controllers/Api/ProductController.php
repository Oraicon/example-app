<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) 
    {
        $this->productRepository = $productRepository;
    }

    //read data product
    public function readAllProduct(){
        $read = $this->productRepository->getAllproduct();

        if (!$read ->isEmpty()) {
            return response()->json([
                "success" => 200,
                "message" => "Product read successfully.",
                "data" => $read
            ]);
        }else{
            return response()->json([
                "code" => 400,
                "message" => "Bad request !",
            ]);
        }
    }

    //read date with paginate product
    public function paginateProduct(Request $request){
        $pagePaginate = $request->route('pagePaginate');

        $read = $this->productRepository->paginateProduct($pagePaginate);

        if (!$read ->isEmpty()) {
            return response()->json([
                "success" => 200,
                "message" => "Product read successfully.",
                "data" => $read
            ]);
        }else{
            return response()->json([
                "code" => 400,
                "message" => "Bad request !",
            ]);
        }
    }

    //read date with sortby,sorting, filter, and search by column
    public function sortingProduct(Request $request){
        $sortBy = $request->route('sortBy');
        $sorting = $request->route('sorting');
        $filterByColumn = $request->route('filterByColumn');
        $searchByColumn = $request->route('searchByColumn');

        if ($searchByColumn == null) {
            $searchByColumn = "product_name";
        }

        $read = $this->productRepository->sortingProduct($sortBy, $sorting, $filterByColumn, $searchByColumn);

        // var_dump($sortBy, $read);

        if (!$read ->isEmpty()) {
            return response()->json([
                "success" => 200,
                "message" => "Product read successfully.",
                "data" => $read
            ]);
        }else{
            return response()->json([
                "code" => 400,
                "message" => "Bad request !",
            ]);
        }
    }

    //Insert data product
    public function insertProduct(Request $request){
        //validation
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'price'     => 'required',
            'quantity'   => 'required',
        ]);

        //if some data is null
        if ($validator->fails()) {
            return response()->json([
                "code" => 422,
                "message" => $validator->errors()->toArray(),
                "data" => null
            ]);
        }

        //execute 
        $insert = $this->productRepository->insertProduct($request);

        //response
        if ($insert) {
            return response()->json([
                "success" => 200,
                "message" => "Product created successfully.",
                "data" => $insert
            ]);
        }else{
            return response()->json([
                "code" => 400,
                "message" => "Bad request !",
                "data" => $insert
            ]);
        }
    }

    //update data product
    public function updateProduct(Request $request){
        //validation
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'price'    => 'required',
            'quantity'=> 'required'
        ]);

        //if some data is null
        if ($validator->fails()) {
            return response()->json([
                "code" => 422,
                "message" => $validator->errors()->toArray(),
                "data" => null
            ]);
        }

        // //execute 
        $update = $this->productRepository->updateProduct($request);

        if ($update) {
            return response()->json([
                "success" => 200,
                "message" => "Product updated successfully.",
                "data" => $update
            ]);
        }else{
            return response()->json([
                "code" => 400,
                "message" => "Bad request !",
                "data" => $update
            ]);
        }
    }

    //delete data product
    public function deleteProduct(Request $request){
        //validation
        $id = $request->route('id');

        // //execute 
        $delete = $this->productRepository->deleteProduct($id);

        if ($delete) {
            return response()->json([
                "success" => 200,
                "message" => "Product deleted successfully.",
                "data" => $delete
            ]);
        }else{
            return response()->json([
                "code" => 400,
                "message" => "Bad request !",
                "data" => $delete
            ]);
        }
    }
}