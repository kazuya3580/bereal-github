@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- 投稿作成ページへのリンクを追加 -->
        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-4">Top</a>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>
            <button type="submit" class="btn btn-primary">編集</button>
        </form>

        <!-- 退会処理 -->
        <form  id="delete-form" action="{{ route('profile.destroy') }}" method="POST" style="margin-top: 10px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">退会</button>
        </form>

        <!-- 自分の投稿 -->
        <div style="border-bottom: 1px solid #ccc;padding: 10px;margin-bottom: 10px;">
            <h2>My Posts</h2>
            @if ($posts && count($posts) > 0)
            @foreach($posts as $post)
                <h3>{{ $post->title }}</h3>
                <p>{{ $post->body }}</p>
                <p>{{ $post->created_at->format('Y年m月d日 H時i分') }}</p>
                <!-- いいね・コメント・お気に入り閲覧 -->
                <div class="d-flex">
                            <a href="{{ route('posts.show', $post) }}" class="me-3 text-decoration-none text-secondary link-hover">
                                <p style="font-size: 20px;">いいね: {{ $post->likes->count() }}</p>
                            </a>
                            <a href="{{ route('posts.show', $post) }}" class="me-3 text-decoration-none text-secondary link-hover">
                                <p style="font-size: 20px;">コメント: {{ $post->comments->count() }}</p>
                            </a>
                            <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-secondary link-hover">
                                <p style="font-size: 20px;">お気に入り: {{ $post->favorites->count() }}</p>
                            </a>
                        </div>
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                @csrf
                @method('DELETE')
                    <div style="text-align: right; margin:0 10px 10px 0;">
                        <button type="submit" class="btn btn-danger">削除</button>
                    </div>
                </form>
            @endforeach
            @else
                <p>No posts found.</p>
            @endif
        </div>

        <!-- お気に入り一覧 -->
        <div>
            <h2>My Favorites</h2>
            @if ($favorites && count($favorites) > 0)
                @foreach($favorites as $favorite)
                    <div style="border-bottom: 1px solid #ccc;padding: 10px;margin-bottom: 10px;">
                        <h3>{{ $favorite->title }}</h3>
                        <p>{{ $favorite->body }}</p>
                        <p>{{ $favorite->created_at->format('Y年m月d日 H時i分') }}</p>
                    <!-- 他の表示項目を追加 -->
                        <form method="POST" action="{{ route('posts.unfavorite', $favorite) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-muted" style="color: black;">
                                <i class="fas fa-bookmark"></i> <!-- お気に入り解除ボタンのアイコン -->
                            </button>
                        </form>
                    </div>
                @endforeach
            @else
                <p>No favorites found.</p>
            @endif
        </div>
    </div>

    <!-- 削除確認のJavaScript -->
    <script>
        document.getElementById('delete-form').addEventListener('submit', function(event) {
            event.preventDefault(); // フォームのデフォルトの送信をキャンセル

            if (confirm('本当に削除しますか？')) {
                this.submit(); // 確認ダイアログで「OK」が選択された場合はフォームを送信
            }
        });
    </script>
@endsection
