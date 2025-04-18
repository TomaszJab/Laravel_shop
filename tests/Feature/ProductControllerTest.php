<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use App\Models\CategoryProduct;
use Illuminate\Support\Arr;

class ProductControllerTest extends TestCase
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

    //index
    //http://127.0.0.1:8000/products?category_products=a
    public function test_index_returns_view_with_products_data()
    {
        $categoryProduct = CategoryProduct::factory()->create();
        $product = Product::factory()->count(3)->create([
            'category_products_id' => $categoryProduct->id,
        ]);

        // Uwaga category_products=a musi być takie jak w CategoryProduct::factory()->create();
        $response1 = $this->get('/products?category_products=' . $categoryProduct->name_category_product);
        $response2 = $this->get('/products?category_products=' . $categoryProduct->name_category_product . '&sortOption=asc');

        //$response1
        $response1->assertStatus(200);
        $response1->assertViewIs('products.index');
        $response1->assertViewHasAll([
            'products',
            'sortOption',
            'favoriteProduct'
        ]);

        $viewProducts = $response1->viewData('products');
        $this->assertNotEmpty($viewProducts);
        $sortOption = $response1->viewData('sortOption');
        $this->assertEmpty($sortOption);
        $favoriteProduct = $response1->viewData('favoriteProduct');
        $this->assertNotEmpty($favoriteProduct);

        //$response2
        $response2->assertStatus(200);
        $response2->assertViewIs('products.index');
        $response2->assertViewHasAll([
            'products',
            'sortOption',
            'favoriteProduct'
        ]);

        $viewProducts = $response2->viewData('products');
        $this->assertNotEmpty($viewProducts);
        $sortOption = $response2->viewData('sortOption');
        $this->assertNotEmpty($sortOption);
        $favoriteProduct = $response2->viewData('favoriteProduct');
        $this->assertNotEmpty($favoriteProduct);
    }

    //do tego nie ma api
    // public function create()
    // {
    //     $categoryProduct = CategoryProduct::all();
    //     return view('products.create', compact('categoryProduct'));
    // }

    // post http://127.0.0.1:8000/products
    // {
    //     "name": "Nowy Produkt",
    //     "price": 99.99,
    //     "detail": "Opis produktu",
    //     "category_products_id": "1"
    //  }
    //admin
    public function test_api_admin_can_store_product()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user);

        $this->assertAuthenticated();

        $product = Product::factory()->make()->toArray();

        $response = $this->post('/products', $product);

        $response->assertStatus(302);//sprawdzic to
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product created successfully.');
        $this->assertDatabaseHas('products', Arr::except($product, ['created_at', 'updated_at', 'id']));
    }

    //user
    public function test_api_user_cannot_store_product()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->assertAuthenticated();

        $product = Product::factory()->make()->toArray();

        $response = $this->post('/products', $product);
        $response->assertStatus(403);
      
        $this->assertDatabaseMissing('products', Arr::except($product, ['created_at', 'updated_at', 'id']));
    }
}
