<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
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
        // $posts = Post::all();
        $posts = Post::withTrashed()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            return view('posts.create');
        } else {
            return redirect('/login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'images' => 'nullable|image|max:2048'
        ]);

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('posts', 'public');
            
            //  $post->images = $imagePath;
        }

        // Create a new post instance and save to the database
        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'images' => $imagePath,
            'user_id' => Auth::id()
        ]);

        // Redirect to the posts index page with a success message
        return redirect('/posts')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $users = User::all();
        return view('posts.edit', compact('post', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'images' => 'nullable|image|max:2048'
        ]);

        // Find the post by ID
        $post = Post::find($id);

        // Handle file upload
        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('posts', 'public');
            $post->images = $imagePath;
        }

        // Update post attributes
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::id(); // Assign the post to the currently authenticated user

        // Save the updated post to the database
        $post->save();

        // Redirect to the posts index page with a success message
        // return redirect('/posts')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('/posts')->with('success', 'Post deleted successfully!');
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        return redirect('/posts')->with('success', 'Post restored successfully!');
    }
}
