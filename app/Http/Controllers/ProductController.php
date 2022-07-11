<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{

    private ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/product",
     *     tags={"product"},
     *     summary="Returns All Product API response",
     *     description="A sample greeting to test out the API",
     *     operationId="product",
     *     @OA\Parameter(
     *          name="product_name",
     *          description="product name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="product_price",
     *          description="product price",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="product_quantity",
     *          description="product quantity",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="retrived data successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Required field empty"
     *     ),
     * )
     */
    public function readAllProduct(): JsonResponse
    {
        $read = $this->productRepository->getAllproduct();

        if (!$read->isEmpty()) {
            return response()->json([
                "success" => 200,
                "message" => "Product read successfully.",
                "data" => $read
            ]);
        } else {
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
    public function paginateProduct(Request $request): JsonResponse
    {
        $pagePaginate = $request->route('pagePaginate');

        $read = $this->productRepository->paginateProduct($pagePaginate);

        if (!$read->isEmpty()) {
            return response()->json([
                "success" => 200,
                "message" => "Product read successfully.",
                "data" => $read
            ]);
        } else {
            return response()->json([
                "code" => 405,
                "message" => "Invalid input !",
            ]);
        }
    }

    /**
     * Read date with sortBy,sorting, filter, and search by column
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
    public function sortingProduct(Request $request): JsonResponse
    {
        $sortBy = $request->route('sortBy');
        $sorting = $request->route('sorting');
        $filterByColumn = $request->route('filterByColumn');
        $searchByColumn = $request->route('searchByColumn');

        if ($searchByColumn == null) {
            $searchByColumn = "product_name";
        }

        $read = $this->productRepository->sortingProduct($sortBy, $sorting, $filterByColumn, $searchByColumn);

        // var_dump($sortBy, $read);

        if (!$read->isEmpty()) {
            return response()->json([
                "success" => 200,
                "message" => "Product read successfully.",
                "data" => $read
            ]);
        } else {
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
    public function insertProduct(Request $request): JsonResponse
    {
        //validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
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
        } else {
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
    public function updateProduct(Request $request): JsonResponse
    {
        //validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required'
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
        } else {
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
    public function deleteProduct(Request $request): JsonResponse
    {
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
        } else {
            return response()->json([
                "code" => 400,
                "message" => "Bad request !",
                "data" => $delete
            ]);
        }
    }
}
