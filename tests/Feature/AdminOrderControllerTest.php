<?php

use App\Models\Location;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Helpers\RandomDataGenerator;

class AdminOrderControllerTest extends TestCase
{

    use RefreshDatabase;

    protected User $adminUser;
    protected string $phoneNumber;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['is_admin' => true]);
        $this->phoneNumber = RandomDataGenerator::randomPhoneNumberGenerator();
    }

    /** @test */
    public function it_can_list_products_for_admin()
    {
        $order = Order::factory()->create();
        $this->actingAs($this->adminUser);

        $response = $this->get('/api/admin/orders');
        $response->assertOk();
    }

    /** @test */
    public function it_returns_forbidden_error_if_user_is_not_admin()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/admin/orders');

        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJsonFragment([
            'message' => 'Only Admin access.'
        ]);
    }

    /** @test */
    public function it_can_store_product()
    {
        $location = Location::factory()->create();
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'location_id' => $location->id,
            'phone_number' => $this->phoneNumber,
            'status' => 'pending'
        ];
        $this->actingAs($this->adminUser);
        $response = $this->post('/api/admin/orders', $data);
        $response->assertCreated();
        $this->assertDatabaseHas('orders', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_store_order()
    {
        $location = Location::factory()->create();
        $data = [
            'location_id' => $location->id,
            'phone_number' => $this->phoneNumber,
            'status' => 'pending'
        ];
        $response = $this->post('/api/admin/orders', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function it_can_show_order()
    {
        $order = Order::factory()->create();
        $this->actingAs($this->adminUser);
        $response = $this->get('/api/admin/orders/' . $order->id);
        $response->assertOk();
    }

    /** @test */
    public function it_returns_not_found_when_showing_nonexistent_order()
    {
        $this->actingAs($this->adminUser);
        $response = $this->get('/api/admin/orders/999');

        $response->assertNotFound();
    }

    /** @test */
    public function it_can_update_orders()
    {
        $order = Order::factory()->create();
        $location = Location::factory()->create();
        $data = [
            'location_id' => $location->id,
            'phone_number' => $this->phoneNumber,
            'status' => 'pending'
        ];
        $this->actingAs($this->adminUser);
        $response = $this->put('/api/admin/orders/' . $order->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas('orders', array_merge(['id' => $order->id], $data));
    }

    /** @test */
    public function it_returns_not_found_when_updating_nonexistent_order()
    {
        $location = Location::factory()->create();
        $data = [
            'location_id' => $location->id,
            'phone_number' => $this->phoneNumber,
        ];
        $this->actingAs($this->adminUser);
        $response = $this->put('/api/admin/orders/999', $data);
        $response->assertNotFound();
    }

    /** @test */
    public function it_can_delete_order()
    {
        $order = Order::factory()->create();
        $this->actingAs($this->adminUser);
        $response = $this->delete('/api/admin/orders/' . $order->id);

        $response->assertOk();
        $this->assertModelMissing($order);
    }


    /** @test */
    public function it_returns_not_found_when_deleting_nonexistent_order()
    {
        $this->actingAs($this->adminUser);
        $response = $this->delete('/api/admin/orders/999');

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Ooops! Looks like something went wrong.',
            'message' => 'Not Found']);
    }
}
