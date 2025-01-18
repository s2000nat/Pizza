<?php

use App\Helpers\RandomDataGenerator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
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
    public function it_can_list_users_for_admin()
    {
        $user = User::factory()->create();

        $this->actingAs($this->adminUser);

        $response = $this->get('/api/admin/users');
        $response->assertOk();
    }

    /** @test */
    public function it_returns_forbidden_error_if_user_is_not_admin()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/admin/users');

        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJsonFragment([
            'message' => 'Only Admin access.'
        ]);
    }

    /** @test */
    public function it_can_store_user()
    {
        $data = [
            'name' => 'Alexandr',
            'phone_number' => $this->phoneNumber,
            'email' => 'alexandr@example.com',
            'password' => 'Qwerty123'
        ];
        $this->actingAs($this->adminUser);
        $response = $this->post('/api/admin/users', $data);
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'name' => 'Alexandr',
            'phone_number' => $this->phoneNumber,
            'email' => 'alexandr@example.com']);
    }

    /** @test */
    public function unauthorized_user_cannot_store_user()
    {
        $data = [
            'name' => 'Alexandr',
            'phone_number' => $this->phoneNumber,
            'email' => 'alexandr@example.com',
            'password' => 'Qwerty123'
        ];
        $response = $this->post('/api/admin/users', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function it_can_show_user()
    {
        $order = User::factory()->create();
        $this->actingAs($this->adminUser);
        $response = $this->get('/api/admin/users/' . $order->id);
        $response->assertOk();
    }

    /** @test */
    public function it_returns_not_found_when_showing_nonexistent_user()
    {
        $this->actingAs($this->adminUser);
        $response = $this->get('/api/admin/users/999');

        $response->assertNotFound();
    }

    /** @test */
    public function it_can_update_user()
    {
        $user = User::factory()->create();
        $data = [
            'phone_number' => $this->phoneNumber,
        ];
        $this->actingAs($this->adminUser);
        $response = $this->put('/api/admin/users/' . $user->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas('users', array_merge(['id' => $user->id], $data));
    }

    /** @test */
    public function it_returns_not_found_when_updating_nonexistent_user()
    {
        $data = [
            'phone_number' => $this->phoneNumber,
        ];
        $this->actingAs($this->adminUser);
        $response = $this->put('/api/admin/users/999', $data);
        $response->assertNotFound();
    }

    /** @test */
    public function it_can_delete_order()
    {
        $user = User::factory()->create();
        $this->actingAs($this->adminUser);
        $response = $this->delete('/api/admin/users/' . $user->id);

        $response->assertOk();
        $this->assertModelMissing($user);
    }


    /** @test */
    public function it_returns_not_found_when_deleting_nonexistent_order()
    {
        $this->actingAs($this->adminUser);
        $response = $this->delete('/api/admin/users/999');

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Ooops! Looks like something went wrong.',
            'message' => 'Not Found']);
    }
}

