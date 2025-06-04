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
use Illuminate\Support\Arr;

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

    //http://127.0.0.1:8000/api/cart/order/18
    //details
    //user
    public function test_user_can_access_to_cart_details_route()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user, 'sanctum');
        $this->assertAuthenticated('sanctum');

        $personalDetails = PersonalDetails::factory()->create([
            'user_id' => $user->id,
        ]);
        $orderProduct = OrderProduct::factory()->create([
            'user_id' => $user->id,
            'personal_details_id' => $personalDetails->id,
        ]);
        $idOrderProduct = $orderProduct->id;
        Order::factory()->count(3)->create(['order_product_id' => $idOrderProduct]);

        $response = $this->getJson('/api/order/' . $idOrderProduct);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'products',
            'orderProductData',
            'enableButtons',
            'summary'
        ]);
    }

    //details
    //other user
    public function test_other_user_cannot_access_to_other_user_cart_details_route()
    {
        $user = User::factory()->create(['role' => 'user']);
        $otherUser = User::factory()->create(['role' => 'user']);
        $this->actingAs($otherUser, 'sanctum');
        $this->assertAuthenticated('sanctum');

        $personalDetails = PersonalDetails::factory()->create([
            'user_id' => $user->id,
        ]);
        $orderProduct = OrderProduct::factory()->create([
            'user_id' => $user->id,
            'personal_details_id' => $personalDetails->id,
        ]);
        $idOrderProduct = $orderProduct->id;
        Order::factory()->count(3)->create(['order_product_id' => $idOrderProduct]);

        $response = $this->getJson('/api/order/' . $idOrderProduct);
        $response->assertStatus(403);
    }

    //details
    //admin
    public function test_admin_can_access_to_cart_details_route()
    {
        $user = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'sanctum');
        $this->assertAuthenticated('sanctum');

        $personalDetails = PersonalDetails::factory()->create([
            'user_id' => $user->id,
        ]);
        $orderProduct = OrderProduct::factory()->create([
            'user_id' => $user->id,
            'personal_details_id' => $personalDetails->id,
        ]);
        $idOrderProduct = $orderProduct->id;
        Order::factory()->count(3)->create(['order_product_id' => $idOrderProduct]);

        $response = $this->getJson('/api/order/' . $idOrderProduct);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'products',
            'orderProductData',
            'enableButtons',
            'summary'
        ]);
    }

    //details
    //admin
    public function test_admin_can_access_to_own_cart_details_route()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'sanctum');
        $this->assertAuthenticated('sanctum');

        $personalDetails = PersonalDetails::factory()->create([
            'user_id' => $admin->id,
        ]);
        $orderProduct = OrderProduct::factory()->create([
            'user_id' => $admin->id,
            'personal_details_id' => $personalDetails->id,
        ]);
        $idOrderProduct = $orderProduct->id;
        Order::factory()->count(3)->create(['order_product_id' => $idOrderProduct]);

        $response = $this->getJson('/api/order/' . $idOrderProduct);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'products',
            'orderProductData',
            'enableButtons',
            'summary'
        ]);
    }

    //details
    //admin
    public function test_admin_cannot_access_to_non_existing_order_cart_details_route()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'sanctum');
        $this->assertAuthenticated('sanctum');

        $idOrderProduct = 1;

        $response = $this->getJson('/api/cart/order/' . $idOrderProduct);
        $response->assertStatus(404);
    }

    //details
    //user
    public function test_user_cannot_access_to_non_existing_order_cart_details_route()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user, 'sanctum');
        $this->assertAuthenticated('sanctum');

        $idOrderProduct = 1;

        $response = $this->getJson('/api/cart/order/' . $idOrderProduct);
        $response->assertStatus(404);
    }

    //http://127.0.0.1:8000/api/cart/order
    //admin
    //order
    public function test_admin_can_access_cart_order_route()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'sanctum');
        $this->assertAuthenticated('sanctum');

        OrderProduct::factory()->create();
        Product::factory()->create();

        $response = $this->getJson('/api/order');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'orderProducts',
            'products'
        ]);

        $this->assertNotEmpty($response->json('products'));
        $this->assertNotEmpty($response->json('orderProducts'));

        //jesli nie ma factory
        // $this->assertEmpty($response->json('products'));
        // $this->assertEmpty($response->json('orderProducts'));
    }

    //http://127.0.0.1:8000/api/cart/order
    //user
    //order
    public function test_user_can_access_cart_order_and_get_personal_details()
    {
        $user = User::factory()->create();
        //uwierzytalnianie uzytkownia
        $this->actingAs($user, 'sanctum');

        $this->assertAuthenticated('sanctum');
        $personalDetails = PersonalDetails::factory()->create([
            'user_id' => $user->id,
            'default_personal_details' => '0'
        ]);

        $defaultPersonalDetails = PersonalDetails::factory()->create([
            'user_id' => $user->id,
            'default_personal_details' => 1
        ]);

        OrderProduct::factory()->create([
            'user_id' => $user->id,
            'personal_details_id' => $personalDetails->id
        ]);

        $response = $this->getJson('/api/order');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'orderProducts',
            'personalDetails',
            'additionalPersonalDetails'
        ]);

        $this->assertNotEmpty($response->json('orderProducts'));
        $this->assertNotEmpty($response->json('personalDetails'));
        $this->assertNotEmpty($response->json('additionalPersonalDetails'));
    }

    //http://127.0.0.1:8000/api/personalDetails/create
    //guest
    //buyWithoutRegistration
    public function test_guest_user_gets_null_personal_details()
    {
        $this->assertGuest('sanctum');

        $response = $this->getJson('/api/personalDetails/create');
        $response->assertStatus(200);
        // $response->assertJson([
        //     'defaultPersonalDetails' => null
        // ]);
    }

    //http://127.0.0.1:8000/api/personalDetails/create
    //user
    //buyWithoutRegistration
    public function test_authenticated_user_receives_personal_details()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user, 'sanctum');

        $this->assertAuthenticated('sanctum');
        $defaultPersonalDetails = PersonalDetails::factory()->create([
            'user_id' => $user->id,
            'default_personal_details' => 1,
        ]);

        $response = $this->getJson('/api/personalDetails/create');
        $response->assertStatus(200);
        $response->assertExactJson([
            'defaultPersonalDetails' => $defaultPersonalDetails->toArray()
        ]);
    }

    //storeWithoutRegistration
    //guest walidation error
    //$companyOrPrivatePerson = 'private_person';
    public function test_guest_have_validation_error1_store_without_registration()
    {
        $companyOrPrivatePerson = 'private_person';

        $response = $this->postJson('/api/personalDetail/walidation', [
            'company_or_private_person' => $companyOrPrivatePerson,
            'acceptance_of_the_regulations' => null //'sometimes|required|accepted' 'yes', 'on', 1, true
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email',
            'firstName',
            'lastName',
            'phone',
            'street',
            'house_number',
            'zip_code',
            'city',
            'acceptance_of_the_regulations'
        ]);
    }

    //storeWithoutRegistration
    //guest walidation error
    //$companyOrPrivatePerson = 'company';
    public function test_guest_have_validation_error2_store_without_registration()
    {
        $companyOrPrivatePerson = 'company';

        $response = $this->postJson('/api/personalDetail/walidation', [
            'company_or_private_person' => $companyOrPrivatePerson,
            'acceptance_of_the_regulations' => 'o'//'sometimes|required|accepted' 'yes', 'on', 1, true
        ]);

        $response->assertStatus(422);
       // $response->dump();
        $response->assertJsonValidationErrors([
            'email',
            'firstName',
            'lastName',
            'phone',

            'company_name',
            'nip',

            'street',
            'house_number',
            'zip_code',
            'city',
            'acceptance_of_the_regulations'
        ]);
    }

    //storeWithoutRegistration
    //guest walidation error
    //$companyOrPrivatePerson = 'company';
    public function test_guest_can_store_without_registration()
    {
        $personalDetails = PersonalDetails::factory()->make([
            'default_personal_details' => 1,
            'company_or_private_person' => 'company'
        ]);

        $personalDetails = $personalDetails->toArray();

        $response = $this->postJson('/api/personalDetail/walidation', $personalDetails);

        $response->assertStatus(200);

        $expectedPersonalDetails = Arr::except($personalDetails, ['id', 'created_at', 'updated_at']);
        $response->assertJsonFragment($expectedPersonalDetails);
    }

    //savewithoutregistration
    public function test_guest_can_save_order()
    {
        $personalDetails = PersonalDetails::factory()->make([
            'user_id' => null
        ]);

        $product1 = Product::factory()->create()->toArray();
        $product1['quantity'] = 2;
        $product2 = Product::factory()->create()->toArray();
        $product2['quantity'] = 1;

        $cart_data = [
            'products' => [
                ($product1['id'] . '_M') => $product1,
                ($product2['id'] . '_L') => $product2,
            ],
            'method_delivery' => 'kurier',
            'method_payment' => 'blik',
            'promo_code' => '',
            'shipping' => 10.00,
            'subtotal' => 199.97,
            'total' => 209.97,
            'payment' => 0.00
        ];

        $response = $this->postJson('/api/order/store', [
            'personal_details' => $personalDetails,
            'cart_data' => $cart_data
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Order created successfully'
        ]);

        $personalDetails = $personalDetails->toArray();
        $this->assertDatabaseHas('personal_details', $personalDetails);

        $this->assertDatabaseHas('order_products', [
            'user_id' => $personalDetails['user_id'],
            //'personal_details_id' => $personalDetails['id'], //jest make a nie create to nie ma
            'method_delivery' => $cart_data['method_delivery'],
            'method_payment' => $cart_data['method_payment'],
            'promo_code' => $cart_data['promo_code'] ?: null,
            'delivery' => $cart_data['shipping'],
            'subtotal' => $cart_data['subtotal'],
            'total' => $cart_data['total'],
            'payment' => $cart_data['payment']
        ]);


        $this->assertDatabaseHas('orders', [
            'product_id' => $product1['id'],
            //'order_product_id' => ,
            'name' => $product1['name'],
            'quantity' => $product1['quantity'],
            'price' => $product1['price'],
            'size' => 'M',
            'category_products_id' => $product1['category_products_id']
        ]);

        $this->assertDatabaseHas('orders', [
            'product_id' => $product2['id'],
            //'order_product_id' => ,
            'name' => $product2['name'],
            'quantity' => $product2['quantity'],
            'price' => $product2['price'],
            'size' => 'L',
            'category_products_id' => $product2['category_products_id']
        ]);
    }

    //savewithoutregistration
    // public function test_user_can_save_order()
    // {
    //     $user = User::factory()->create(['role' => 'user']);
    //     $this->actingAs($user, 'sanctum');
    //     $this->assertAuthenticated('sanctum');
    // }


    // POST http://127.0.0.1:8000/api/personalDetail/store
    // {
    //     "email": "test@example.com",
    //     "firstName": "Jan",
    //     "lastName": "Kowalski",
    //     "phone": "123456789",
    //     "street": "Warszawska",
    //     "house_number": "10",
    //     "zip_code": "00-001",
    //     "company_or_private_person": "company",
    //     "company_name":"s",
    //     "nip":"22",
    //     "city": "Warszawa",
    //     "default_personal_details": "1",
    //     "acceptance_of_the_regulations": "yes"
    // }
    //updateDefaultPersonalDetails
    public function test_user_can_update_default_personal_details()
    {
        // Tworzymy użytkownika za pomocą fabryki
        $user = User::factory()->create();

        // Tworzymy dane osobowe użytkownika (personal details)
        $personalDetails = PersonalDetails::factory()->create([
            'user_id' => $user->id,  // Przypisujemy utworzonemu użytkownikowi
        ])->toArray();

        // Zalogowanie użytkownika jako 'sanctum'
        $this->actingAs($user, 'sanctum');
        $this->assertAuthenticated('sanctum');

        //metoda tak na prawde dodaje nowy rekord ale go nie aktualizuje
        $response = $this->postjson('/api/personalDetail/store', $personalDetails);
        $response->assertStatus(201);
        $expectedPersonalDetails = Arr::except($personalDetails, ['id', 'created_at', 'updated_at']);
        $this->assertDatabaseHas('personal_details', $expectedPersonalDetails);
    }
}
