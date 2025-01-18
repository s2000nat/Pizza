<?php

namespace Tests\Feature;

use App\Models\PriceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PriceCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function it_can_list_price_categories_for_admin()
    {
        $priceCategory = PriceCategory::factory()->create();
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);

        $response = $this->get('/api/admin/price-categories');
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $priceCategory->id,
                'slug' => $priceCategory->slug,]);
    }

    /** @test */

    public function it_returns_forbidden_error_if_user_is_not_admin()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/admin/price-categories');

        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJsonFragment([
            'message' => 'Only Admin access.'
        ]);
    }

    /** @test */
    public function it_can_store_price_category()
    {
        $data = [
            'slug' => 'cheap',
        ];
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->post('/api/admin/price-categories', $data);
        $response->assertCreated()
            ->assertJson([
                'slug' => 'cheap',
            ]);
        $this->assertDatabaseHas('price_categories', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_store_price_category()
    {
        $data = [
            'slug' => 'cheap',
        ];
        $response = $this->post('/api/admin/price-categories', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function it_can_show_price_category()
    {
        $priceCategory = PriceCategory::factory()->create();
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->get('/api/admin/price-categories/' . $priceCategory->id);
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $priceCategory->id,
                'slug' => $priceCategory->slug,
            ]);
    }

    /** @test */
    public function it_returns_not_found_when_showing_nonexistent_price_category()
    {
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->get('/api/ad/price-categories/999');

        $response->assertNotFound();
    }

    /** @test */
    public function it_can_update_price_category()
    {
        $priceCategory = PriceCategory::factory()->create();
        $data = [
            'slug' => 'cheap',
        ];
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->put('/api/admin/price-categories/' . $priceCategory->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas('price_categories', array_merge(['id' => $priceCategory->id], $data));
    }

    /** @test */
    public function it_returns_not_found_when_updating_nonexistent_price_category()
    {
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $data = [
            'slug' => 'cheap',
        ];
        $this->actingAs($user);
        $response = $this->put('/api/admin/price-categories/999', $data);
        $response->assertNotFound();
    }

    /** @test */
    public function it_can_delete_price_category()
    {
        $priceCategory = PriceCategory::factory()->create();
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->delete('/api/admin/price-categories/' . $priceCategory->id);

        $response->assertOk();
        $this->assertModelMissing($priceCategory);
    }


    /** @test */
    public function it_returns_not_found_when_deleting_nonexistent_price_category()
    {
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->delete('/api/admin/price-categories/999');

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Ooops! Looks like something went wrong.',
            'message' => 'Not Found']);
    }
}
