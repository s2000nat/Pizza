<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\DTO\OrderDTO;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;


class OrderService
{

    public function createOrder(OrderDTO $order): Order
    {
        $location = Location::find($order->locationId);

        if (!$location || $location->deleted || $location->user_id !== $order->userId) {
            throw new InvalidArgumentException('User ID does not match the location user ID.');
        }

        $newOrder = Order::create([
            'user_id' => $order->userId,
            'phone_number' => $order->phoneNumber,
            'location_id' => $order->locationId,
            'status' => $order->status,
        ]);


        return $newOrder;
    }

    public function moveCartItemsToOrder(Order $order, User $user): void
    {
        $carts = $user->cartProducts;
        if ($carts->isEmpty()) {
            return;
        }
        foreach ($carts as $cart) {
            OrderProduct::query()->create([
                'product_id' => $cart->id,
                'order_id' => $order->id,
                'quantity' => $cart->pivot->quantity,
            ]);
        }
        $user->carts()->delete();
    }

    public function getOrdersDetails(User $user): Collection
    {
        return $user->orders()->with([
            'orderProduct.product.categorySizePrice',
            'orderProduct.product.menuItem'
        ])->get();
    }

    public function getAllOrdersDetails(): Collection
    {
        return Order::with(['orderProduct.product.categorySizePrice',
            'orderProduct.product.menuItem'
        ])->get();
    }
}
