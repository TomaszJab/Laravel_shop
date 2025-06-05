<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Subscriber;
use Illuminate\Support\Arr;

class SubscriberTest extends TestCase
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

    //subscribe
    public function test_subscribe_add_subscriber()
    {
        $subscriber = Subscriber::factory()->make()->toArray();
        $email['email_address'] = $subscriber['email_subscriber'];

        $response = $this->post('/subscriber/store', $email);
        $response->assertRedirect(route('products.index', ['category_products' => 'a']));
        $response->assertSessionHas('success', 'You are a subscriber!');
        $this->assertDatabaseHas(
            'subscribers',
            Arr::except($subscriber, ['created_at', 'updated_at', 'id'])
        );
    }
}
