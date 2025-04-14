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
use App\Models\Product;

class CartApiTest extends TestCase
{
    use RefreshDatabase;

    //dd($response->getContent());

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // //http://127.0.0.1:8000/api/cart/order/details/18
    // //details
    // public function test_user_can_access__to_cart_details_route(){
    //     $user = User::factory()->create(['role' => 'user']);
    //     $this->actingAs($user, 'sanctum');
    //     $this->assertAuthenticated('sanctum');

    //     $personalDetails = PersonalDetails::factory()->create([
    //         'user_id' => $user->id,
    //     ]);
    //     $orderProduct = OrderProduct::factory()->create([
    //         'personal_details_id' => $personalDetails->id,
    //     ]);
    //     $idOrderProduct = $orderProduct->id;
    //     $order = Order::factory()->count(3)->create(['order_product_id' => $idOrderProduct]);

    //     $response = $this->getJson('/api/cart/order/details/'.$idOrderProduct);
    //     $response->assertStatus(200);
    //     $response->assertJsonStructure([
    //         'products',
    //         'subtotal',
    //         'shipping',
    //         'payment',
    //         'promo_code',
    //         'total',
    //         'enableButtons',
    //         'summary'
    //     ]);
    // }

    // //http://127.0.0.1:8000/api/cart/order
    // //admin
    // //order
    // public function test_admin_can_access_cart_order_route(){
    //     $admin = User::factory()->create(['role' => 'admin']); // lub is_admin => 1
    //     $this->actingAs($admin, 'sanctum');
    //     $this->assertAuthenticated('sanctum');

    //     $response = $this->getJson('/api/cart/order');
    //     $response->assertStatus(200);
    //     $response->assertJsonStructure([
    //         'OrderProducts',
    //         'products',
    //     ]);
    // }

    // //http://127.0.0.1:8000/api/cart/order
    // //user
    // //order
    // public function test_user_can_access_cart_order_and_get_personal_details()
    // {
    //     $user = User::factory()->create(['role' => 'user']); // lub is_admin => 0
    //     //uwierzytalnianie uzytkownia
    //     $this->actingAs($user, 'sanctum');
        
    //     $this->assertAuthenticated('sanctum');
    //     $personalDetails = PersonalDetails::factory()->create([
    //         'user_id' => $user->id,
    //     ]);

    //     $response = $this->getJson('/api/cart/order');
    //     //dd($response->getContent()); 
    //     $response->assertStatus(200);
    //     $response->assertJsonStructure([
    //         'OrderProducts',
    //         'personalDetails',
    //         'additionalPersonalDetails',
    //     ]);
    // }

    // //http://127.0.0.1:8000/api/cart/buy 
    // //guest
    // //buyWithoutRegistration
    // public function test_guest_user_gets_null_personal_details()
    // {
    //     $this->assertGuest('sanctum');

    //     $response = $this->getJson('/api/cart/buy');
    //     $response->assertStatus(200);
    //     $response->assertJson([
    //         'defaultPersonalDetails' => null
    //     ]);
    // }

    // //http://127.0.0.1:8000/api/cart/buy 
    // //user
    // //buyWithoutRegistration
    // public function test_authenticated_user_receives_personal_details(){
    //     $user = User::factory()->create(['role' => 'user']);
    //     //uwierzytalnianie uzytkownia
    //     $this->actingAs($user, 'sanctum');
        
    //     $this->assertAuthenticated('sanctum');
    //     $personalDetails = PersonalDetails::factory()->create([
    //         'user_id' => $user->id,
    //         'default_personal_details' => 1,
    //     ]);

    //     $response = $this->getJson('/api/cart/buy'); 
    //     $response->assertStatus(200);
    //     $response->assertExactJson([
    //         'defaultPersonalDetails' => $personalDetails->toArray()
    //     ]);
    // }

    //savewithoutregistration
    public function test_guest_can_save_order()
    {
        $personalDetails = PersonalDetails::factory()->make([
            'user_id' => null
        ]);//->toArray();

        $product_1 = Product::factory()->create()->toArray();
        $product_1['quantity'] = 2;
        $product_2 = Product::factory()->create()->toArray();
        $product_2['quantity'] = 1;

        $cart_data = [
            'products' => [
                ($product_1['id'] . '_M') => $product_1, 
                ($product_2['id'] . '_L') => $product_2,
            ],
            'method_delivery' => 'kurier',
            'method_payment' => 'blik',
            'promo_code' => '',
            'shipping' => 10.00,
            'subtotal' => 199.97,
            'total' => 209.97,
            'payment' => 0.00
        ];

        $response = $this->postJson('/api/cart/savewithoutregistration', [
            'personal_details' => $personalDetails,
            'cart_data' => $cart_data
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Order created successfully'
        ]);

        $personalDetails = $personalDetails->toArray();
        $this->assertDatabaseHas('personal_details', $personalDetails);

        //$this->assertDatabaseHas('order_products', ??);
        //$this->assertDatabaseHas('orders', ??);
    }

    //savewithoutregistration
    // public function test_user_can_save_order()
    // {
    //     $user = User::factory()->create(['role' => 'user']);
    //     $this->actingAs($user, 'sanctum');
    //     $this->assertAuthenticated('sanctum');
    // }
    
    //updateDefaultPersonalDetails
    public function test_user_can_update_default_personal_details()
    {
        // Tworzymy użytkownika za pomocą fabryki
        $user = User::factory()->create();

        // Tworzymy dane osobowe użytkownika (personal details)
        $personalDetails = PersonalDetails::factory()->create([
            'user_id' => $user->id,  // Przypisujemy utworzonemu użytkownikowi
        ]);

        // Zalogowanie użytkownika jako 'sanctum'
        $this->actingAs($user, 'sanctum');
        $this->assertAuthenticated('sanctum');
    
        $personal_details = [
            'user_id' => $user->id,
            'email' => 'updateduser@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'phone' => '987654321',
            'street' => 'New Test Street',
            'house_number' => '999',
            'zip_code' => '54321',
            'city' => 'Updated City',
            'acceptance_of_the_regulations' => '1',
            'company_or_private_person' => 'private_person',
            'default_personal_details' => '0',
        ];
       
            // 'company_name' => $this->faker->company(),
            // 'nip' => (int) $this->faker->numerify('##########'),
            // 'additional_information' => $this->faker->optional()->sentence(),
            // 'acceptance_of_the_invoice' => $this->faker->boolean() ? '1' : '0',
           
        //metoda tak na prawde dodaje nowy rekord ale go nie aktualizuje
        $response = $this->postjson('/api/cart/updateDefaultPersonalDetails', $personal_details);
        $response->assertStatus(201);
        $this->assertDatabaseHas('personal_details', $personal_details);
    }
}
