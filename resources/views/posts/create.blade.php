@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="panel-heading">Create Posts</h2>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                

                <div class="panel-body">
                    <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="images">Iimage</label>
                            <input type="file" name="images" class="form-control" id="images" >
                        </div>
                        
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea name="body" class="form-control" id="body" placeholder="Enter Body"></textarea>
                        </div>
                       

                        <button type="submit" class="btn btn-primary">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endSection
