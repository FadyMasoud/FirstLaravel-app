@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Posts</h1>
   
    
    <div class="row">
        <a href="{{route('posts.create')}}" class="btn btn-primary">create</a>
    </div>
    <br>

    <div class="row">
        @foreach ($posts as $post)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{$post->title}}</h3>
                    <p>Written on {{$post->created_at}}</p>
                </div><br>
                <div class="card-body">
                    @if($post->images)
                        <img src="{{ asset('storage/'.$post->images) }}" alt="{{$post->images}}">
                    @endif
                </div>

                <div class="card-body">
                    {{$post->body}} <br>
                    <a href="{{route('posts.show',$post->id)}}" class="btn btn-primary">show</a>
                    <a href="{{route('posts.edit',$post->id)}}" class="btn btn-primary">edit</a><br><br>
                    @if ($post->trashed())
                        <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Restore</button>
                        </form>
                    @else
                        <form action="{{route('posts.destroy',$post->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif
                </div>
            </div><br><br>
        </div>
        @endforeach
    </div>
</div>

    @endsection
                    
            

</div>