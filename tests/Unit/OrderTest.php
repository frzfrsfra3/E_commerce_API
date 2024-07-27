<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_an_order_with_products()
    {
        $order = Order::factory()->create();
        $products = Product::factory()->count(3)->create();
        $order->products()->attach($products, ['quantity' => rand(1, 10)]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
        ]);

        foreach ($products as $product) {
            $this->assertDatabaseHas('order_product', [
                'order_id' => $order->id,
                'product_id' => $product->id,
            ]);
        }
    }
}
