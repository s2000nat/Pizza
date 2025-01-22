<?php
//
//declare(strict_types=1);
//
//namespace App\Http\Controllers\Swagger;
//
//use App\Http\Controllers\Controller;
//use App\Http\Requests\StoreSizeRequest;
//use App\Models\Size;
//use Illuminate\Http\JsonResponse;
//use Symfony\Component\HttpFoundation\Response;
//
///**
// * @OA\Tag(name="Sizes", description="API for managing sizes")
// */
//class SizeController extends Controller
//{
//    /**
//     * @OA\Get(
//     *     path="/api/sizes",
//     *     tags={"Sizes"},
//     *     summary="Get all sizes",
//     *     @OA\Response(
//     *         response=200,
//     *         description="A list of sizes",
//     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Size"))
//     *     )
//     * )
//     */
//    public function index(): JsonResponse
//    {
//        $sizes = Size::all();
//
//        return response()->json($sizes, Response::HTTP_OK);
//    }
//
//    /**
//     * @OA\Post(
//     *     path="/api/sizes",
//     *     tags={"Sizes"},
//     *     summary="Create a new size",
//     *     @OA\RequestBody(
//     *         required=true,
//     *         @OA\JsonContent(ref="#/components/schemas/StoreSizeRequest")
//     *     ),
//     *     @OA\Response(
//     *         response=201,
//     *         description="Size created successfully",
//     *         @OA\JsonContent(ref="#/components/schemas/Size")
//     *     ),
//     *     @OA\Response(
//     *         response=422,
//     *         description="Validation error"
//     *     )
//     * )
//     */
//    public function store(StoreSizeRequest $request): JsonResponse
//    {
//        $size = Size::query()->create(['slug' => $request->validated()['slug']]);
//
//        return response()->json($size, Response::HTTP_CREATED);
//    }
//
//    /**
//     * @OA\Get(
//     *     path="/api/sizes/{id}",
//     *     tags={"Sizes"},
//     *     summary="Get a specific size",
//     *     @OA\Parameter(
//     *         name="id",
//     *         required=true,
//     *         in="path",
//     *         description="ID of the size",
//     *         @OA\Schema(type="string")
//     *     ),
//     *     @OA\Response(
//     *         response=200,
//     *         description="Details of the size",
//     *         @OA\JsonContent(ref="#/components/schemas/Size")
//     *     ),
//     *     @OA\Response(
//     *         response=404,
//     *         description="Size not found"
//     *     )
//     * )
//     */
//    public function show(string $id): JsonResponse
//    {
//        $size = Size::query()->findOrFail($id);
//
//        return response()->json($size, Response::HTTP_OK);
//    }
//
//    /**
//     * @OA\Put(
//     *     path="/api/sizes/{id}",
//     *     tags={"Sizes"},
//     *     summary="Update an existing size",
//     *     @OA\Parameter(
//     *         name="id",
//     *         required=true,
//     *         in="path",
//     *         description="ID of the size",
//     *         @OA\Schema(type="string")
//     *     ),
//     *     @OA\RequestBody(
//     *         required=true,
//     *         @OA\JsonContent(ref="#/components/schemas/StoreSizeRequest")
//     *     ),
//     *     @OA\Response(
//     *         response=200,
//     *         description="Size updated successfully",
//     *         @OA\JsonContent(ref="#/components/schemas/Size")
//     *     ),
//     *     @OA\Response(
//     *         response=422,
//     *         description="Validation error"
//     *     )
//     * )
//     */
//    public function update(StoreSizeRequest $request, string $id): JsonResponse
//    {
//
//        $size = Size::query()->findOrFail($id);
//        $size->update(['slug' => $request->validated()['slug']]);
//
//        return response()->json($size, Response::HTTP_OK);
//
//    }
//
//    /**
//     * @OA\Delete(
//     *     path="/api/sizes/{id}",
//     *     tags={"Sizes"},
//     *     summary="Delete a specific size",
//     *     @OA\Parameter(
//     *         name="id",
//     *         required=true,
//     *         in="path",
//     *         description="ID of the size",
//     *         @OA\Schema(type="string")
//     *     ),
//     *     @OA\Response(
//     *         response=200,
//     *         description="Size deleted successfully",
//     *     ),
//     *     @OA\Response(
//     *         response=404,
//     *         description="Size not found"
//     *     )
//     * )
//     */
//    public function destroy(string $id): JsonResponse
//    {
//
//        $size = Size::query()->findOrFail($id);
//        $size->delete();
//
//        return response()->json(['message' => 'Size deleted successfully.'], Response::HTTP_OK);
//    }
//}
///**
// * @OA\Schema(
// *     schema="Size",
// *     type="object",
// *     required={"slug"},
// *     @OA\Property(property="id", type="integer", description="Size ID"),
// *     @OA\Property(property="slug", type="string", description="Unique slug of the size")
// * )
// */
//
///**
// * @OA\Schema(
// *     schema="StoreSizeRequest",
// *     type="object",
// *     required={"slug"},
// *     @OA\Property(property="slug", type="string", description="Unique slug of the size")
// * )
// */
