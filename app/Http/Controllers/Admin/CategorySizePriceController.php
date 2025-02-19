<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategorySizePriceRequest;
use App\Http\Requests\UpdateCategorySizePriceRequest;
use App\Models\CategorySizePrice;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategorySizePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $priceCategorySizes = CategorySizePrice::with(['size', 'priceCategory'])->get();

        $response = $priceCategorySizes->map(
            function (CategorySizePrice $priceCategorySize) {
                return [
                'id' => $priceCategorySize->id,
                'size' => $priceCategorySize->size->slug,
                'price_category' => $priceCategorySize->priceCategory->slug,
                'price' => $priceCategorySize->price,
                ];
            }
        );

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategorySizePriceRequest $request): JsonResponse
    {
        $categorySizePrice = CategorySizePrice::query()->create($request->validated());

        return response()->json(
            [
            'data' => $categorySizePrice,
            ], Response::HTTP_CREATED
        );

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $categorySizePrice = CategorySizePrice::with(['size', 'priceCategory'])->findOrFail($id);

        return response()->json(
            [
            'id' => $categorySizePrice->id,
            'size' => $categorySizePrice->size->slug,
            'price_category' => $categorySizePrice->priceCategory->slug,
            'price' => $categorySizePrice->price,
            ], Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorySizePriceRequest $request, string $id): JsonResponse
    {
        $categorySizePrice = CategorySizePrice::query()->findOrFail($id);
        $categorySizePrice->update($request->validated());

        return response()->json($categorySizePrice, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $categorySizePrice = CategorySizePrice::query()->find($id);
        if (!$categorySizePrice) {
            throw new NotFoundHttpException();
        }

        $categorySizePrice->delete();

        return response()->json(
            [
            'message' => 'CategorySizePrice deleted successfully',
            ], Response::HTTP_OK
        );

    }
}
