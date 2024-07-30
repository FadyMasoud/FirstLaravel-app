<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::all();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No Have Orders Yet.'], 404);
        }

        $ordersWithUserAndProduct = $orders->map(function ($order) {
            $order->user = new UserResource($order->user);
            $order->product = new ProductResource($order->product);
            return $order;
        });

        return $ordersWithUserAndProduct;
    }


    public function show($user_id)
    {
        $orders = Order::where('user_id', $user_id)->get();
        if ($orders->isEmpty()) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        return OrderResource::collection($orders);
    }

     public function getLastOrderByUserId($user_id)
    {
        $orders = Order::where('user_id', $user_id)->latest()->get();
        $order = $orders->last();
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $product = Product::find($order->product_id);
        $user=user::find($order->user_id);
        return [
            'order' => new OrderResource($order),
            'product' => new ProductResource($product),
            'user' => new UserResource($user),
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:products,id',
            'Qauntity' => 'required|integer|min:1',

        ]);

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->product_id = $request->product_id;
        $order->Qauntity = $request->Qauntity;
        $product = Product::find($request->product_id);
        if ($product->offer > 0) {
            $order->total_price = $request->Qauntity * $product->offer;
        } else {
            $order->total_price = $request->Qauntity * $product->price;
        }
        $order->save();

        // Update the product stock
        $product = Product::find($request->product_id);
        $product->stock -= $request->Qauntity;
        $product->save();

        return response()->json(
            [
                'message' => 'Order created successfully',
                'order' => $order
            ],
            201
        );
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:products,id',
            'Qauntity' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);
        $product = Product::find($order->product_id);

        // Revert the old product stock
        $product->stock += $order->Qauntity;

        $order->user_id = $request->user_id;
        $order->product_id = $request->product_id;
        $order->Qauntity = $request->Qauntity;
        if ($product->offer > 0) {
            $order->total_price = $request->Qauntity * $product->offer;
        } else {
            $order->total_price = $request->Qauntity * $product->price;
        }

        $order->save();

        // Deduct the new quantity from the product stock
        $product->stock -= $request->Qauntity;
        $product->save();

        return response()->json(
            [
                'message' => 'Order updated successfully',
                'order' => $order
            ],
            200
        );
    }


    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $product = Product::find($order->product_id);

        // Revert the product stock
        $product->stock += $order->Qauntity;
        $product->save();

        $order->delete();

        return response()->json(
            [
                'message' => 'Order deleted successfully'
            ],
            200
        );
    }


    public function sumTotalsale()
    {
        $total = Order::sum('total_price');

        return response()->json(
            [
                'total' => $total
            ],
            200
        );
    }
}
