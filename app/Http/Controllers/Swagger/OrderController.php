<?php

declare(strict_types=1);

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Orders",
 *     description="Operations related to user's orders"
 * )
 */

/**
 * @OA\Get(
 *     path="/orders",
 *     tags={"Orders"},
 *     summary="Get prepared info about order",
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="prepare order",
 *         @OA\JsonContent(
 *             @OA\Property (property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Jhon"),
 *                 @OA\Property(property="email", type="string", example="jhon@mail.ru"),
 *                 @OA\Property(property="phone_number", type="string", example="89617756027"),
 *             ),
 *             @OA\Property (property="locations", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="city", type="string", example="New York"),
 *                 @OA\Property(property="street", type="string", example="Lenina"),
 *                 @OA\Property(property="house_number", type="string", example="25b"),
 *                 @OA\Property(property="floor", type="integer", example=15),
 *                 @OA\Property(property="apartment", type="integer", example=151)
 *             )),
 *             @OA\Property (property="cart", type="object",
 *                  @OA\Property (property="locations", type="array", @OA\Items(
 *                      @OA\Property(property="id", type="integer", example=1),
 *                      @OA\Property(property="product_name", type="string", example="Something tasty"),
 *                      @OA\Property(property="size", type="string", example="Some size"),
 *                      @OA\Property(property="price", type="integer", example=599),
 *                      @OA\Property(property="quantity", type="integer", example=1)
 *                  )),
 *                  @OA\Property (property="total_price", type="integer", example=1000)
 *             )
 *         )
 *     ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *              @OA\Property(property="message", example="Unauthenticated.")
 *          )
 *      ),
 * )
 *
 * @OA\Post(
 *        path="/orders",
 *        tags={"Orders"},
 *        summary="Create order",
 *        security={{"bearerAuth": {}}},
 *        @OA\RequestBody(
 *            @OA\JsonContent(
 *                allOf={
 *                    @OA\Schema(
 *                        required={"phone_number", "location_id"},
 *                        @OA\Property(property="phone_number", type="string", example="89617756027"),
 *                        @OA\Property(property="location_id", type="integer", example=2),
 *                    )
 *                }
 *            )
 *        ),
 *        @OA\Response(
 *            response=201,
 *            description="Order created",
 *            @OA\JsonContent(
 *                @OA\Property (property="message", type="string", example="Order created successfully")
 *            )
 *        ),
 *        @OA\Response(
 *             response=400,
 *             description="Empty cart",
 *             @OA\JsonContent(
 *                 @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *                 @OA\Property(property="message", example="Your cart is empty..")
 *             )
 *         ),
 *
 *   )
 * @OA\Get(
 *      path="/own-orders",
 *      tags={"Orders"},
 *      summary="Get all own orders",
 *      security={{"bearerAuth": {}}},
 *      @OA\Response(
 *          response=200,
 *          description="prepare order",
 *          @OA\JsonContent(
 *              @OA\Property (property="orders", type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property (property="user", type="object",
 *                      @OA\Property(property="id", type="integer", example=1),
 *                      @OA\Property(property="name", type="string", example="Jhon"),
 *                      @OA\Property(property="email", type="string", example="jhon@mail.ru"),
 *                      @OA\Property(property="phone_number", type="string", example="89617756027"),
 *                  ),
 *                  @OA\Property(property="created_at", type="string", example="2025-01-23 21:20:45"),
 *                  @OA\Property (property="locations", type="object",
 *                      @OA\Property(property="id", type="integer", example=1),
 *                      @OA\Property(property="city", type="string", example="New York"),
 *                      @OA\Property(property="street", type="string", example="Lenina"),
 *                      @OA\Property(property="house_number", type="string", example="25b"),
 *                      @OA\Property(property="floor", type="integer", example=15),
 *                      @OA\Property(property="apartment", type="integer", example=151)
 *                  ),
 *                  @OA\Property(property="status", type="string", example="pending"),
 *                  @OA\Property (property="products", type="array", @OA\Items(
 *                      @OA\Property(property="id", type="integer", example=1),
 *                      @OA\Property(property="product_name", type="string", example="Something tasty"),
 *                      @OA\Property(property="size", type="string", example="Some size"),
 *                      @OA\Property(property="price", type="integer", example=599),
 *                      @OA\Property(property="quantity", type="integer", example=1)
 *                  ),
 *                  @OA\Property (property="total_price", type="integer", example=1000)
 *                 )
 *              ))
 *          )
 *      ),
 *       @OA\Response(
 *           response=401,
 *           description="Unauthorized",
 *           @OA\JsonContent(
 *               @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *               @OA\Property(property="message", example="Unauthenticated.")
 *           )
 *       ),
 *  )
 */
class OrderController extends Controller
{

}
