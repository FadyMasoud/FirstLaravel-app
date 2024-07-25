@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Edit Post</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}">
        </div>
        <div>
            <label for="images">Image:</label>
            <input type="file" id="images" name="images" value="{{ old('images', $post->images) }}">
        </div>

        <div>
            <label for="body">Content:</label>
            <textarea id="body" name="body" required>{{ old('body', $post->body) }}</textarea>
        </div>
        <div class="form-group">
            <label for="user_id">Choose User</label>
            <select name="user_id" class="form-control" id="user_id">
                @foreach ($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit">Update Post</button>
        </div>
    </form>

    <br>
    <a href="{{ route('posts.show', $post->id) }}">Back to Post</a>

</div>

@endSection
