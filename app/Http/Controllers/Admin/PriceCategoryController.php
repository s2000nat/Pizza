<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePriceCategoryRequest;
use App\Models\PriceCategory;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PriceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $priceCategories = PriceCategory::all();

        return response()->json($priceCategories, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePriceCategoryRequest $request): JsonResponse
    {
        $priceCategory = PriceCategory::create(['slug' => $request->validated()['slug']]);

        return response()->json($priceCategory, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $priceCategory = PriceCategory::query()->findOrFail($id);

        return response()->json($priceCategory, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePriceCategoryRequest $request, string $id): JsonResponse
    {
        $priceCategory = PriceCategory::query()->findOrFail($id);
        $priceCategory->update(['slug' => $request->validated()['slug']]);

        return response()->json($priceCategory, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $priceCategory = PriceCategory::query()->findOrFail($id);
        $priceCategory->delete();

        return response()->json(['message' => 'Price Category deleted successfully'],Response::HTTP_OK);
    }
}
