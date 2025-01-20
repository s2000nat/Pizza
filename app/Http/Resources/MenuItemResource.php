<?php

namespace App\Http\Resources;

use App\Models\PriceCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property PriceCategory $priceCategory
 * @property mixed $categorySizePrices
 */
class MenuItemResource extends JsonResource
{

    /**
     * @param  Request $request
     * @return array<string, string>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price_category' => $this->priceCategory->slug,
            'prices_with_sizes' => $this->categorySizePrices->map(
                function ($categorySizePrice) {
                    return [
                    'price_category_size_id' => $categorySizePrice->id,
                    'size' => $categorySizePrice->size->slug,
                    'price' => $categorySizePrice->price,
                    ];
                }
            )
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray($request));
    }
}
