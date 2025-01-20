<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Exceptions\EmptyCartException;
use App\Http\Controllers\Controller;
use App\Http\DTO\OrderDTO;
use App\Http\Requests\CompleteOrderRequest;
use App\Http\Resources\CartCollectionResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\OrdersCollectionResource;
use App\Http\Resources\UserResource;
use App\Http\Services\CartService;
use App\Http\Services\OrderService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class OrderController extends Controller
{
    protected CartService $cartService;
    protected OrderService $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();
        $cart = $this->cartService->getCartDetails($user);
        $locations = $user->locations()->where('deleted', false)->get();

        return response()->json(
            [
            'user' => new UserResource($user),
            'locations' => LocationResource::collection($locations),
            'cart' => new CartCollectionResource($cart),

            ]
        )->setStatusCode(Response::HTTP_OK);
    }


    /**
     * @throws EmptyCartException
     */
    public function completeOrder(CompleteOrderRequest $request): JsonResponse
    {
        $user = $request->user();
        if ($this->cartService->getCartDetails($user)->isEmpty()) {
            throw new EmptyCartException('Your cart is empty.');
        }
        $orderDto = new OrderDTO(
            userId: $user->id,
            phoneNumber: $request->validated()['phone_number'],
            locationId: $request->validated()['location_id'],
            status: 'pending',
        );

        $order = $this->orderService->createOrder($orderDto);
        $this->orderService->moveCartItemsToOrder($order, $user);

        return response()->json(['message' => 'Order created successfully.'], Response::HTTP_CREATED, [], JSON_UNESCAPED_UNICODE);
    }

    public function getOwnOrders(): JsonResponse
    {
        $user = auth()->user();
        $orders = $this->orderService->getOrdersDetails($user);

        return (new OrdersCollectionResource($orders))->response()->setStatusCode(Response::HTTP_OK);
    }
}
