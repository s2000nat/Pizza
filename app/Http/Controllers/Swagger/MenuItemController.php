<?php

declare(strict_types=1);

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Menu Items",
 *     description="Operations related to price categories"
 * )
 *
 * @OA\Tag(
 *      name="Admin Menu Items",
 *      description="Adnmin operations related to price categories"
 *  )
 */

/**
 * @OA\Get(
 *     path="/menu-items",
 *     tags={"Menu Items"},
 *     summary="Get a list of Menu Items",
 *     @OA\Response(
 *         response=200,
 *         description="A list of Menu Items",
 *         @OA\JsonContent(
 *             @OA\Property (property="menuItems", type="array", @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Something tasty"),
 *                 @OA\Property(property="description", type="string", example="Some description"),
 *                 @OA\Property(property="price_category", type="string", example="Some price category"),
 *                 @OA\Property (property="prices_with_sizes", type="array", @OA\Items(
 *                     @OA\Property(property="price_category_size_id", type="integer", example=1),
 *                     @OA\Property(property="size", type="string", example="Something tasty"),
 *                     @OA\Property(property="price", type="integer", example=599)
 *                 ))
 *             ))
 *        )
 *    ),
 * )
 * @OA\Post(
 *      path="/admin/menu-items",
 *      tags={"Admin Menu Items"},
 *      summary="ADMIN Store Menu Item",
 *      security={{"bearerAuth": {}}},
 *      @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      required={"name", "id"},
 *                      @OA\Property(property="name", type="string", example="Something tasty"),
 *                      @OA\Property(property="description", type="string", example="Some description"),
 *                      @OA\Property(property="price_category_id", type="integer",example=1),
 *                  )
 *              }
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Created Menu Item",
 *          @OA\JsonContent(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="name", type="string", example="Something tasty"),
 *                  @OA\Property(property="description", type="string", example="Some description"),
 *                  @OA\Property(property="price_category", type="string", example="Some price category"),
 *                  @OA\Property (property="prices_with_sizes", type="array", @OA\Items(
 *                      @OA\Property(property="price_category_size_id", type="integer", example=1),
 *                      @OA\Property(property="size", type="string", example="Something tasty"),
 *                      @OA\Property(property="price", type="integer", example=599)
 *                  ))
 *         )
 *     ),
 * )
 *
 *
 * @OA\Get(
 *     path="/menu-items/{menu-item}",
 *     tags={"Menu Items"},
 *     summary="Get one of Menu Items",
 *     @OA\Parameter(
 *         description="Menu item id",
 *         in="path",
 *         name="menu-item",
 *         required=true,
 *         example=1,
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Menu Item",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Something tasty"),
 *             @OA\Property(property="description", type="string", example="Some description"),
 *             @OA\Property(property="price_category", type="string", example="Some price category"),
 *             @OA\Property (property="prices_with_sizes", type="array", @OA\Items(
 *                 @OA\Property(property="price_category_size_id", type="integer", example=1),
 *                 @OA\Property(property="size", type="string", example="Something tasty"),
 *                 @OA\Property(property="price", type="integer", example=599)
 *             ))
 *         )
 *    ),
 * )
 *
 * @OA\Put(
 *      path="/menu-items/{menu-item}",
 *      tags={"Admin Menu Items"},
 *      summary="ADMIN Update one of Menu Items",
 *      @OA\Parameter(
 *          description="Menu item id",
 *          in="path",
 *          name="menu-item",
 *          required=true,
 *          example=1,
 *      ),
 *      @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="name", type="string", example="Something tasty"),
 *                      @OA\Property(property="description", type="string", example="Some description"),
 *                      @OA\Property(property="price_category_id", type="integer",example=1),
 *                  )
 *              }
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Menu Item",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="name", type="string", example="Something tasty"),
 *              @OA\Property(property="description", type="string", example="Some description"),
 *              @OA\Property(property="price_category", type="string", example="Some price category"),
 *              @OA\Property (property="prices_with_sizes", type="array", @OA\Items(
 *                  @OA\Property(property="price_category_size_id", type="integer", example=1),
 *                  @OA\Property(property="size", type="string", example="Something tasty"),
 *                  @OA\Property(property="price", type="integer", example=599)
 *              ))
 *          )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found",
 *         @OA\JsonContent(
 *            @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *            @OA\Property(property="message", example="Not Found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="error",  example="Ooops! Looks like something went wrong."),
 *             @OA\Property(property="message", example="Unauthenticated.")
 *         )
 *     ),
 *  )
 *
 * @OA\Delete(
 *       path="/menu-items/{menu-item}",
 *       tags={"Admin Menu Items"},
 *       summary="ADMIN Delete Menu Item",
 *       @OA\Parameter(
 *           description="Menu item id",
 *           in="path",
 *           name="menu-item",
 *           required=true,
 *           example=1,
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Menu Item deleted",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", example="CategorySizePrice deleted successfully")
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
class MenuItemController extends Controller
{
}
