<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuItemCollectionResource extends ResourceCollection
{
    public $collects = MenuItemResource::class;

    /**
     * @param  Request $request
     * @return array<string, string>
     */
    public function toArray(Request $request): array
    {
        return [
            'menuItems' => $this->collection,
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray($request));
    }
}
