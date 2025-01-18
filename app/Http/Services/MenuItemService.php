<?php

namespace App\Http\Services;

use App\Http\DTO\MenuItemDTO;
use App\Models\MenuItem;

class MenuItemService
{
    public function getMenuItem(string $id): MenuItem
    {
        return MenuItem::with(['priceCategory', 'categorySizePrices.size'])->findOrFail($id);
    }

    public function getAllMenuItems(): array|\Illuminate\Database\Eloquent\Collection
    {
        return MenuItem::with(['priceCategory', 'categorySizePrices.size'])->get();
    }

    public function createMenuItem(MenuItemDTO $menuItemDTO): MenuItem
    {

        return MenuItem::create([
            'name' => $menuItemDTO->name,
            'description' => $menuItemDTO->description,
            'price_category_id' => $menuItemDTO->priceCategoryId,
        ]);
    }

    public function updateMenuItem(string $id, MenuItemDTO $menuItemDTO): MenuItem
    {
        $menuItem = MenuItem::findOrFail($id);

        if ($menuItemDTO->name !== null) {
            $menuItem->name = $menuItemDTO->name;
        }
        if ($menuItemDTO->description !== null) {
            $menuItem->description = $menuItemDTO->description;
        }
        if ($menuItemDTO->priceCategoryId !== null) {
            $menuItem->price_category_id = $menuItemDTO->priceCategoryId;
        }
        $menuItem->save();

        return $menuItem;
    }

    public function delete(string $id):void
    {
       $result = MenuItem::destroy($id);
       if ($result === 0)
       {
           throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
       }
    }

}
