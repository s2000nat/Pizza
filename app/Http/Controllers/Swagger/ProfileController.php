<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *      name="Profile",
 *      description="Operations related to profile."
 *  )
 *
 * @OA\Get(
 *      path="/profile",
 *      tags={"Profile"},
 *      summary="Get info about own profile",
 *      security={{"bearerAuth": {}}},
 *      @OA\Response(
 *          response=200,
 *          description="prepare order",
 *          @OA\JsonContent(
 *              @OA\Property (property="user", type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="name", type="string", example="Jhon"),
 *                  @OA\Property(property="email", type="string", example="jhon@mail.ru"),
 *                  @OA\Property(property="phone_number", type="string", example="89617756027"),
 *              ),
 *              @OA\Property (property="locations", type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="city", type="string", example="New York"),
 *                  @OA\Property(property="street", type="string", example="Lenina"),
 *                  @OA\Property(property="house_number", type="string", example="25b"),
 *                  @OA\Property(property="floor", type="integer", example=15),
 *                  @OA\Property(property="apartment", type="integer", example=151)
 *              )),
 *          )
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *              @OA\Property(property="message", example="Unauthenticated.")
 *          )
 *      ),
 *  )
 *
 * @OA\Post(
 *     path="/profile/location",
 *     tags={"Profile"},
 *     summary="Get info about own profile",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     required={"city", "street", "house_number"},
 *                     @OA\Property(property="city", type="string", example="New York"),
 *                     @OA\Property(property="street", type="string", example="Lenina"),
 *                     @OA\Property(property="house_number", type="string", example="25b"),
 *                     @OA\Property(property="floor", type="integer", example=15),
 *                     @OA\Property(property="apartment", type="integer", example=151)
 *                 )
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Order created",
 *         @OA\JsonContent(
 *            @OA\Property(property="id", type="integer", example=1),
 *            @OA\Property(property="city", type="string", example="New York"),
 *            @OA\Property(property="street", type="string", example="Lenina"),
 *            @OA\Property(property="house_number", type="string", example="25b"),
 *            @OA\Property(property="floor", type="integer", example=15),
 *            @OA\Property(property="apartment", type="integer", example=151)
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="Empty cart",
 *          @OA\JsonContent(
 *              @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *              @OA\Property(property="message", example="Unauthenticated.")
 *          )
 *      ),
 *
 *     )
 * )
 *
 * @OA\Put(
 *       path="/profile/location/{location}",
 *      tags={"Profile"},
 *      summary="Get info about own profile",
 *      security={{"bearerAuth": {}}},
 *       @OA\Parameter(
 *           description="location id",
 *           in="path",
 *           name="location",
 *           required=true,
 *           example=1,
 *       ),
 *       @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                   @OA\Schema(
 *                       @OA\Property(property="city", type="string", example="New York"),
 *                       @OA\Property(property="street", type="string", example="Lenina"),
 *                       @OA\Property(property="house_number", type="string", example="25b"),
 *                       @OA\Property(property="floor", type="integer", example=15),
 *                       @OA\Property(property="apartment", type="integer", example=151),
 *                       @OA\Property(property="deleted", type="bool", example=false)
 *                   )
 *               }
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Updated",
 *           @OA\JsonContent(
 *               @OA\Property(property="id", type="integer", example=1),
 *               @OA\Property(property="city", type="string", example="New York"),
 *               @OA\Property(property="street", type="string", example="Lenina"),
 *               @OA\Property(property="house_number", type="string", example="25b"),
 *               @OA\Property(property="floor", type="integer", example=15),
 *               @OA\Property(property="apartment", type="integer", example=151)
 *           )
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Not Found",
 *          @OA\JsonContent(
 *             @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *             @OA\Property(property="message", example="Not Found")
 *          )
 *      ),
 *      @OA\Response(
 *           response=403,
 *           description="if location was deleted",
 *           @OA\JsonContent(
 *              @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *              @OA\Property(property="message", example="Forbiden")
 *           )
 *       ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *              @OA\Property(property="message", example="Unauthenticated.")
 *          )
 *      ),
 *   )
 */
class ProfileController extends Controller
{
}
