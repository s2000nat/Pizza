<?php

use App\Models\User;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['is_admin' => true]);
    }

    /** @test * */
    public function it_can_list_locations_for_admin()
    {
        $location = Location::factory()->create();
        $this->actingAs($this->adminUser);

        $response = $this->get('/api/admin/locations');
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $location->id,
                'city' => $location->city,
                'street' => $location->street,
                'house_number' => $location->house_number,
                'floor' => $location->floor,
                'apartment' => $location->apartment]);
    }

    /** @test */
    public function it_returns_forbidden_error_if_user_is_not_admin()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/admin/locations');

        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJsonFragment([
            'message' => 'Only Admin access.'
        ]);
    }

    /** @test */
    public function it_can_store_locations()
    {
        $user = User::factory()->create();
        $data = [
            'city' => 'Moscow',
            'street' => 'Kirova',
            'house_number' => '12',
            'floor' => 5,
            'apartment' => 15,
            'user_id' => $user->id,
        ];
        $this->actingAs($this->adminUser);
        $response = $this->post('/api/admin/locations', $data);
        $response->assertCreated()
            ->assertJson([
                'city' => 'Moscow',
                'street' => 'Kirova',
                'house_number' => '12',
                'floor' => 5,
                'apartment' => 15,
                'user_id' => $user->id,
            ]);
        $this->assertDatabaseHas('locations', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_store_locations()
    {
        $user = User::factory()->create();
        $data = [
            'city' => 'Moscow',
            'street' => 'Kirova',
            'house_number' => '12',
            'floor' => 5,
            'apartment' => 15,
            'user_id' => $user->id,
        ];
        $response = $this->post('/api/admin/locations', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function it_can_show_location()
    {
        $location = Location::factory()->create();
        $this->actingAs($this->adminUser);
        $response = $this->get('/api/admin/locations/' . $location->id);
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $location->id,
                'city' => $location->city,
                'street' => $location->street,
                'house_number' => $location->house_number,
                'floor' => $location->floor,
                'apartment' => $location->apartment,
            ]);
    }

    /** @test */
    public function it_returns_not_found_when_showing_nonexistent_location()
    {
        $this->actingAs($this->adminUser);
        $response = $this->get('/api/admin/locations/999');

        $response->assertNotFound();
    }

    /** @test */
    public function it_can_update_product()
    {
        $location = Location::factory()->create();

        $data = [
            'city' => 'Moscow',
            'floor' => 7,
        ];
        $this->actingAs($this->adminUser);
        $response = $this->put('/api/admin/locations/' . $location->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas('locations', array_merge(['id' => $location->id], $data));
    }

    /** @test */
    public function it_returns_not_found_when_updating_nonexistent_location()
    {
        $data = [
            'city' => 'Moscow',
            'floor' => 7,
        ];
        $this->actingAs($this->adminUser);
        $response = $this->put('/api/admin/locations/999', $data);
        $response->assertNotFound();
    }

    /** @test */
    public function it_can_delete_location()
    {
        $location = Location::factory()->create();
        $this->actingAs($this->adminUser);
        $response = $this->delete('/api/admin/locations/' . $location->id);

        $response->assertOk();
        $this->assertModelMissing($location);
    }


    /** @test */
    public function it_returns_not_found_when_deleting_nonexistent_location()
    {
        $this->actingAs($this->adminUser);
        $response = $this->delete('/api/admin/locations/999');

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Ooops! Looks like something went wrong.',
            'message' => 'Not Found']);
    }
}

