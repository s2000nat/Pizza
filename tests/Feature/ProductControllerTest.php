<?php

use App\Models\CategorySizePrice;
use App\Models\MenuItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['is_admin' => true]);
    }

    /** @test * */
    public function it_can_list_products_for_admin()
    {
        $product = Product::factory()->create();
        $this->actingAs($this->adminUser);

        $response = $this->get('/api/admin/products');
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $product->id,
                'menu_item_id' => $product->menu_item_id]);
    }

    /** @test */
    public function it_returns_forbidden_error_if_user_is_not_admin()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/admin/products');

        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJsonFragment([
            'message' => 'Only Admin access.'
        ]);
    }

    /** @test */
    public function it_can_store_product()
    {
        $menuItem = MenuItem::factory()->create();
        $categorySizePrice = CategorySizePrice::factory()->create();
        $data = [
            'menu_item_id' => $menuItem->id,
            'category_size_price_id' => $categorySizePrice->id,
        ];
        $this->actingAs($this->adminUser);
        $response = $this->post('/api/admin/products', $data);
        $response->assertCreated()
            ->assertJson([
                'menu_item_id' => $menuItem->id,
                'category_size_price_id' => $categorySizePrice->id,
            ]);
        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_store_product()
    {
        $menuItem = MenuItem::factory()->create();
        $categorySizePrice = CategorySizePrice::factory()->create();
        $data = [
            'menu_item_id' => $menuItem->id,
            'category_size_price_id' => $categorySizePrice->id,
        ];
        $response = $this->post('/api/admin/products', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function it_can_show_product()
    {
        $product = Product::factory()->create();
        $this->actingAs($this->adminUser);
        $response = $this->get('/api/admin/products/' . $product->id);
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $product->id,
                'menu_item_id' => $product->menu_item_id,
                'category_size_price_id' => $product->category_size_price_id,
            ]);
    }

    /** @test */
    public function it_returns_not_found_when_showing_nonexistent_product()
    {
        $this->actingAs($this->adminUser);
        $response = $this->get('/api/admin/products/999');

        $response->assertNotFound();
    }

    /** @test */
    public function it_can_update_product()
    {
        $product = Product::factory()->create();
        $menuItem = MenuItem::factory()->create();
        $categorySizePrice = CategorySizePrice::factory()->create();
        $data = [
            'menu_item_id' => $menuItem->id,
            'category_size_price_id' => $categorySizePrice->id,
        ];
        $this->actingAs($this->adminUser);
        $response = $this->put('/api/admin/products/' . $product->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas('products', array_merge(['id' => $product->id], $data));
    }

    /** @test */
    public function it_returns_not_found_when_updating_nonexistent_product()
    {
        $menuItem = MenuItem::factory()->create();
        $categorySizePrice = CategorySizePrice::factory()->create();
        $data = [
            'menu_item_id' => $menuItem->id,
            'category_size_price_id' => $categorySizePrice->id,
        ];
        $this->actingAs($this->adminUser);
        $response = $this->put('/api/admin/products/999', $data);
        $response->assertNotFound();
    }

    /** @test */
    public function it_can_delete_size()
    {
        $product = Product::factory()->create();
        $this->actingAs($this->adminUser);
        $response = $this->delete('/api/admin/products/' . $product->id);

        $response->assertOk();
        $this->assertModelMissing($product);
    }


    /** @test */
    public function it_returns_not_found_when_deleting_nonexistent_size()
    {
        $this->actingAs($this->adminUser);
        $response = $this->delete('/api/admin/products/999');

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Ooops! Looks like something went wrong.',
            'message' => 'Not Found']);
    }
}
