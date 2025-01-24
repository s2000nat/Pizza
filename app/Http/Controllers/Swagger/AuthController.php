<?php

declare(strict_types=1);

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Registration, Login, Logout"
 * )
 *
 * @OA\Post(
 *     path="/register",
 *     tags={"Auth"},
 *     summary="Register",
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     required={"name", "password", "phone_number"},
 *                     @OA\Property(property="name", type="string", example="Jhon"),
 *                     @OA\Property(property="email", type="string", example="example@mail.ru"),
 *                     @OA\Property(property="password", type="string", example="Qwerty"),
 *                     @OA\Property(property="phone_number", type="string", example="88005553535"),
 *                 )
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="registered",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", example="Jhon, registration complete.")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *      path="/login",
 *      tags={"Auth"},
 *      summary="Login",
 *      @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      required={"phone_number", "password"},
 *                      @OA\Property(property="phone_number", type="string", example="88005553535"),
 *                      @OA\Property(property="password", type="string", example="Qwerty"),
 *                  )
 *              }
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="token", example="3|5MhZkbe6xQXLQOSTJvwx24iZmywEuRxj5NGtkLRf610dc000")
 *          )
 *      )
 *  )
 *
 * @OA\Post(
 *       path="/logout",
 *       tags={"Auth"},
 *       summary="Logout",
 *       @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", example="Successfully logged out")
 *           )
 *       )
 *   )
 *
 */
class AuthController extends Controller
{
}
