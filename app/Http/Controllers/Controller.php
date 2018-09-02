<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
* @OA\Info(title="Car Flow", version="0.1")
*
* @OA\Tag(
*   name="user",
*   description="User resource",
*   @OA\ExternalDocumentation(
*     description="Find out more",
*     url="http://swagger.io"
*   )
* )
*
* @OA\SecurityScheme(
*   securityScheme="api_key",
*   type="apiKey",
*   in="header",
*   name="Authorization"
* )
*
*/
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
