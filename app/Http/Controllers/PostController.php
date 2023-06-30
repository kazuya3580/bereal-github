<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = auth()->user();
        $search = $request->input('search');

        $query = Post::where(function ($query) use ($currentUser, $search) {
            $query->where('visibility', 'public'); // 公開の投稿のみ取得

            if ($currentUser) {
                $query->orWhere(function ($query) use ($currentUser, $search) {
                    $query->where('user_id', $currentUser->id) // 自分の投稿も取得
                        ->where('visibility', 'private'); // 非公開の投稿のみ取得
                });
            }

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('body', 'LIKE', '%' . $search . '%')
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'LIKE', '%' . $search . '%');
                        });
                });
            }
        });

        $posts = $query->latest()
            ->with('user', 'comments.user', 'likes', 'favorites')
            ->get();

        // 検索結果に関係のない投稿を除外する
        $posts = $posts->filter(function ($post) use ($search) {
            return stripos($post->title, $search) !== false || stripos($post->body, $search) !== false || stripos($post->user->name, $search) !== false;
        });

        return view('posts.index', compact('posts', 'search'));
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
    // バリデーションなどの処理を追加する場合はここで行います

    // フォームから送信されたデータを取得
    $title = $request->input('title');
    $body = $request->input('body');
    $visibility = $request->input('visibility');

    // 投稿を作成
    $post = new Post();
    $post->user_id = auth()->user()->id;
    $post->title = $title;
    $post->body = $body;
    $post->visibility = $visibility;
    $post->save();

    // 投稿が作成されたらリダイレクトするなどの処理を追加します

    return redirect()->route('posts.index');
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
        'visibility' => $request->input('visibility'),
    ]);

    return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
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
