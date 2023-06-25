@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">BeReal</h1>
            <!-- 投稿作成ページへのリンクを追加 -->
            <a href="{{ route('posts.create') }}" class="btn btn-primary mb-4">New Post</a>
            @foreach($posts as $post)
            <div class="card mb-4">
                <div class="card-header">{{ $post->title }}</div>
                <div class="card-body">
                    <p>{{ $post->body }}</p>
                    <p>{{ $post->created_at->format('Y年m月d日 H時i分') }}</p>

                    @foreach($post->comments as $comment)
                        <p>{{ $comment->body }}</p>
                        <p>Posted by {{ $comment->user->name }}</p>
                    @endforeach

            <!-- ここにコメント投稿フォームを追加 -->
            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                <textarea name="body" required></textarea>
                <button type="submit">Comment</button>
            </form>

                    @if ($post->isLikedBy(auth()->user()))
                        <form action="{{ route('post.unlike', $post) }}" method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('post.like', $post) }}" method="post" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-link text-muted">
                                <i class="far fa-heart"></i>
                            </button>
                        </form>
                    @endif
                </div>
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                @csrf
                @method('DELETE')
                <div style="text-align: right; margin:0 10px 10px 0;">
                <button type="submit" class="btn btn-danger">Delete Post</button>
                </div>
            </form>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
