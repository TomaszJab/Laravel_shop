<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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

        //sprawdzanie typu zmiennej
        //dd(gettype($comments))
    }

    //index
    //http://127.0.0.1:8000/products?category_products=a
    public function test_index_returns_view_with_products_data()
    {
        $categoryProduct = CategoryProduct::factory()->create();
        $product = Product::factory()->count(3)->create([
            'category_products_id' => $categoryProduct->id,
        ]);

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

    //create
    //admin
    public function test_create_admin_displays_create_product_with_categories()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user);

        $this->assertAuthenticated();

        $categoryProduct = CategoryProduct::factory()->count(3)->create();
        $response = $this->get('/products/create');
        $response->assertStatus(200);
        $response->assertViewIs('products.create');
        $response->assertViewHas('categoryProduct');
        $response->assertViewHas('categoryProduct', function ($value) use ($categoryProduct) {
            return $value->count() === $categoryProduct->count();
        });
    }

    //user
    public function test_create_user_cant_displays_create_product_with_categories()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->get('/products/create');
        $response->assertStatus(403);
    }

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

        $response->assertStatus(302);
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

    //addToCart2
    //addToCart

    //show
    //guest
    public function test_show_guest_can_show_product()
    {
        $product = Product::factory()->create();

        $comments = Comment::factory()->count(3)->create([
            'product_id' => $product->id,
        ]);//->each(function ($comment)  {
        //     $comment->created_at = fake()->dateTime('2014-02-25 08:37:17');
        //     $comment->save();
        // });

        $response = $this->get('/products/' . $product->id);

        $response->assertStatus(200);
        $response->assertViewIs('products.show');

        $response->assertViewHasAll([
            'product',
            'comments',
        ]);

        $viewDataProduct = $response->viewData('product');
        $viewDataComments = $response->viewData('comments');

        $this->assertTrue($viewDataProduct->is($product));
        $this->assertCount(3, $viewDataComments);
        $this->assertEquals(
            $comments->sortByDesc('created_at')->pluck('id'),
            $viewDataComments->pluck('id')
        );
    }

    //edit
    //admin
    public function test_edit_admin_can_edit_product()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        $this->actingAs($user);
        $this->assertAuthenticated();

        $product = Product::factory()->create();

        $response = $this->get('/products/' . $product->id . '/edit');
        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
        $response->assertViewHas('product', $product);
        $response->assertViewHas('product', function ($value) use ($product) {
            return $value->name === $product->name &&
                $value->price === $product->price &&
                $value->detail === $product->detail &&
                $value->favorite === $product->favorite &&
                $value->category_products_id === $product->category_products_id;
        });
    }

    //edit
    //user
    public function test_edit_user_cannot_edit_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $product = Product::factory()->create();

        $response = $this->get('/products/' . $product->id . '/edit');
        $response->assertStatus(403);
    }

    //update
    //admin
    public function test_update_admin_can_update_product()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        $this->actingAs($user);
        $this->assertAuthenticated();

        $product = Product::factory()->create();

        $updatedProduct = $product->toArray();
        $updatedProduct['name'] = 'Product 1';
        $updatedProduct['price'] = 2;

        $response = $this->put('/products/' . $product->id, $updatedProduct);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product updated successfully');

        $this->assertDatabaseHas('products', Arr::except($updatedProduct, [
            'created_at',
            'updated_at'
        ]));
    }

    //update
    //user
    public function test_update_user_cannot_update_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $product = Product::factory()->create();

        $updatedProduct = $product->toArray();
        $updatedProduct['name'] = 'Product 1';
        $updatedProduct['price'] = 2;

        $response = $this->put('/products/' . $product->id, $updatedProduct);

        $response->assertStatus(403);
        $response->assertSessionMissing('success');

        $this->assertDatabaseMissing('products', Arr::except($updatedProduct, [
            'created_at',
            'updated_at'
        ]));
    }

    //destroy
    //admin
    public function test_destroy_admin_can_destroy_product()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        $this->actingAs($user);
        $this->assertAuthenticated();

        $product = Product::factory()->create();
        $productId = $product->id;

        $response = $this->delete('products/' . $productId);
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product deleted successfully');
        $this->assertDatabaseMissing('products', [
            'id' => $productId
        ]);
    }

    //destroy
    //user
    public function test_destroy_user_cannot_destroy_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $product = Product::factory()->create();
        $productId = $product->id;

        $response = $this->delete('products/' . $productId);
        $response->assertStatus(403);
        $this->assertDatabaseHas('products', [
            'id' => $productId
        ]);
    }
}
