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
     *     path="/api/v1/product/{pageIndex}/{pageSize}",
     *     tags={"product"},
     *     summary="Returns Product API response with Pagination",
     *     description="returns product API response with Pagination",
     *     operationId="product",
     *     @OA\Parameter(
     *          name="pageIndex",
     *          description="Page Index",
     *          example="1",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="pageSize",
     *          description="Page Size",
     *          example="10",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="filterBy",
     *          description="Filter By Available Columns",
     *          example="string 1,string 2,string 3",
     *          required=false,
     *          in="query",
     *         @OA\Schema(
     *           type = "array",
     *              @OA\Items(type="string",default="product_name")
     *     )
     *     ),
     *     @OA\Parameter(
     *          name="sortBy",
     *          description="Sort By Descending",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *     ),
     *     @OA\Response(response=200,description="Successful Operation"),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="Not Found"),
     *     @OA\Response(response=500,description="Server Error"),
     * )
     */
    public function productPagination(): JsonResponse
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

    public function paginateProduct(Request $request): JsonResponse
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
                'message' => 'Invalid input !',
            ]);
        }
    }

    public function sortingProduct(Request $request): JsonResponse
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

    public function updateProduct(Request $request): JsonResponse
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

    public function deleteProduct(Request $request): JsonResponse
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
