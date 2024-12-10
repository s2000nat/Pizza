<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\PriceCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_menu_item()
    {

        $priceCategory = PriceCategory::factory()->create();
        $data = [
            'name' => 'TestName',
            'description' => 'This is a test item description.',
            'price_category_id' => $priceCategory->id,
        ];
        $response = $this->post('/api/menu-items', $data);
        $this->assertDatabaseHas('menu_items', $data);
        $response->assertCreated()->assertJson([
            'message' => 'Record created successfully!',
            'data' => [
                'name' => 'TestName',
                'description' => 'This is a test item description.',
                'price_category_id' => $priceCategory->id,
            ]
        ]);
    }

    /** @test */
    public function it_fails_to_store_menu_item_without_required_fields()
    {
        $data = [];

        $response = $this->postJson('/api/menu-items', $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name', 'description', 'price_category_id']);
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
            'error' => 'Что-то пошло не так.',
            'message' => 'Ресурс не найден.'
        ]);
    }

    /** @test */
    public function it_can_update_a_menu_item()
    {
        $priceCategory = PriceCategory::factory()->create();
        $menuItem = MenuItem::factory()->create(['price_category_id' => $priceCategory->id]);

        $data = [
            'name' => 'Updated Menu Item',
            'description' => 'This is an updated description.',
            'price_category_id' => $priceCategory->id,
        ];

        $response = $this->putJson('/api/menu-items/' . $menuItem->id, $data);

        $response->assertOk();
        $this->assertDatabaseHas('menu_items', array_merge(['id' => $menuItem->id], $data));
    }

    /** @test */
    public function it_fails_to_update_menu_item_with_invalid_data()
    {
        $priceCategory = PriceCategory::factory()->create();
        $menuItem = MenuItem::factory()->create(['price_category_id' => $priceCategory->id]);

        $data = [
            'name' => '',
            'description' => 'Short',
            'price_category_id' => 999,
        ];

        $response = $this->putJson('/api/menu-items/' . $menuItem->id, $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name', 'description', 'price_category_id']);
    }

    /** @test */
    public function it_can_destroy_a_menu_item()
    {
        $priceCategory = PriceCategory::factory()->create();
        $menuItem = MenuItem::factory()->create(['price_category_id' => $priceCategory->id]);

        $response = $this->deleteJson('/api/menu-items/' . $menuItem->id);

        $response->assertNoContent();
        $this->assertDatabaseMissing('menu_items', ['id' => $menuItem->id]);
    }

    /** @test */
    public function it_fails_to_destroy_nonexistent_menu_item()
    {
        $response = $this->deleteJson('/api/menu-items/999'); // Используем несуществующий ID

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Что-то пошло не так.',
            'message' => 'Ресурс не найден.'
        ]);
    }
}
