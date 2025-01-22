<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info (
 *      title ="My swager Doc",
 *      version ="1.0.0"
 * ),
 * @OA\Server(
 *      url="http://localhost:8080/api",
 *      description="Development Server"
 *),
 *
 * @OA\Components(
 *     @OA\SecurityScheme(
 *          securityScheme="bearerAuth",
 *          type="http",
 *          scheme="bearer",
 *          bearerFormat="JWT",
 *          in="header",
 *          description="Enter your bearer token in the following format: `Bearer {token}`"
 *      )
 * )
 */
class MainController extends Controller
{
    //
}
