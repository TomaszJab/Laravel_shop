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

    /** @test */
    public function it_creates_a_product_and_returns_json_response()
    {
        // Dane testowe
        // $data = [
        //     'name' => 'Test Product',
        //     'description' => 'Test Product Description',
        //     'price' => 100,
        //     'category_id' => 1,
        // ];
        $categoryProduct = CategoryProduct::factory()->create();
        $product = Product::factory()->create([
            'category_products_id' => $categoryProduct->id,
        ]);
        
        //$response = $this->getJson('http://127.0.0.1:8000/api/products?category_products=a');
        $response = $this->getJson('/api/products?category_products=a');
        //$response = $this->getJson(route('products.index', ['category_products' => 'a']));
        //dd($response->getContent()); 
        // Sprawdzenie odpowiedzi JSON
        $response->assertStatus(200)->assertJsonStructure(['products', 'sortOption', 'favoriteProduct']);
        //$this->assertTrue(true);
    }


   
}
