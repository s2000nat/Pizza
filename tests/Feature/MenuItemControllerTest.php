<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\PriceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MenuItemControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_menu_items()
    {
        $priceCategory = PriceCategory::factory()->create();
        $menuItem = MenuItem::factory()->create(['price_category_id' => $priceCategory->id]);
        $response = $this->get('/api/menu-items');
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'description' => $menuItem->description,
                'price_category' => $priceCategory->slug
            ]);
    }

    /** @test */
    public function it_can_store_menu_item()
    {
        $priceCategory = PriceCategory::factory()->create();
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $data = [
            'name' => 'Pizza',
            'description' => 'This is a test item description.',
            'price_category_id' => $priceCategory->id,
        ];
        $response = $this->post('/api/admin/menu-items', $data);
        $this->assertDatabaseHas('menu_items', $data);
        $response->assertCreated()->assertJson([
            'name' => 'Pizza',
            'description' => 'This is a test item description.',
        ]);
    }

    /** @test */
    public function unauthorized_user_cannot_store_menu_item()
    {
        $priceCategory = PriceCategory::factory()->create();
        $data = [
            'name' => 'Pizza',
            'description' => 'This is a test item description.',
            'price_category_id' => $priceCategory->id,
        ];
        $response = $this->post('/api/admin/sizes', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function it_can_display_a_menu_item()
    {
        $priceCategory = PriceCategory::factory()->create();
        $menuItem = MenuItem::factory()->create(['price_category_id' => $priceCategory->id]);

        $response = $this->getJson('/api/menu-items/' . $menuItem->id);

        $response->assertOk();
        $response->assertJson([
            'id' => $menuItem->id,
            'name' => $menuItem->name,
            'description' => $menuItem->description,
            'price_category' => $priceCategory->slug,
        ]);
    }

    /** @test */
    public function it_fails_to_display_nonexistent_menu_item()
    {
        $response = $this->getJson('/api/menu-items/999');

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Ooops! Looks like something went wrong.',
            'message' => 'Not Found'
        ]);
    }

    /** @test */
    public function it_can_update_a_menu_item()
    {
        $priceCategory = PriceCategory::factory()->create();
        $menuItem = MenuItem::factory()->create(['price_category_id' => $priceCategory->id]);
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $data = [
            'name' => 'Updated Menu Item',
            'description' => 'This is an updated description.',
            'price_category_id' => $priceCategory->id,
        ];

        $response = $this->putJson('/api/admin/menu-items/' . $menuItem->id, $data);

        $response->assertOk();
        $this->assertDatabaseHas('menu_items', array_merge(['id' => $menuItem->id], $data));
    }

    /** @test */
    public function it_fails_to_update_menu_item_with_invalid_data()
    {
        $priceCategory = PriceCategory::factory()->create();
        $menuItem = MenuItem::factory()->create(['price_category_id' => $priceCategory->id]);
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $data = [
            'name' => '',
            'description' => 'Short',
            'price_category_id' => 999,
        ];

        $response = $this->put('/api/admin/menu-items/' . $menuItem->id, $data);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name', 'price_category_id']);
    }

    /** @test */
    public function it_can_destroy_a_menu_item()
    {
        $priceCategory = PriceCategory::factory()->create();
        $menuItem = MenuItem::factory()->create(['price_category_id' => $priceCategory->id]);
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->delete('/api/admin/menu-items/' . $menuItem->id);

        $response->assertOk();
        $this->assertDatabaseMissing('menu_items', ['id' => $menuItem->id]);
    }

    /** @test */
    public function it_fails_to_destroy_nonexistent_menu_item()
    {
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);

        $response = $this->delete('/api/admin/menu-items/999'); // Используем несуществующий ID

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Ooops! Looks like something went wrong.',
            'message' => 'Not Found'
        ]);
    }
}
