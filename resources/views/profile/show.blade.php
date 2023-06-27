@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profile</h1>
        <p style="border-bottom: 1px solid #ccc;padding: 10px;margin-bottom: 10px;"><strong>Name:</strong> {{ $user->name }}</p>
        <p style="border-bottom: 1px solid #ccc;padding: 10px;margin-bottom: 10px;"><strong>Email:</strong> {{ $user->email }}</p>

        <h2>My Posts</h2>
        @if ($posts && count($posts) > 0)
        @foreach($posts as $post)
            <div  style="border-bottom: 1px solid #ccc;padding: 10px;margin-bottom: 10px;">
                <h3>{{ $post->title }}</h3>
                <p>{{ $post->body }}</p>
                <p>{{ $post->created_at->format('Y年m月d日 H時i分') }}</p>
                <a href="{{ route('posts.show', $post) }}"><p style="font-size: 20px;">Likes: {{ $post->likes->count() }}</p></a>
                <a href="{{ route('posts.show', $post) }}"><p style="font-size: 20px;">Comments: {{ $post->comments->count() }}</p></a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
            @csrf
            @method('DELETE')
                <div style="text-align: right; margin:0 10px 10px 0;">
                    <button type="submit" class="btn btn-danger">Delete Post</button>
                </div>
            </form>
            </div>
        @endforeach
        @else
            <p>No posts found.</p>
        @endif
    </div>
@endsection
