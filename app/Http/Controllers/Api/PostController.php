<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return PostResource::collection(post::all());
    }
    // public function getFirstTwoPosts()
    // {
    //     $Posts = Post::take(2)->get();

    //     return response()->json($Posts);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

            $request['images'] = $imagePath;
        }

        $post = Post::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Post created successfully',
            'post' => new PostResource($post),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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


        $post = Post::findOrFail($id);
        /*return response()->json([
            'status' => false,
            'message' => $request->all(),
        ], 422);*/
        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('posts', 'public');
            $post->images = $imagePath;
        }

        $post->title = $request->title;
        $post->body = $request->body;
        //$post->user_id = Auth::id(); // Assign the post to the currently authenticated user

        // Save the updated post to the database
        $post->save();

        return new PostResource($post);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
