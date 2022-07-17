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
     *     summary="Returns Product API response with all product",
     *     description="returns product API response with all product",
     *     operationId="productAll",
     *     @OA\Response(response=200,description="Successful Operation"),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="Not Found"),
     *     @OA\Response(response=405,description="Invalid Input"),
     *     @OA\Response(response=500,description="Server Error"),
     * )
     */
    public function productAll(): JsonResponse
    {
        $read = $this->productRepository->getAllproduct();

        if (! $read->isEmpty()) {
            return response()->json([
                'success' => 200,
                'message' => 'Product read successfully.',
                'data' => $read,
            ]);
        } else {
            return response()->json([
                'code' => 405,
                'message' => 'Invalid input !',
            ]);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/product/{pagePaginate}",
     *     tags={"product"},
     *     summary="Returns Product API response with Pagination",
     *     description="returns product API response with Pagination",
     *     operationId="productPaginate",
     *     @OA\Parameter(
     *          name="pagePaginate",
     *          description="Page Index",
     *          example="1",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(response=200,description="Successful Operation"),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="Not Found"),
     *     @OA\Response(response=405,description="Invalid Input"),
     *     @OA\Response(response=500,description="Server Error"),
     * )
     */
    public function productPaginate(Request $request): JsonResponse
    {
        $pagePaginate = $request->route('pagePaginate');

        $read = $this->productRepository->paginateProduct($pagePaginate);

        if (! $read->isEmpty()) {
            return response()->json([
                'success' => 200,
                'message' => 'Product read successfully.',
                'data' => $read,
            ]);
        } else {
            return response()->json([
                'code' => 405,
                'message' => 'Invalid input',
            ]);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/product/{sortBy}/{sorting}/{filterByColumn}/{searchByColumn}",
     *     tags={"product"},
     *     summary="Returns Product API response with sort by column, sorting asc or desc, filter by price higher than, and search by column",
     *     description="Returns Product API response with sort by column, sorting asc or desc, filter by price higher than, and search by column",
     *     operationId="productSorting",
     *     @OA\Parameter(
     *          name="sortBy",
     *          description="Sorting by column",
     *          example="1",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="sorting",
     *          description="Sorting by ascending or descending",
     *          example="1",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="filterByColumn",
     *          description="Filter by price is higher than or equal",
     *          example="1000",
     *          required=true,
     *          in="query",
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="searchByColumn",
     *          description="Search By Column",
     *          example="product_name, product_price, product_quantity",
     *          required=true,
     *          in="query",
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Response(response=200,description="Successful Operation"),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="Not Found"),
     *     @OA\Response(response=405,description="Invalid Input"),
     *     @OA\Response(response=500,description="Server Error"),
     * )
     */
    public function productSorting(Request $request): JsonResponse
    {
        $sortBy = $request->route('sortBy');
        $sorting = $request->route('sorting');
        $filterByColumn = $request->route('filterByColumn');
        $searchByColumn = $request->route('searchByColumn');

        if ($searchByColumn == null) {
            $searchByColumn = 'product_name';
        }

        $read = $this->productRepository->sortingProduct($sortBy, $sorting, $filterByColumn, $searchByColumn);

        // var_dump($sortBy, $read);

        if (! $read->isEmpty()) {
            return response()->json([
                'success' => 200,
                'message' => 'Product read successfully.',
                'data' => $read,
            ]);
        } else {
            return response()->json([
                'code' => 405,
                'message' => 'Invalid input !',
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/product",
     *     tags={"product"},
     *     summary="Create new product data",
     *     operationId="productInsert",
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="product name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     description="product price",
     *                     type="string",
     *                 ),
     *                @OA\Property(
     *                     property="quantity",
     *                     description="product quantity",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,description="Successful Operation"),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="Not Found"),
     *     @OA\Response(response=405,description="Invalid Input"),
     *     @OA\Response(response=500,description="Server Error"),
     * )
     */
    public function productInsert(Request $request): JsonResponse
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
                'code' => 422,
                'message' => 'Required field empty',
                'data' => $validator->errors()->toArray(),
            ]);
        }

        //execute
        $insert = $this->productRepository->insertProduct($request);

        //response
        if ($insert) {
            return response()->json([
                'success' => 200,
                'message' => 'Product created successfully.',
                'data' => $insert,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Bad request !',
                'data' => $insert,
            ]);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/product",
     *     tags={"product"},
     *     summary="Update data product",
     *     operationId="productUpdate",
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="product name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     description="product price",
     *                     type="string",
     *                 ),
     *                @OA\Property(
     *                     property="quantity",
     *                     description="product quantity",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,description="Successful Operation"),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="Not Found"),
     *     @OA\Response(response=405,description="Invalid Input"),
     *     @OA\Response(response=422,description="Required field empty"),
     *     @OA\Response(response=500,description="Server Error"),
     * )
     */
    public function productUpdate(Request $request): JsonResponse
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
                'code' => 422,
                'message' => 'Required field empty',
                'data' => $validator->errors()->toArray(),
            ]);
        }

        // //execute
        $update = $this->productRepository->updateProduct($request);

        if ($update) {
            return response()->json([
                'success' => 200,
                'message' => 'Product updated successfully.',
                'data' => $update,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Bad request !',
                'data' => $update,
            ]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/product/{id}",
     *     tags={"product"},
     *     summary="Delete data product",
     *     operationId="productDelete",
     *     @OA\Parameter(
     *          name="id",
     *          description="id data",
     *          example="0852686e-9d64-4ada-a61b-5fc72fcadb27",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(response=200,description="Successful Operation"),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="Not Found"),
     *     @OA\Response(response=405,description="Invalid Input"),
     *     @OA\Response(response=422,description="Required field empty"),
     *     @OA\Response(response=500,description="Server Error"),
     * )
     */
    public function productDelete(Request $request): JsonResponse
    {
        //validation
        $id = $request->route('id');

        // //execute
        $delete = $this->productRepository->deleteProduct($id);

        if ($delete) {
            return response()->json([
                'success' => 200,
                'message' => 'Product deleted successfully.',
                'data' => $delete,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Bad request !',
                'data' => $delete,
            ]);
        }
    }
}
