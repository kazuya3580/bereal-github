<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
{
    $posts = Post::latest()->with('user', 'comments.user', 'likes', 'favorites')->get();

    return view('posts.index', compact('posts'));
}

public function show(Post $post)
{
    $post->load('likes', 'comments.user');

    return view('posts.show', compact('post'));
}

public function create()
{
    return view('posts.create');
}

public function store(Request $request)
{
    if (auth()->check()) {
        $post = new Post();
        $post->user_id = $request->user()->id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return redirect('/posts');
    } else {
        // ユーザーが認証されていない場合の処理
        return redirect('/login'); // ログインページへリダイレクトする例
    }
}

public function edit(Post $post)
{
    return view('posts.edit', compact('post'));
}

public function update(Request $request, Post $post)
{
    $post->update([
        'title' => $request->input('title'),
        'body' => $request->input('body'),
    ]);

    return redirect()->route('posts.index', $post)->with('success', 'Post updated successfully.');
}

public function destroy(Post $post)
{
    // 認証されたユーザーと投稿の所有者が一致するかチェック
    if (auth()->user()->id !== $post->user_id) {
        return back()->with('error', 'You are not authorized to delete this post.');
    }

    $post->delete();
    return redirect()->route('posts.index');
}


public function like(Post $post)
{
    $post->likes()->attach(auth()->user()->id);
    return back();
}

public function unlike(Post $post)
{
    $post->likes()->detach(auth()->user()->id);
    return back();
}

public function favorite(Post $post)
{
    $user = auth()->user();
    $user->favorites()->attach($post->id);

    return back();
}

public function unfavorite(Post $post)
{
    $user = auth()->user();
    $user->favorites()->detach($post->id);

    return back();
}

}
