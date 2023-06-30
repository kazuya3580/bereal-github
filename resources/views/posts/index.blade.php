@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Out Put</h1>
            <!-- 投稿作成ページへのリンクを追加 -->
            <a href="{{ route('posts.create') }}" class="btn btn-primary mb-4">Let's Out Put</a>
            <!-- 検索機能 -->
            <form method="GET" action="{{ route('posts.index') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search">
                    <button type="submit" class="btn btn-outline-primary">検索</button>
                </div>
            </form>
            @if ($search)
                <h4>検索キーワード: "{{ $search }}"</h4>
            @endif
        @foreach($posts as $post)
        <!-- 投稿 -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
            <div>
                <p style="font-size: 30px; font-weight: bolder;">Title</p>
                {{ $post->title }}
            </div>
            <div class="form-group">
                <label for="visibility"></label>
                <small style="font-size: 20px;">
                    @if ($post->visibility === 'public')
                        Public
                    @elseif ($post->visibility === 'private')
                        Private
                    @endif
                </small>
            </div>
        </div>
        <div class="card-body">
            <p style="font-size: 20px;"></p>
            <p style="border-bottom: 1px solid #ccc;padding: 10px;margin-bottom: 10px;">{{ $post->body }}</br></br>{{ $post->created_at->format('Y年m月d日 H時i分') }} By{{ $post->user->name }}</p>
            <!-- コメント -->
            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                <div class="input-group mb-3">
                    <textarea name="body" class="form-control" rows="3" required></textarea>
                    <button type="submit" class="btn btn-primary">Comment</button>
                </div>
            </form>
            <!-- いいね・コメント・お気に入り閲覧 -->
            <div class="d-flex">
                <a href="{{ route('posts.show', $post) }}" class="me-3 text-decoration-none text-secondary">
                    <p style="font-size: 20px;">Likes: {{ $post->likes->count() }}</p>
                </a>
                <a href="{{ route('posts.show', $post) }}" class="me-3 text-decoration-none text-secondary">
                    <p style="font-size: 20px;">Comments: {{ $post->comments->count() }}</p>
                </a>
                <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-secondary">
                    <p style="font-size: 20px;">Favorites: {{ $post->favorites->count() }}</p>
                </a>
            </div>

        </div>
        <!-- いいね機能 -->
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
            <!-- お気に入り機能 -->
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
        <!-- 自分の投稿のみ編集 -->
        <div>
            @if ($post->user_id === auth()->user()->id)
                <div style="text-align: right; margin:0 10px 10px 0;">
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Edit Post</a>
        </div>
            @endif
        <!-- 自分の使うのみ削除 -->
        <div>
            @if ($post->user_id === auth()->user()->id)
                <form action="{{ route('posts.destroy', $post) }}" method="POST" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <div style="text-align: right; margin:0 10px 10px 0;">
                        <button type="submit" class="btn btn-danger" onclick="confirmDelete(event)">Delete Post</button>
                    </div>
                </form>
            @endif
        </div>
        <!-- 削除前の確認 -->
        <script>
            function confirmDelete(event) {
                event.preventDefault(); // フォームのデフォルトの送信をキャンセル

                if (confirm('本当に削除しますか？')) {
                    document.getElementById('delete-form').submit(); // 確認ダイアログで「OK」が選択された場合はフォームを送信
                }
            }
        </script>
    </div>
</div>
        @endforeach

@endsection
