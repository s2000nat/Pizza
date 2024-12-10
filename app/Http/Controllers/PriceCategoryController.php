<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePriceCategoryRequest;
use App\Models\PriceCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $priceCategories = PriceCategory::all();

        return response()->json($priceCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePriceCategoryRequest $request): JsonResponse
    {
        $size = PriceCategory::query()->create(['slug' => $request->validated()['slug']]);

        return response()->json($size);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $priceCategory = PriceCategory::query()->findOrFail($id);

        return response()->json($priceCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePriceCategoryRequest $request, string $id): JsonResponse
    {
        $priceCategory = PriceCategory::query()->findOrFail($id);
        $priceCategory->update(['slug' => $request->validated()['slug']]);

        return response()->json($priceCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $priceCategory = PriceCategory::query()->findOrFail($id);
        $priceCategory->delete();

        return response()->json(['message' => 'Price Category deleted successfully']);
    }
}
