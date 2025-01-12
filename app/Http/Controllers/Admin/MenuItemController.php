<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $menuItems = MenuItem::with(['priceCategory', 'categorySizePrices.size'])->get();
        $response = $menuItems->map(function (MenuItem $menuItem) {
            return [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'description' => $menuItem->description,
                'price_category' => $menuItem->priceCategory->slug,
                'prices_with_sizes' => $menuItem->getPricesWithSizes(),
            ];
        });

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuItemRequest $request): JsonResponse
    {
        $menuItem = MenuItem::query()->create($request->validated());

        return response()->json([
            'message' => 'Record created successfully!',
            'data' => $menuItem,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $menuItem = MenuItem::with(['priceCategory', 'categorySizePrices.size'])->findOrFail($id);

        return response()->json([
            'id' => $menuItem->id,
            'name' => $menuItem->name,
            'description' => $menuItem->description,
            'price_category' => $menuItem->priceCategory->slug,
            'prices_with_sizes' => $menuItem->getPricesWithSizes(),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuItemRequest $request, string $id): JsonResponse
    {
        $menuItem = MenuItem::query()->findOrFail($id);
        $menuItem->update($request->validated());

        return response()->json([
            'id' => $menuItem->id,
            'name' => $menuItem->name,
            'description' => $menuItem->description,
            'price_category' => $menuItem->priceCategory->slug,
            'prices_with_sizes' => $menuItem->getPricesWithSizes(),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $menuItem = MenuItem::query()->find($id);
        if (!$menuItem) {
            return response()->json([
                'error' => 'Что-то пошло не так.',
                'message' => 'Ресурс не найден.'
            ], Response::HTTP_NOT_FOUND);
        }
        $menuItem->delete();

        return response()->json(['message' => 'CategorySizePrice deleted successfully'], 204);
    }
}
