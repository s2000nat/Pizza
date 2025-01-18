<?php

namespace Tests\Feature;

use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SizeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function it_can_list_sizes_for_admin()
    {
        $size = Size::factory()->create();
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);

        $response = $this->get('/api/admin/sizes');
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $size->id,
                'slug' => $size->slug,]);
    }

    /** @test */
    public function it_returns_forbidden_error_if_user_is_not_admin()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/admin/sizes');

        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJsonFragment([
            'message' => 'Only Admin access.'
        ]);
    }

    /** @test */
    public function it_can_store_size()
    {
        $data = [
            'slug' => 'small',
        ];
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->post('/api/admin/sizes', $data);
        $response->assertCreated()
            ->assertJson([
                'slug' => 'small',
            ]);
        $this->assertDatabaseHas('sizes', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_store_size()
    {
        $data = [
            'slug' => 'small',
        ];
        $response = $this->post('/api/admin/sizes', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function it_can_show_size()
    {
        $size = Size::factory()->create();
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->get('/api/admin/sizes/' . $size->id);
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $size->id,
                'slug' => $size->slug,
            ]);
    }

    /** @test */
    public function it_returns_not_found_when_showing_nonexistent_size()
    {
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->get('/api/admin/sizes/999');

        $response->assertNotFound();
    }

    /** @test */
    public function it_can_update_size()
    {
        $size = Size::factory()->create();
        $data = [
            'slug' => 'small',
        ];
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->put('/api/admin/sizes/' . $size->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas('sizes', array_merge(['id' => $size->id], $data));
    }

    /** @test */
    public function it_returns_not_found_when_updating_nonexistent_size()
    {
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $data = [
            'slug' => 'small',
        ];
        $this->actingAs($user);
        $response = $this->put('/api/admin/sizes/999', $data);
        $response->assertNotFound();
    }

    /** @test */
    public function it_can_delete_size()
    {
        $size = Size::factory()->create();
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->delete('/api/admin/sizes/' . $size->id);

        $response->assertOk();
        $this->assertModelMissing($size);
    }


    /** @test */
    public function it_returns_not_found_when_deleting_nonexistent_size()
    {
        $user = User::factory()->create();
        $user->update(['is_admin' => true]);
        $this->actingAs($user);
        $response = $this->delete('/api/admin/sizes/999');

        $response->assertNotFound();
        $response->assertJson([
            'error' => 'Ooops! Looks like something went wrong.',
            'message' => 'Not Found']);
    }
}
