<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\DTO\ProductDTO;
use App\Models\Cart;
use App\Models\CategorySizePrice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;


class CartService
{
    private function checkCartLimit(User $user, int $categoryId): bool
    {
        $cart = $user->cartProducts()->with(['categorySizePrice'])->get();
        if (in_array($categoryId, [1, 2, 3])) {
            $countPizzas = $cart->filter(function (Product $product) {
                return in_array($product->categorySizePrice->price_category_id, [1, 2, 3]);
            })->count();

            return $countPizzas < 10;
        } elseif (in_array($categoryId, [4, 5, 6])) {
            $countDrinks = $cart->filter(function (Product $product) {
                return in_array($product->categorySizePrice->price_category_id, [4, 5, 6]);
            })->count();

            return $countDrinks < 20;
        }

        return false;
    }


    private function checkCartUserIsRequestUser(User $user, Cart $cart): bool
    {

        return $user->id === $cart->user->id;
    }

    public function addProductToCart(ProductDTO $product, User $user): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        $category = CategorySizePrice::query()->find($product->categorySizePriceId);
        if (!$this->checkCartLimit($user, $category->price_category_id)) {
            throw new \Exception('Достигнут лимит корзины для данной категории.');
        }

        $cart = $user->carts()->with(['product'])->get();
        foreach ($cart as $cartItem) {
            if ($cartItem->product->menu_item_id === $product->menuItemId
                && $cartItem->product->category_size_price_id === $product->categorySizePriceId) {
                $cartItem->quantity += 1;
                $cartItem->save();

                return $cartItem;
            }
        }
        $cartItem = Product::query()->create(
            [
                'menu_item_id' => $product->menuItemId,
                'category_size_price_id' => $product->categorySizePriceId,
            ]
        );

        return Cart::query()->create([
            'user_id' => $user->id,
            'product_id' => $cartItem->id,
        ]);
    }


    public function deleteProductFromCart(int $id, User $user): bool
    {
        $cart = Cart::query()->findOrFail($id);
        if ($this->checkCartUserIsRequestUser($user, $cart)) {
            $cart->delete();

            return true;
        }

        return false;
    }

    public function getCartDetails(User $user): Collection
    {
        return $user->carts()->with(['product.menuItem', 'product.categorySizePrice', 'product.categorySizePrice.size'])->get();

        return ['cart_items' => $cart->map(function (Cart $cartItem) {
            return [
                'id' => $cartItem->product->id,
                'product_name' => $cartItem->product->menuItem->name,
                'product_size' => $cartItem->product->categorySizePrice->size->slug,
                'price' => $cartItem->product->categorySizePrice->price,
                'quantity' => $cartItem->quantity,
            ];
        }), 'total_price' => $cart->sum(function (Cart $cartItem) {
            return $cartItem->product->categorySizePrice->price * $cartItem->quantity;
        })];
    }
}
