<?php

declare(strict_types=1);

use App\Http\Resources\LocationResource;
use App\Http\Resources\UserResource;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Location $location;


    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['is_admin' => true]);
        $this->location = Location::factory()->create(['user_id' => $this->user->id]);
    }

    public function testCanRetrieveOwnProfileForAuthenticatedUser(): void
    {
        $this->actingAs($this->user);
        $response = $this->get('/api/profile');
        $response->assertStatus(Response::HTTP_OK);
        $expectedResponse = [
            'user' => (new UserResource($this->user))->toArray(request()),
            'locations' => LocationResource::collection($this->user->locations)->toArray(request())
        ];
        $response->assertJson($expectedResponse);

    }

    public function testCannotRetrieveOwnProfileForUnauthorizedUser(): void
    {
        $response = $this->get('/api/profile');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCanAddLocationInProfileForAuthenticatedUser(): void
    {
        $this->actingAs($this->user);
        $data = [
            'city' => 'Moscow',
            'street' => 'Kirova',
            'house_number' => '50',
            'floor' => 4,
            'apartment' => '22',
        ];

        $response = $this->post('/api/profile/location', $data);
        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJson($data);

    }

    public function testCannotAddLocationInProfileForUnauthorizedUser(): void
    {
        $data = [
            'city' => 'Moscow',
            'street' => 'Kirova',
            'house_number' => '50',
            'floor' => 4,
            'apartment' => '22',
        ];

        $response = $this->post('/api/profile/location', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCanUpdateLocationInProfileForAuthenticatedUser(): void
    {
        $this->actingAs($this->user);
        $data = [
            'city' => 'Moscow',
            'street' => 'Kirova',
            'house_number' => '50',
            'floor' => 4,
            'apartment' => '22',
        ];

        $response = $this->put('/api/profile/location/' . $this->location->id, $data);
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson($data);
    }

    public function testCannotUpdateLocationInProfileForUnauthorizedUser(): void
    {
        $data = [
            'city' => 'Moscow',
            'street' => 'Kirova',
            'house_number' => '50',
            'floor' => 4,
            'apartment' => '22',
        ];

        $response = $this->put('/api/profile/location/' . $this->location->id, $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
