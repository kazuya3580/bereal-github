@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <p style="font-size: 20px;">Title</p>
                <h2>{{ $post->title }}</h2>
                <p>Posted by {{ $post->user->name }}</p>
            </div>
            <div class="card-body">
                <p style="font-size: 20px;">Body</p>
                <p style="border-bottom: 1px solid #ccc;padding: 10px;margin-bottom: 10px;">{{ $post->body }}</p>

                <h3>Likes</h3>
                @if ($post->likes->count() > 0)
                    <ul>
                        @foreach ($post->likes as $like)
                            <li>{{ $like->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No likes yet.</p>
                @endif

                <h3>Comments</h3>
                @foreach($post->comments as $comment)
                <p>{{ $comment->body }} By{{ $comment->user->name }}</p>
                <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="mb-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="far fa-trash-alt"></i> Delete Comment
                    </button>
                </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection
