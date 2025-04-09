<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Models\PersonalDetails;
use App\Models\OrderProduct;
use App\Models\Order;

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

    //http://127.0.0.1:8000/api/cart/order/details/18
    //details
    public function test_user_can_access__to_cart_details_route(){
        $admin = User::factory()->create(['role' => 'user']);
        $this->actingAs($admin, 'sanctum');
        $this->assertAuthenticated('sanctum');

        $orderProduct = OrderProduct::factory()->create();
        $idOrderProduct = $orderProduct->id;
        $order = Order::factory()->count(3)->create(['order_product_id' => $idOrderProduct]);
        $response = $this->getJson('/api/cart/order/details/'.$idOrderProduct);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'products',
            'subtotal',
            'shipping',
            'payment',
            'promo_code',
            'total',
            'enableButtons',
            'summary'
        ]);
    }

    //http://127.0.0.1:8000/api/cart/order
    //order
    public function test_admin_can_access_cart_order_route(){
        $admin = User::factory()->create(['role' => 'admin']); // lub is_admin => 1
        $this->actingAs($admin, 'sanctum');
        $this->assertAuthenticated('sanctum');

        $response = $this->getJson('/api/cart/order');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'OrderProducts',
            'products',
        ]);
    }

    //http://127.0.0.1:8000/api/cart/order
    //order
    public function test_user_can_access_cart_order_and_get_personal_details()
    {
        $user = User::factory()->create(['role' => 'user']); // lub is_admin => 0
        //uwierzytalnianie uzytkownia
        $this->actingAs($user, 'sanctum');
        
        $this->assertAuthenticated('sanctum');
        $personalDetails = PersonalDetails::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('/api/cart/order');
        //dd($response->getContent()); 
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
        $this->assertGuest('sanctum');
        $response = $this->getJson('/api/cart/buy');
        $response->assertStatus(200);
        $response->assertJson([
            'defaultPersonalDetails' => null
        ]);
    }
}
