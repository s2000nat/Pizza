<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Exceptions\CartLimitException;
use App\Exceptions\WrongPriceCategoryException;
use App\Http\DTO\ProductDTO;
use App\Models\Cart;
use App\Models\CategorySizePrice;
use App\Models\MenuItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


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

    /**
     * @throws WrongPriceCategoryException
     * @throws CartLimitException
     */
    public function addProductToCart(ProductDTO $product, User $user): void
    {
        $category = CategorySizePrice::query()->find($product->categorySizePriceId);
        if (!$this->checkCartLimit($user, $category->price_category_id)) {
            throw new CartLimitException('Достигнут лимит корзины для данной категории.');
        }

        $cart = $user->carts()->with(['product'])->get();
        foreach ($cart as $cartItem) {
            if ($cartItem->product->menu_item_id === $product->menuItemId
                && $cartItem->product->category_size_price_id === $product->categorySizePriceId) {
                $cartItem->quantity += 1;
                $cartItem->save();
                return;
            }
        }
        $existingMenuItem = MenuItem::query()->find($product->menuItemId);
        $existingCategory = CategorySizePrice::query()->find($product->categorySizePriceId);
        if ($existingMenuItem->priceCategory->id !== $existingCategory->priceCategory->id) {
            throw new WrongPriceCategoryException('Цена не соответствует категории продукта.');
        }
        $cartItem = Product::query()->create(
            [
                'menu_item_id' => $product->menuItemId,
                'category_size_price_id' => $product->categorySizePriceId,
            ]
        );
        Cart::query()->create([
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
    }
}
