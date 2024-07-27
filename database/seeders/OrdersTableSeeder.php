<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()
        ->count(20)
        ->create()
        ->each(function ($order) {
            $products = Product::inRandomOrder()->take(rand(1, 5))->get();
            foreach ($products as $product) {
                $order->products()->attach($product->id, ['quantity' => rand(1, 10)]);
            }
        });
     
    }
}
