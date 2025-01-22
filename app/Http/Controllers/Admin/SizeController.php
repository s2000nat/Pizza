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
    public function index(): JsonResponse
    {
        $sizes = Size::all();

        return response()->json($sizes, Response::HTTP_OK);
    }

    public function store(StoreSizeRequest $request): JsonResponse
    {
        $size = Size::query()->create(['slug' => $request->validated()['slug']]);

        return response()->json($size, Response::HTTP_CREATED);
    }

    public function show(string $id): JsonResponse
    {
        $size = Size::query()->findOrFail($id);

        return response()->json($size, Response::HTTP_OK);

    }

    public function update(StoreSizeRequest $request, string $id): JsonResponse
    {

        $size = Size::query()->findOrFail($id);
        $size->update(['slug' => $request->validated()['slug']]);

        return response()->json($size, Response::HTTP_OK);

    }

    public function destroy(string $id): JsonResponse
    {

        $size = Size::query()->findOrFail($id);
        $size->delete();

        return response()->json(['message' => 'Size deleted successfully.'], Response::HTTP_OK);

    }
}
