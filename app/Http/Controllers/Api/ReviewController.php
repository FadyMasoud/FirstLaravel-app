<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;


class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return ReviewResource::collection($reviews);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = Review::create($request->all());

        return new ReviewResource($review);
    }

    public function show($product_id)
    {
        $reviews = Review::where('product_id', $product_id)->get();
        return ReviewResource::collection($reviews);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = Review::findOrFail($id);
        $review->update($request->all());

        return new ReviewResource($review);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
