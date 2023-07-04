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
        <div class="card-body">
            <label for="visibility" class="form-label" style="font-size: 30px;">Visibility</label>
            <select class="form-control" id="visibility" name="visibility">
                <option value="public" {{ $post->visibility === 'public' ? 'selected' : '' }}>Public</option>
                <option value="private" {{ $post->visibility === 'private' ? 'selected' : '' }}>Private</option>
            </select>
        </div>
        <div class="card-body">
            <label for="category" class="form-label" style="font-size: 30px;">Category</label>
            <select class="form-control" id="category" name="category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $post->category_id === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary"  style="margin-top: 20px;">Update Post</button>
    </form>
</div>
@endsection
