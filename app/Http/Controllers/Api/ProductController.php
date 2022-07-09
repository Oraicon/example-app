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

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      x={
     *          "logo": {
     *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
     *          }
     *      },
     *      title="L5 OpenApi",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="darius@matulionis.lt"
     *      ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
    */

    /**
     * Read all product
     *
     * @OA\get(
     *     tags={"ProductController"},
     *     path="/v1/products",
     *     operationId="readAllProduct",
     *     @OA\Response(
     *         response=200,
     *         description="Product read successfully"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     * )
     * 
     * 
     */

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
                "code" => 405,
                "message" => "Invalid input !",
            ]);
        }
    }

    /**
     * Read paginate product
     *
     * @OA\get(
     *     tags={"ProductController"},
     *     path="/v1/products/{pagePaginate}",
     *     operationId="paginateProduct",
     *     @OA\Response(
     *         response=200,
     *         description="Product read successfully"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     * )
     * 
     * 
     */

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
                "code" => 405,
                "message" => "Invalid input !",
            ]);
        }
    }

    /**
     * Read date with sortby,sorting, filter, and search by column
     *
     * @OA\get(
     *     tags={"ProductController"},
     *     path="/v1/products/{sortBy}/{sorting}/{filterByColumn}/{searchByColumn}",
     *     operationId="sortingProduct",
     *     @OA\Response(
     *         response=200,
     *         description="Product read successfully"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     * )
     * 
     * 
     */

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
                "code" => 405,
                "message" => "Invalid input !",
            ]);
        }
    }

    /**
     * Insert data product
     *
     * @OA\post(
     *     tags={"ProductController"},
     *     path="/v1/products",
     *     operationId="insertProduct",
     * @OA\Response(
     *         response=200,
     *         description="Product created successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Required field empty"
     *     ),
     * )
     * 
     * 
     */

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
                "message" => "Required field empty",
                "data" => $validator->errors()->toArray()
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

    /**
     * update data product
     *
     * @OA\put(
     *     tags={"ProductController"},
     *     path="/v1/products",
     *     operationId="updateProduct",
     * @OA\Response(
     *         response=200,
     *         description="Product updated successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Required field empty"
     *     ),
     * )
     * 
     * 
     */

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
                "message" => "Required field empty",
                "data" => $validator->errors()->toArray()
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

    /**
     * delete data product
     *
     * @OA\delete(
     *     tags={"ProductController"},
     *     path="/v1/products",
     *     operationId="deleteProduct",
     * @OA\Response(
     *         response=200,
     *         description="Product deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     * )
     * 
     * 
     */

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