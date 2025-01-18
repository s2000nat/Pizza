<?php

namespace Tests\Feature;

use App\Models\CategorySizePrice;
use App\Models\PriceCategory;
use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategorySizePriceControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_category_size_prices_for_admin(): void
    {
        $categorySizePrice = CategorySizePrice::factory()->create();
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->get('/api/admin/category-size-prices');

        $response->assertOk()
            ->assertJsonFragment([
                'id' => $categorySizePrice->id,
                'size' => $categorySizePrice->size->slug,
                'price_category' => $categorySizePrice->priceCategory->slug,
                'price' => $categorySizePrice->price,
            ]);
    }

    /** @test */
    public function it_returns_forbidden_error_if_user_is_not_admin()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/admin/category-size-prices');

        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJsonFragment([
            'message' => 'Only Admin access.'
        ]);
    }


    /** @test */
    public function it_can_store_category_size_price()
    {
        $size = Size::factory()->create();
        $priceCategory = PriceCategory::factory()->create();
        $data = [
            'price_category_id' => $priceCategory->id,
            'size_id' => $size->id,
            'price' => 100,
        ];
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->post('/api/admin/category-size-prices', $data);
        $response->assertCreated()
            ->assertJson([
                'data' => $data
            ]);
        $this->assertDatabaseHas('category_size_prices', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_store_category_size_price()
    {
        $size = Size::factory()->create();
        $priceCategory = PriceCategory::factory()->create();
        $data = [
            'price_category_id' => $priceCategory->id,
            'size_id' => $size->id,
            'price' => 100,
        ];
        $response = $this->post('/api/admin/category-size-prices', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function it_can_show_category_size_price()
    {
        $categorySizePrice = CategorySizePrice::factory()->create();
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->get('/api/admin/category-size-prices/' . $categorySizePrice->id);
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $categorySizePrice->id,
                'size' => $categorySizePrice->size->slug,
                'price_category' => $categorySizePrice->priceCategory->slug,
                'price' => $categorySizePrice->price,
            ]);
    }

    /** @test */
    public function it_returns_not_found_when_showing_nonexistent_category_size_price()
    {
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->get('/api/ad/category-size-prices/999');

        $response->assertNotFound();
    }

    /** @test */
    public function it_can_update_category_size_price()
    {
        $categorySizePrice = CategorySizePrice::factory()->create();
        $data = [
            'price' => 200,
        ];
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->put('/api/admin/category-size-prices/' . $categorySizePrice->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas('category_size_prices', array_merge(['id' => $categorySizePrice->id], $data));
    }

    /** @test */
    public function it_returns_not_found_when_updating_nonexistent_category_size_price()
    {
        $user = User::factory()->create();
        $data = [
            'price' => 200,
        ];
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->put('/api/admin/category-size-prices/999', $data);
        $response->assertNotFound();
    }

    /** @test */
    public function it_can_delete_category_size_price()
    {
        $categorySizePrice = CategorySizePrice::factory()->create();
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->delete('/api/admin/category-size-prices/' . $categorySizePrice->id);

        $response->assertOk();
        $this->assertModelMissing($categorySizePrice);
    }

    /** @test */
    public function it_returns_not_found_when_deleting_nonexistent_category_size_price()
    {
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->delete('/api/admin/category-size-prices/999');

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Ooops! Looks like something went wrong.',
            'message' => 'Not Found']);
    }
}
