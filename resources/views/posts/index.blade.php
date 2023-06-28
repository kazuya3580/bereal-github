@extends('layouts.app')

<style>
    .text-secondary:hover {
    color: black;
}
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Out Put</h1>
            <!-- 投稿作成ページへのリンクを追加 -->
            <a href="{{ route('posts.create') }}" class="btn btn-primary mb-4">Let's Out Put</a>
            @foreach($posts as $post)
    <div class="card mb-4">
        <div class="card-header">
            <p style="font-size: 20px;">Title</p>
            {{ $post->title }}
        </div>
        <div class="card-body">
            <p style="font-size: 20px;">Body</p>
            <p style="border-bottom: 1px solid #ccc;padding: 10px;margin-bottom: 10px;">{{ $post->body }}</br></br>{{ $post->created_at->format('Y年m月d日 H時i分') }} By{{ $post->user->name }}</p>

            <p style="font-size: 20px;">Comment</p>

            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                <div class="input-group mb-3">
                    <textarea name="body" class="form-control" rows="3" required></textarea>
                    <button type="submit" class="btn btn-primary">Comment</button>
                </div>
            </form>

            <div class="d-flex">
                <a href="{{ route('posts.show', $post) }}" class="me-3 text-decoration-none text-secondary">
                    <p style="font-size: 20px;">Likes: {{ $post->likes->count() }}</p>
                </a>
                <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-secondary">
                    <p style="font-size: 20px;">Comments: {{ $post->comments->count() }}</p>
                </a>
            </div>

        </div>

        <div class="d-flex">
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

    <form method="POST" action="{{ $post->isFavoritedBy(auth()->user()) ? route('posts.unfavorite', $post) : route('posts.favorite', $post) }}" style="display: inline;">
        @csrf
        @if ($post->isFavoritedBy(auth()->user()))
            @method('DELETE')
            <button type="submit" class="btn btn-link text-muted" style="color: black;">
                <i class="fas fa-bookmark"></i> <!-- お気に入りされている場合のアイコン -->
            </button>
        @else
            <button type="submit" class="btn btn-link text-muted" style="color: white;">
                <i class="far fa-bookmark"></i> <!-- お気に入りされていない場合のアイコン -->
            </button>
        @endif
    </form>
</div>



        @if ($post->user_id === auth()->user()->id)
            <form action="{{ route('posts.destroy', $post) }}" method="POST">
            @csrf
            @method('DELETE')
                <div style="text-align: right; margin:0 10px 10px 0;">
                    <button type="submit" class="btn btn-danger">Delete Post</button>
                </div>
            </form>
        @endif
    </div>
@endforeach

@endsection
