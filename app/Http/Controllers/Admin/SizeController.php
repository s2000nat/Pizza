<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSizeRequest;
use App\Models\Size;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $sizes = Size::all();

        return response()->json($sizes, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSizeRequest $request): JsonResponse
    {
        $size = Size::query()->create(['slug' => $request->validated()['slug']]);

        return response()->json($size, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $size = Size::query()->findOrFail($id);

        return response()->json($size, Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSizeRequest $request, string $id): JsonResponse
    {

        $size = Size::query()->findOrFail($id);
        $size->update(['slug' => $request->validated()['slug']]);

        return response()->json($size, Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {

        $size = Size::query()->findOrFail($id);
        $size->delete();

        return response()->json(['message' => 'Size deleted successfully.'], Response::HTTP_OK);

    }
}
