@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel-heading">Show Posts</div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h1>{{ $post->title }}</h1>
                        </div>
                        <div class="card-body">
                            @if($post->images)
                                <img src="{{ asset('storage/'.$post->images) }}" alt="{{$post->images}}">
                            @endif
                        </div>

                        <div class="card-body">
                            <div>{{ $post->body }}</div>
                            <small>Posted on: {{ $post->created_at->format('d M Y') }}</small>
                            <br>
                        </div><br><br>

                        <a href="{{ route('posts.index') }}" class="btn btn-primary">Back to all posts</a><br><br>

                        <h2>Comment</h2>
                        <form action="{{ route('posts.comments.store', $post->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="body">New Comment</label>
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <textarea name="body" id="body" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                        <div class="comments mt-5">
                            @foreach ($post->comments as $comment)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div id="comment-view-{{ $comment->id }}">
                                            <p class="card-text">{{ $comment->body }}</p>
                                            <p class="text-muted">Posted on {{ $comment->created_at->format('M d, Y H:i') }}</p>
                                            <button class="btn btn-secondary" onclick="editComment({{ $comment->id }})">Edit</button>
                                        </div>

                                        <div id="comment-edit-{{ $comment->id }}" style="display: none;">
                                            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="body-{{ $comment->id }}">Content</label>
                                                    <textarea name="body" id="content-{{ $comment->id }}" class="form-control" rows="5" required>{{ $comment->body }}</textarea>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <button type="button" class="btn btn-secondary" onclick="cancelEdit({{ $comment->id }})">Cancel</button>
                                                </div>
                                            </form>
                                        </div>

                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function editComment(commentId) {
        document.getElementById('comment-view-' + commentId).style.display = 'none';
        document.getElementById('comment-edit-' + commentId).style.display = 'block';
    }

    function cancelEdit(commentId) {
        document.getElementById('comment-view-' + commentId).style.display = 'block';
        document.getElementById('comment-edit-' + commentId).style.display = 'none';
    }
</script>

@endsection
