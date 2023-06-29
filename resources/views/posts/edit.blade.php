@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <label for="title" class="form-label"  style="font-size: 30px;">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
        </div>
        <div class="card-body">
            <label for="body" class="form-label"  style="font-size: 30px;">Body</label>
            <textarea class="form-control" id="body" name="body" rows="4" required>{{ $post->body }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary"  style="margin:20px; 0 0 0;">Update Post</button>
    </form>
</div>
@endsection
