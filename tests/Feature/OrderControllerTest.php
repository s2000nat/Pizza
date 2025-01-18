<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\CategorySizePrice;
use App\Models\Location;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PriceCategory;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;


    private CategorySizePrice $categorySizePrice;
    private MenuItem $menuItem;
    private Product $product;
    private Location $location;
    private Order $order;

    private Cart $cart;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $priceCategory = PriceCategory::factory()->create();
        $size = Size::factory()->create();
        $this->location = Location::factory()->create(['user_id' => $this->user->id]);
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
        $this->cart = Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $this->order = Order::create([
            'user_id' => $this->user->id,
            'phone_number' => $this->user->phone_number,
            'location_id' => $this->location->id,
            'status' => 'pending'
        ]);
        OrderProduct::create([
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);
    }

    public function testCanRetrieveOrderForAuthenticatedUser(): void
    {

        $this->actingAs($this->user);
        $response = $this->get('/api/orders');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testCannotRetrieveOrderForUnauthorizedUser(): void
    {
        $response = $this->get('/api/orders');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCanCompleteOrderForAuthenticatedUser(): void
    {
        $data = [
            'phone_number' => $this->user->phone_number,
            'location_id' => $this->location->id,
        ];
        $this->actingAs($this->user);
        $response = $this->post('/api/orders', $data);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('orders', $data);
        $this->assertDatabaseHas('orders_products', ['order_id' => $this->order->id,
            'product_id' => $this->product->id,]);
        $this->assertDatabaseEmpty('users_products');

    }

    public function testCannotCompleteOrderWithEmptyCart(): void
    {
        $this->cart->delete();
        $data = [
            'phone_number' => $this->user->phone_number,
            'location_id' => $this->location->id,
        ];
        $this->actingAs($this->user);
        $response = $this->post('/api/orders', $data);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $this->assertDatabaseEmpty('users_products');
    }

    public function testCanListOwnOrdersForAuthenticatedUser(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/api/own-orders/');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testCannotListOwnOrdersForUnauthorizedUser(): void
    {

        $response = $this->get('/api/own-orders/');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    }
}
