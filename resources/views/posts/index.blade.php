@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Posts</h1>
            <!-- 投稿作成ページへのリンクを追加 -->
            <a href="{{ route('posts.create') }}" class="btn btn-primary mb-4">New Post</a>
            @foreach($posts as $post)
            <div class="card mb-4">
                <div class="card-header">{{ $post->title }}</div>
                <div class="card-body">
                    <p>{{ $post->body }}</p>
                    <p>{{ $post->created_at->toFormattedDateString() }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
