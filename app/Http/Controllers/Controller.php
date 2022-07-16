<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      x={
 *          "logo": {
 *              "url": "https://via.placeholder.com/190x90.png?text=MarketPlace"
 *          }
 *      },
 *      title="Marketplace Back End Swager API Documentation",
 *      description="Marketplace Back End Swager API Description",
 *      @OA\Contact(
 *          email="example@google.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Tag(
 *     name="product",
 *     description="Everything about your products",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="https://swagger.io"
 *     )
 * )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
/**
 * @OA\SecurityScheme(
 *     securityScheme="api_key",
 *     type="apiKey",
 *     in="header",
 *     name="api_key"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="petstore_auth",
 *     type="oauth2",
 *     @OA\Flow(
 *         authorizationUrl="https://petstore.swagger.io/oauth/dialog",
 *         flow="implicit",
 *         scopes={
 *             "read:pets": "read your API",
 *             "write:pets": "modify pets in your account"
 *         }
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
