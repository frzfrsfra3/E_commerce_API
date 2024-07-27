<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_product()
    {
        $product = Product::factory()->create();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name,
        ]);
    }

    /** @test */
    public function it_updates_a_product()
    {
        $product = Product::factory()->create();
        $product->name = 'Updated Product Name';
        $product->save();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name',
        ]);
    }

    /** @test */
    public function it_deletes_a_product()
    {
        $product = Product::factory()->create();
        $productId = $product->id;
        $product->delete();

        $this->assertDatabaseMissing('products', [
            'id' => $productId,
        ]);
    }
}
