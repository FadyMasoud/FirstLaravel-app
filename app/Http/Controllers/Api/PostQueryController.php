<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;







class PostQueryController extends Controller
{
    //

    public function index()
    {
        //
        return PostResource::collection(post::all());
    }

    public function getPostById($id)
    {
        $post = Post::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => '',
            'post' => new PostResource($post),
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'images' => 'nullable|image|max:2048',
        ], [
            'title.required' => 'Title is required',
            'body.required' => 'Body is required',
            'images.image' => 'The images must be an image file',
            'images.max' => 'The images must not be greater than 2048 kilobytes',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessage = [];

            if ($errors->has('title')) {
                $errorMessage[] = $errors->first('title');
            }

            if ($errors->has('body')) {
                $errorMessage[] = $errors->first('body');
            }

            if ($errors->has('images')) {
                $errorMessage[] = $errors->first('images');
            }

            return response()->json([
                'status' => false,
                'message' => implode(' ', $errorMessage),
            ], 422);
        }


        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('posts', 'public');
        }

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'images' => $imagePath,
            'user_id' => $request->user_id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Post created successfully',
            'post' => new PostResource($post),
        ]);
    }


    public function update(Request $request, $id)
    {
        Log::info('Request Data: ', $request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'images' => 'nullable|image|max:2048',
        ], [
            'title.required' => 'Title is required',
            'body.required' => 'Body is required',
            'images.image' => 'The images must be an image file',
            'images.max' => 'The images must not be greater than 2048 kilobytes',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $post = Post::findOrFail($id);

        if ($request->hasFile('images')) {
            // Delete old image if exists
            // if ($post->images) {
            //     Storage::disk('public')->delete($post->images);
            // }

            // Store the new image
            $imagePath = $request->file('images')->store('posts', 'public');
            $post->images = $imagePath;
        }

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = Auth::id(); // Assign the post to the currently authenticated user

        // Save the updated post to the database
        $post->save();

        return new PostResource($post);
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json([
            'status' => true,
            'message' => 'Post deleted successfully',
        ]);
    }

    public function softDelete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json([
            'status' => true,
            'message' => 'Post deleted successfully',
        ]);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        return response()->json([
            'status' => true,
            'message' => 'Post restored successfully',
        ]);
    }

    public function getFirstTwoPost()
    {
        $posts = Post::take(2)->get();

        return response()->json($posts);
    }

    public function getPostByTitle()
    {
        $posts = Post::whereIn('id', ['2', '3'])->get();

        return response()->json($posts);
    }
}
