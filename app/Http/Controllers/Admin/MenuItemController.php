<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\DTO\MenuItemDTO;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Http\Resources\MenuItemCollectionResource;
use App\Http\Resources\MenuItemResource;
use App\Http\Services\MenuItemService;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class MenuItemController extends Controller
{

    public function __construct(protected MenuItemService $menuItemService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $menuItems = $this->menuItemService->getAllMenuItems();

        return (new MenuItemCollectionResource($menuItems))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuItemRequest $request): JsonResponse
    {

        $menuItemDTO = new MenuItemDTO(
            name:$request->validated()['name'],
            description:$request->validated()['description'],
            priceCategoryId: $request->validated()['price_category_id'],
        );

        $menuItem = $this->menuItemService->createMenuItem($menuItemDTO);
        return (new MenuItemResource($menuItem))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(string $id): JsonResponse
    {
        $menuItem =  $this->menuItemService->getMenuItem($id);

        return (new MenuItemResource($menuItem))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuItemRequest $request, string $id): JsonResponse
    {
        $menuItemDTO = new MenuItemDTO(
            name:$request->validated()['name'],
            description:$request->validated()['description'],
            priceCategoryId: $request->validated()['price_category_id'],
        );
        $menuItem = $this->menuItemService->updateMenuItem($id, $menuItemDTO);
        return (new MenuItemResource($menuItem))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->menuItemService->delete($id);

        return response()->json(['message' => 'CategorySizePrice deleted successfully'], Response::HTTP_OK);
    }
}
