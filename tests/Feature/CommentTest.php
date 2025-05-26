<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;

class CommentTest extends TestCase
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

    //storeComment
    //user
    // POST http://127.0.0.1:8000/api/products/2/comments
    // {
    //     "content": "Nowy Produkt"
    // }
    public function test_storeComment_user_can_store_comment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $comment = Comment::factory()->make()->toArray();
        $product = Product::factory()->create();
        $idProduct = $product->id;

        $response = $this->post('products/' . $idProduct . '/comments', $comment);
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Comment added successfully!');
        $this->assertDatabaseHas('comments', [
            'product_id' => $idProduct,
            'author' => $user['name'],
            'content' => $comment['content'],
        ]);
    }

    //storeComment
    //guest
    public function test_storeComment_guset_cannot_store_comment()
    {
        $comment = Comment::factory()->make()->toArray();
        $product = Product::factory()->create();
        $idProduct = $product->id;

        $response = $this->post('products/' . $idProduct . '/comments', $comment);
        $response->assertRedirect(route('login'));
        $response->assertSessionMissing('success');
        $this->assertDatabaseMissing('comments', [
            'product_id' => $idProduct,
            'content' => $comment['content'],
        ]);
    }
}
