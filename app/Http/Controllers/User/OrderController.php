<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\DTO\OrderDTO;
use App\Http\Requests\CompleteOrderRequest;
use App\Http\Resources\OrdersDetailsCollectionResource;
use App\Http\Resources\PrepareOrderDetailsResource;
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
        $locations = $user->locations;


        return (new PrepareOrderDetailsResource([
            'locations' => $locations,
            'cart' => $cart,
            'user' => $user,
        ]))->response()->setStatusCode(Response::HTTP_CREATED);
    }


    public function completeOrder(CompleteOrderRequest $request): JsonResponse
    {

        $user = $request->user();
        if ($this->cartService->getCartDetails($user)->isEmpty()) {

            return response()->json(['message' => 'Cart is empty.'], Response::HTTP_NO_CONTENT, [], JSON_UNESCAPED_UNICODE);
        }
        $orderDto = new OrderDTO(
            userId: $user->id,
            phoneNumber: $request->validated()['phone_number'],
            locationId: $request->validated()['location_id'],
            status: 'pending',
        );

        $order = $this->orderService->createOrder($orderDto);
        $this->orderService->moveCartItemsToOrder($order, $user);

        return response()->json(['message' => 'Order created successfully.'], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    public function getOwnOrders(): JsonResponse
    {
        $user = auth()->user();
        $orders = $this->orderService->getOrdersDetails($user);

        return (new OrdersDetailsCollectionResource($orders))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
