<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CompleteOrderRequest;
use App\Http\Services\CartService;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderProduct;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends Controller

{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function getCartAndLocations(): JsonResponse
    {
        $user = auth()->user();

        $cart = $this->cartService->getCartDetails($user);

        $locations = $user->locations;

        $locationDetails = $locations->map(function (Location $location) {
            return [
                'id' => $location->id,
                'city' => $location->city,
                'street' => $location->street,
                'house_number' => $location->house_number,
                'floor' => $location->floor,
                'apartment' => $location->apartment,
            ];
        });

        return response()->json([
            'cart' => $cart,
            'locations' => $locationDetails ,
            'phone_number'=>$user->phone_number,
        ], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }


    public function completeOrder(CompleteOrderRequest $request): JsonResponse
    {

        $user = $request->user();
        $order = Order::query()->create(['user_id' => $user->id,
            'phone_number' => $request->validated()['phone_number'],
            'location_id' => $request->validated()['location_id'],
            'status' => 'pending',
        ]);

        $carts = $user->cartProducts;
        foreach ($carts as $cart) {
            OrderProduct::query()->create([
                'product_id_FK' => $cart->product_id,
                'order_id_FK' => $order->id,
            ]);
        }
        foreach ($carts as $cart) {
            $cart->delete();
        }

        return response()->json(['message'=>'Order created successfully.'], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    public function getOwnOrders(): JsonResponse
    {
        $user = auth()->user();

        $orders = $user->orders;

        $orderDetails = $orders->map(function (Order $order) {
            return [
                'id' => $order->id,
                'status' => $order->status,
            ];
        });
        return response()->json(['message'=> $orderDetails ], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }
}
