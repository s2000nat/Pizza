<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\DTO\ProductDTO;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\CartDetailsCollectionResource;
use App\Http\Services\CartService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();
        $cart = $this->cartService->getCartDetails($user);

        return (new CartDetailsCollectionResource($cart))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $user = auth()->user();

        $productDTO = new ProductDTO(
            menuItemId: $request->validated()['menu_item_id'],
            categorySizePriceId: $request->validated()['category_size_price_id'],
        );

        $this->cartService->addProductToCart($productDTO, $user);
        $cart = $this->cartService->getCartDetails($user);

        return (new CartDetailsCollectionResource($cart))->response()->setStatusCode(Response::HTTP_CREATED);

    }

    public function delete(string $id): JsonResponse
    {
        $user = auth()->user();
        if (!$this->cartService->deleteProductFromCart($id, $user)) {
            return response()->json(
                ['message' => 'Вы не имеете прав для удаления этой корзины.'],
                Response::HTTP_FORBIDDEN,
                [], JSON_UNESCAPED_UNICODE
            );
        }

        return response()->json(
            ['message' => 'Продукт удален успешно из корзины.'],
            Response::HTTP_OK,
            [], JSON_UNESCAPED_UNICODE);
    }

}

