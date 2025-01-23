<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Cart",
 *     description="Operations related to users cart"
 * )
 */

/**
 * @OA\Get(
 *     path="/cart",
 *     tags={"Cart"},
 *     summary="Get a list of products in cart",
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="list of products in cart",
 *         @OA\JsonContent(
 *             @OA\Property (property="products", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="product_name", type="string", example="Something tasty"),
 *                 @OA\Property(property="size", type="string", example="Some size"),
 *                 @OA\Property(property="price", type="integer", example=599),
 *                 @OA\Property(property="quantity", type="integer", example=1)
 *             )),
 *             @OA\Property (property="total_price", type="integer", example=1000)
 *        )
 *    ),
 * )
 *
 * @OA\Post(
 *       path="/cart",
 *       tags={"Cart"},
 *       summary="Store item in cart",
 *       security={{"bearerAuth": {}}},
 *       @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                   @OA\Schema(
 *                       required={"menu_item_id", "category_size_price_id"},
 *                       @OA\Property(property="menu_item_id", type="integer", example=1),
 *                       @OA\Property(property="category_size_price_id", type="integer", example=2),
 *                   )
 *               }
 *           )
 *       ),
 *       @OA\Response(
 *           response=201,
 *           description="list of products in cart",
 *           @OA\JsonContent(
 *               @OA\Property (property="products", type="array", @OA\Items(
 *                   @OA\Property(property="id", type="integer", example=1),
 *                   @OA\Property(property="product_name", type="string", example="Something tasty"),
 *                   @OA\Property(property="size", type="string", example="Some size"),
 *                   @OA\Property(property="price", type="integer", example=599),
 *                   @OA\Property(property="quantity", type="integer", example=1)
 *               )),
 *               @OA\Property (property="total_price", type="integer", example=1000)
 *           )
 *       ),
 *
 *  )
 *
 * @OA\Delete(
 *       path="/cart/{product}",
 *       tags={"Cart"},
 *       summary="Delete Item from cart",
 *       security={{"bearerAuth": {}}},
 *       @OA\Parameter(
 *           description="product id",
 *           in="path",
 *           name="product",
 *           required=true,
 *           example=1,
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Item from cart deleted",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", example="Product deleted from cart successfully.")
 *           )
 *       ),
 *       @OA\Response(
 *           response=404,
 *           description="Not Found",
 *           @OA\JsonContent(
 *              @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *              @OA\Property(property="message", example="Not Found")
 *          )
 *       )
 *   )
 */
class CartController extends Controller
{}

