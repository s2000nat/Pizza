<?php

namespace App\Http\Controllers\User\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LocationController extends Controller
{
    /**
     * Получить список всех локаций.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $locations = Location::all();

        return response()->json($locations);
    }

    /**
     * Создать новую локацию.
     *
     * @param StoreLocationRequest $request
     * @return JsonResponse
     */
    public function store(StoreLocationRequest $request): JsonResponse
    {
        $location = Location::query()->create($request->validated());

        return response()->json($location, Response::HTTP_CREATED);
    }

    /**
     * Получить конкретную локацию.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $location = Location::query()->findOrFail($id);

        return response()->json($location);
    }

    /**
     * Обновить существующую локацию.
     *
     * @param UpdateLocationRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateLocationRequest $request,string $id): JsonResponse
    {
        $location = Location::query()->findOrFail($id);
        $location->update($request->validated());

        return response()->json($location);
    }

    /**
     * Удалить локацию.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $location = Location::query()->findOrFail($id);
        $location->delete();

        return response()->json(['message' => 'Location deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
