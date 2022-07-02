<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //Insert data product
    public function insert(Request $request){
        //validation
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'price'     => 'required',
            'quantity'   => 'required',
        ]);

        //if some data is null
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray());
        }

        //execute 
        $repository = new ProductRepository();
        $create = $repository->crate_data_product($request);

        //response
        if ($create) {
            return response()->json([
                "success" => 200,
                "message" => "Product created successfully.",
                "data" => $create
            ]);
        }else{
            return response()->json([
                "code" => 400,
                "message" => "Bad request !",
            ]);
        }
    }

    //read data product
    public function read(Request $request){
        //validation
        $validator = Validator::make($request->all(), [
            'pagination'     => 'required',
        ]);

        //if some data is null
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray());
        }

        //execute 
        $repository = new ProductRepository();
        $read = $repository->read_data_product($request);

        if ($read) {
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

    //update data product
    public function update(Request $request){
        //validation
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'price',
            'quantity',
        ]);

        //if some data is null
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray());
        }

        // //execute 
        $repository = new ProductRepository();
        $update = $repository->update_data_product($request);

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

    //update data product
    public function delete(Request $request){
        //validation
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
        ]);

        //if some data is null
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray());
        }

        // //execute 
        $repository = new ProductRepository();
        $update = $repository->delete_data_product($request);

        if ($update) {
            return response()->json([
                "success" => 200,
                "message" => "Product deleted successfully.",
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
}

class ProductRepository{
    // Insert data database
    public function crate_data_product($request){
        $product = Product::create([
            'product_name'     => $request->name,
            'product_price'     => $request->price,
            'product_quantity'   => $request->quantity,
        ]);

        return $product;
    }

    // Insert data database
    public function read_data_product($request){
        $product = Product::paginate($request->pagination);

        return $product;
    }

    // update data database
    public function update_data_product($request){

        if ($request->price && !$request->quantity) {
            $product = Product::where('product_name', $request->name)
            ->update(['product_price' => $request->price]);
            
        }else if ($request->quantity && !$request->price){
            $product = Product::where('product_name', $request->name)
            ->update(['product_quantity' => $request->quantity]);

        }else if (!$request->price && !$request->quantity) {
            return 0;
        }else {
            $product = Product::where('product_name', $request->name)
            ->update([
                'product_price' => $request->price,
                'product_quantity' => $request->quantity
            ]);
        }
        
        return $product;
    }

    // delete data database
    public function delete_data_product($request){
        $product = Product::where('product_name', $request->name)
        ->delete();

        return $product;
    }

}
