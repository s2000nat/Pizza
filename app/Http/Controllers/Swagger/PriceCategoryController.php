<?php

declare(strict_types=1);

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;


/**
 * @OA\Tag(
 *     name="Price Categories",
 *     description="Operations related to price categories"
 * )
*/

/**
 * @OA\Get(
 *     path="/admin/price-categories",
 *     tags={"Price Categories"},
 *     summary="Get a list of price categories",
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="A list of price categories",
 *         @OA\JsonContent(
 *                  type="array", @OA\Items(
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="slug", type="string", example="Some price category"),
 *                  @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-14T17:16:28.000000Z", description="ISO 8601 Date-Time"),
 *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-14T17:16:28.000000Z", description="ISO 8601 Date-Time"),
 *              )
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
 */
class PriceCategoryController extends Controller
{
}
