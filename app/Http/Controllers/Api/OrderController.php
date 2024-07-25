<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use App\Http\Resources\OrderResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::all();
        return OrderResource::collection($orders);
    }


    public function show($id)
    {
        $order = Order::findOrFail($id);
        return new OrderResource($order);
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
        $order->total_price = $request->Qauntity * $product->price;
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
        $order->total_price = $request->Qauntity * $product->price;

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
