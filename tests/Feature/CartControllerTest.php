<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\CategorySizePrice;
use App\Models\MenuItem;
use App\Models\PriceCategory;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;


    private CategorySizePrice $categorySizePrice;
    private MenuItem $menuItem;
    private Product $product;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $priceCategory = PriceCategory::factory()->create();
        $size = Size::factory()->create();
        $this->categorySizePrice = CategorySizePrice::create([
            'price_category_id' => $priceCategory->id,
            'size_id' => $size->id,
            'price' => 500,
        ]);
        $this->menuItem = MenuItem::create([
            'name' => 'Test Menu Item',
            'description' => 'Test Description',
            'price_category_id' => $priceCategory->id,]);
        $this->product = Product::create(
            [
                'menu_item_id' => $this->menuItem->id,
                'category_size_price_id' => $this->categorySizePrice->id,
            ]
        );
        Cart::query()->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    public function testCanRetrieveCartForAuthenticatedUser(): void
    {

        $this->actingAs($this->user);
        $response = $this->get('/api/cart');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testCannotRetrieveCartForUnauthorizedUser(): void
    {

        $response = $this->get('/api/cart');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCanAddProductToCartForAuthenticatedUser(): void
    {
        $data = [
            'menu_item_id' => $this->menuItem->id,
            'category_size_price_id' => $this->categorySizePrice->id,
        ];
        $this->actingAs($this->user);
        $response = $this->post('/api/cart', $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testCannotAddProductToCartForUnauthorizedUser(): void
    {
        $data = [
            'menu_item_id' => $this->menuItem->id,
            'category_size_price_id' => $this->categorySizePrice->id,
        ];
        $response = $this->post('/api/cart', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCanRemoveProductFromCartForAuthenticatedUser(): void
    {
        $this->actingAs($this->user);
        $response = $this->delete('/api/cart/'. $this->product->id);
        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseEmpty('users_products');
    }

    public function testCannotRemoveProductFromCartForUnauthorizedUser(): void
    {
        $response = $this->delete('/api/cart/'. $this->product->id);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
