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
                    @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    @if ($errors->has('body'))
                        <span class="text-danger">{{ $errors->first('body') }}</span>
                    @endif
                    <textarea class="form-control" id="body" name="body"></textarea>
                </div>
                <!-- 公開非公開 -->
                <div class="form-group">
                    <label for="visibility">Visibility</label>
                    <select class="form-control" id="visibility" name="visibility">
                        <option value="public">公開</option>
                        <option value="private">非公開</option>
                    </select>
                </div>
                <!-- カテゴリー -->
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 20px; margin-bottom: 30px;">Out Put</button>
            </form>
            <!-- 投稿一覧表示ページへのリンクを追加 -->
            <a href="{{ route('posts.index') }}" class="btn btn-secondary mb-4">Top</a>
        </div>
    </div>
</div>
@endsection
