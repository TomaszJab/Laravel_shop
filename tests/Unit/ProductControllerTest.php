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

    //co w przypadku gdy nie przejdzie walidacji
    public function test_create_product()
    {   
        $categoryProduct = CategoryProduct::factory()->create();
        $product = Product::factory()->make([
            'category_products_id' => $categoryProduct->id,
        ])->toArray();
        
        $response = $this->postJson('/api/products', $product);
        $response->assertStatus(201)->assertJson($product);
    }

    public function test_create_product_validation_fails(){
        $response = $this->postJson('/api/products', []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'price', 'detail', 'category_products_id']);
    }
    // dodac uwierzytelnianie
    // public function test_storeComment(){
    //     $comment = Comment::factory()->make()->toArray();
    //     $categoryProduct = CategoryProduct::factory()->create();
    //     $product = Product::factory()->create([
    //         'category_products_id' => $categoryProduct->id,
    //     ]);
    //     $idProduct = $product->id;

    //     $response = $this->postJson('api/products/'.$idProduct.'/comments', $comment);
    //     $response->assertStatus(201)->assertJson($comment);

    //     $this->assertDatabaseHas('comments', [
    //         'product_id' => $idProduct,
    //         'content' => $comment['content'],
    //     ]);
    // }
   
}
