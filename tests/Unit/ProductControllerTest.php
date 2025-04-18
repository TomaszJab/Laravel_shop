<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use App\Models\Product;
//use Illuminate\Database\Eloquent\Factories\Factory;
//use App\Http\Services\ProductService;
//use App\Http\Services\CategoryProductService;

//use Tests\TestCase;
//use PHPUnit\Framework\TestCase;
//use Mockery;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use App\Models\CategoryProduct;
use App\Models\Subscriber;

use Illuminate\Support\Arr;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class ProductControllerTest extends TestCase
{
   // use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    // public function test_example(): void
    // {
    //     $this->assertTrue(true);
    // }

    use RefreshDatabase;

    // Dane testowe
        // $data = [
        //     'name' => 'Test Product',
        //     'description' => 'Test Product Description',
        //     'price' => 100,
        //     'category_id' => 1,
        // ];
    //$response = $this->getJson(route('products.index', ['category_products' => 'a']));
        //dd($response->getContent()); 

    public function uwierzytelnij_urzytkownika(){
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        return $user;
    }

    /** @test */
    public function index_it_creates_a_product_and_returns_json_response()
    {
        $categoryProduct = CategoryProduct::factory()->create();
        $product = Product::factory()->count(3)->create([
            'category_products_id' => $categoryProduct->id,
        ]);
        
        // Uwaga category_products=a musi być takie jak w CategoryProduct::factory()->create();
        $response1 = $this->getJson('/api/products?category_products='.$categoryProduct->name_category_product);
        $response2 = $this->getJson('/api/products?category_products='.$categoryProduct->name_category_product.'&sortOption=asc');

        // Sprawdzenie odpowiedzi JSON
        $response1->assertStatus(200)->assertJsonStructure([
            'products' => [
                // 'current_page',
                'data' => [
                    '*' => ['id', 'name', 'detail', 'created_at', 'updated_at', 'price', 'category_products_id', 'favorite']
                ],
                // 'first_page_url',
                // 'from',
                // 'last_page',
                // 'last_page_url',
                // 'links',
                // 'next_page_url',
                // 'path',
                // 'per_page',
                // 'prev_page_url',
                // 'to',
                // 'total'
            ],
            'sortOption',
            'favoriteProduct' => ['id', 'name', 'detail', 'created_at', 'updated_at', 'price', 'category_products_id', 'favorite']
        ]);

        $response2->assertStatus(200)->assertJsonStructure([
            'products' => [
                'data' => [
                    '*' => ['id', 'name', 'detail', 'created_at', 'updated_at', 'price', 'category_products_id', 'favorite']
                ],
            ],
            'sortOption',
            'favoriteProduct' => ['id', 'name', 'detail', 'created_at', 'updated_at', 'price', 'category_products_id', 'favorite']
        ]);
    }

    public function test_create_product()
    {   
        $categoryProduct = CategoryProduct::factory()->create();
        $product = Product::factory()->make([
            'category_products_id' => $categoryProduct->id,
        ])->toArray();
        
        $response = $this->postJson('/api/products', $product);
        $response->assertStatus(201)->assertJson(Arr::except($product, ['created_at', 'updated_at']));

        $this->assertDatabaseHas('products', Arr::except($product, ['created_at', 'updated_at', 'id']));
    }

    public function test_create_product_validation_fails(){
        $response = $this->postJson('/api/products', []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'price', 'detail', 'category_products_id']);
    }

    //storeComment
    public function test_storeComment(){
        //aby dodac komentarz urzytkownik musi byc zalogowany
        $this->uwierzytelnij_urzytkownika();

        //tworze komentarz
        $comment = Comment::factory()->make()->toArray();

        //tworze kategorie produktu i produkt
        $categoryProduct = CategoryProduct::factory()->create();
        $product = Product::factory()->create([
            'category_products_id' => $categoryProduct->id,
        ]);
        $idProduct = $product->id;

        $response = $this->postJson('api/products/'.$idProduct.'/comments', $comment);
        $response->assertStatus(201)->assertJson($comment);

        $this->assertDatabaseHas('comments', [
            'product_id' => $idProduct,
            'content' => $comment['content'],
        ]);
    }

    //addToCart_2
    //addToCart
    public function test_add_to_cart(){
        $categoryProduct = CategoryProduct::factory()->create();
        $product = Product::factory()->create([
            'category_products_id' => $categoryProduct->id,
        ]);
        $idProduct = $product->id;
        $response = $this->getJson('api/products/'.$idProduct.'/add_to_cart');

        $category_products = $categoryProduct->toArray();
        $product = $product->toArray();
        $response->assertStatus(200)->assertJson(compact('product', 'category_products'));
    }

    //http://127.0.0.1:8000/products/1
    public function test_show_product_and_comment(){
        $categoryProduct = CategoryProduct::factory()->create();
        $product = Product::factory()->create([
            'category_products_id' => $categoryProduct->id,
        ]);
        
        $idProduct = $product->id;

        $user = User::factory()->create();

        $comments = Comment::factory()->count(2)->create([
            'product_id' => $idProduct,
            'author' => $user->name
        ]);

        $response = $this->getJson('api/products/'.$idProduct);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'product' => [
                'id', 'name', 'detail', 'created_at', 'updated_at', 'price', 'category_products_id', 'favorite'
            ],
            'comments' => [
                '*' => ['id', 'product_id', 'author', 'content', 'created_at', 'updated_at']
            ]
        ]);
    }

    //http://127.0.0.1:8000/api/products/1
    // {
    //     "id": 1,
    //     "name": "a",
    //     "price": "1.00",
    //     "detail": "a",
    //     "favorite": 1,
    //     "created_at": null,
    //     "updated_at": null,
    //     "category_products_id": 2
    // }
    //update
    public function test_update_product(){
        $product = Product::factory()->create();

        $updatedProduct = $product->toArray();
        $updatedProduct['name'] = 'Product 1';
        $updatedProduct['price'] = 2;

        $response = $this->putJson('/api/products/'.$product->id, $updatedProduct);

        $response->assertStatus(200)->assertJson($updatedProduct);
    }

    public function test_delete_product(){
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/products/'.$product->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    //subscribe
    public function test_add_subscriber(){
        //$subscriber
        $subscriber = Subscriber::factory()->make()->toArray();
        $email['email_address'] = $subscriber['email_subscriber'];
        $response = $this->postJson('api/products/subscribe', $email);
       
        $response->assertStatus(201)->assertJson(Arr::except($subscriber, ['created_at', 'updated_at']));

        $this->assertDatabaseHas('subscribers', Arr::except($subscriber, ['created_at', 'updated_at','id']));
    }
}
