<?php

namespace Tests\Feature;

use App\Models\CategorySizePrice;
use App\Models\PriceCategory;
use App\Models\Size;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorySizePriceControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_category_size_prices()
    {
        // Подготовка данных
        $categorySizePrice = CategorySizePrice::factory()->create();

        // Запрос к маршруту index
        $response = $this->get('/api/category-size-prices');

        // Проверка ответа
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $categorySizePrice->id,
                'size' => $categorySizePrice->size->slug,
                'price_category' => $categorySizePrice->priceCategory->slug,
                'price' => $categorySizePrice->price,
            ]);
    }

    /** @test */
    public function it_can_store_category_size_price()
    {
        $size = Size::factory()->create();
        $priceCategory = PriceCategory::factory()->create();
        $data = [
            'price_category_id' =>$priceCategory->id,
            'size_id' =>  $size->id,
            'price' => 100,
        ];
        $response = $this->post('/api/category-size-prices', $data);
        $response->assertCreated()
            ->assertJson([
                'message' => 'Record created successfully!',
            ]);
        $this->assertDatabaseHas('category_size_prices', $data);
    }

    /** @test */
    public function it_can_show_category_size_price()
    {
        // Подготовка данных
        $categorySizePrice = CategorySizePrice::factory()->create();

        // Запрос к маршруту show
        $response = $this->get('/api/category-size-prices/' . $categorySizePrice->id);

        // Проверка ответа
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
        // Запрос к маршруту show с несуществующим ID
        $response = $this->get('/api/category-size-prices/999');

        // Проверка ответа
        $response->assertNotFound();
    }

    /** @test */
    public function it_can_update_category_size_price()
    {
        // Подготовка данных
        $categorySizePrice = CategorySizePrice::factory()->create();
        $data = [
            'price' => 200,
        ];

        // Запрос на обновление
        $response = $this->put('/api/category-size-prices/' . $categorySizePrice->id, $data);

        // Проверка ответа
        $response->assertOk();
        $this->assertDatabaseHas('category_size_prices', array_merge(['id' => $categorySizePrice->id], $data));
    }

    /** @test */
    public function it_returns_not_found_when_updating_nonexistent_category_size_price()
    {
        $response = $this->put('/api/category-size-prices/999', []);
        $response->assertNotFound();
    }

    /** @test */
    public function it_can_delete_category_size_price()
    {
        $categorySizePrice = CategorySizePrice::factory()->create();

        $response = $this->delete('/api/category-size-prices/' . $categorySizePrice->id);

        $response->assertOk();
        $this->assertModelMissing($categorySizePrice);
    }

    /** @test */
    public function it_returns_not_found_when_deleting_nonexistent_category_size_price()
    {
        $response = $this->delete('/api/category-size-prices/999');

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Что-то пошло не так.',
            'message' => 'Ресурс не найден.']);
    }
}
