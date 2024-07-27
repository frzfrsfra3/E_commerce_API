<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = auth()->user();

        $order = DB::transaction(function () use ($request, $user) {
            $totalPrice = 0;

            foreach ($request->products as $orderProduct) {
                $product = Product::find($orderProduct['id']);
                $totalPrice += $product->price * $orderProduct['quantity'];

                if ($product->quantity < $orderProduct['quantity']) {
                    throw new \Exception("Product {$product->name} is out of stock");
                }

                $product->decrement('quantity', $orderProduct['quantity']);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
            ]);

            foreach ($request->products as $orderProduct) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $orderProduct['id'],
                    'quantity' => $orderProduct['quantity'],
                ]);
            }

            return $order;
        });

        return response()->json($order->load('products'), 201);
    }
}
