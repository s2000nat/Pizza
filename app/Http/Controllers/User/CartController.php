<?php

namespace App\Http\Controllers\User;

use App\Exceptions\CartLimitException;
use App\Exceptions\WrongPriceCategoryException;
use App\Http\Controllers\Controller;
use App\Http\DTO\ProductDTO;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\CartCollectionResource;
use App\Http\Services\CartService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            throw new AuthorizationException();
        }
        $cart = $this->cartService->getCartDetails($user);

        return (new CartCollectionResource($cart))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @throws CartLimitException
     * @throws WrongPriceCategoryException
     * @throws AuthorizationException
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            throw new AuthorizationException();
        }

        $productDTO = new ProductDTO(
            menuItemId: $request->validated()['menu_item_id'],
            categorySizePriceId: $request->validated()['category_size_price_id'],
        );

        $this->cartService->addProductToCart($productDTO, $user);
        $cart = $this->cartService->getCartDetails($user);

        return (new CartCollectionResource($cart))->response()->setStatusCode(Response::HTTP_CREATED);

    }

    public function delete(string $id): JsonResponse
    {
        $user = auth()->user();
        if (!$this->cartService->deleteProductFromCart((int)$id, $user)) {
            throw new AccessDeniedException('No privilege to delete another cart product.');
        }

        return response()->json(
            ['message' => 'Продукт удален успешно из корзины.'],
            Response::HTTP_OK,
            [], JSON_UNESCAPED_UNICODE
        );
    }

}

