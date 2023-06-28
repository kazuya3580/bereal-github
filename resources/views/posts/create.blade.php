@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Out Put</h1>
            <a href="{{ route('profile.show') }}" class="btn btn-secondary mb-4" style="background-color: rgb(200, 200, 200); border: none;">Profile</a>
            <form action="/posts" method="post">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea class="form-control" id="body" name="body"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 20px; margin-bottom: 30px;">Out Put</button>
            </form>
            <!-- 投稿一覧表示ページへのリンクを追加 -->
            <a href="{{ route('posts.index') }}" class="btn btn-secondary mb-4">Everyone's Out Put</a>
        </div>
    </div>
</div>
@endsection
