@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">New BeReal</h1>
            <!-- 投稿一覧表示ページへのリンクを追加 -->
            <a href="{{ route('posts.index') }}" class="btn btn-secondary mb-4">Everyone's BeReal</a>
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
                <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Let's BeReal</button>
            </form>
        </div>
    </div>
</div>
@endsection
