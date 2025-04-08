<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Providers\RouteServiceProvider;

class CartApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    //http://127.0.0.1:8000/api/cart/order
    //order
    public function test_admin_can_access_cart_order_route(){
        $admin = User::factory()->create(['role' => 'admin']); // lub is_admin => 1
        $this->actingAs($admin, 'sanctum');

        $response = $this->getJson('/api/cart/order');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'OrderProducts',
            'products',
        ]);
    }

    public function test_user_can_access_cart_order_and_get_personal_details()
    {
        $user = User::factory()->create(['role' => 'user']); // lub is_admin => 0
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/cart/order');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'OrderProducts',
            'personalDetails',
            'additionalPersonalDetails',
        ]);
    }

    //http://127.0.0.1:8000/api/cart/buy
    public function test_guest_user_gets_null_personal_details()
    {
        $response = $this->getJson('/api/cart/buy');
        $response->assertStatus(200);
        $response->assertJson([
            'defaultPersonalDetails' => null
        ]);
    }
}
