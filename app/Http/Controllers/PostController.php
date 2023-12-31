<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index(Request $request)
{
    $currentUser = auth()->user();
    $keywords = explode(' ', $request->input('search'));
    $search = $request->input('search');
    $categories = Category::search($search)->get();

    $query = Post::query();

    $query->where(function ($query) use ($currentUser, $keywords) {
        $query->where('visibility', 'public')
            ->orWhere(function ($query) use ($currentUser) {
                $query->where('user_id', $currentUser->id)
                    ->where('visibility', 'private');
            });
    });

    $query->where(function ($query) use ($keywords, $search) {
        foreach ($keywords as $keyword) {
            $query->where(function ($query) use ($keyword, $search) {
                $query->where('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('body', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('user', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%');
                    })
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
            });
        }
    });

    // $posts 変数を初期化
    $posts = null;

    // 選択されたカテゴリーがある場合のみ絞り込みを行う
    if ($request->has('category')) {
        $selectedCategory = $request->input('category');
        $posts = $query->whereHas('category', function ($query) use ($selectedCategory) {
            $query->where('name', $selectedCategory);
        })->get();
    } else {
        $posts = $query->get();
    }

    $posts = $query->latest()
        ->with('user', 'comments.user', 'likes', 'favorites', 'category') // カテゴリーをロードする
        ->get();

    return view('posts.index', compact('posts', 'search', 'categories'));
}




public function show(Post $post)
{
    $post->load('likes', 'comments.user');

    return view('posts.show', compact('post'));
}

public function create()
{
    $categories = Category::all(); // カテゴリーの一覧を取得

    return view('posts.create', compact('categories')); // カテゴリー一覧をビューに渡す
}

public function store(Request $request)
{
    // バリデーション
    $validatedData = $request->validate([
        'title' => 'required',
        'body' => 'required',
        'visibility' => 'in:public,private',
    ]);

    $title = $validatedData['title'];
    $body = $validatedData['body'];
    $visibility = $validatedData['visibility'];

    // フォームから送信されたデータを取得
    $title = $request->input('title');
    $body = $request->input('body');
    $visibility = $request->input('visibility');
    $category_id = $request->input('category');
    $category_name = $request->input('category');

    // カテゴリー情報を取得
    $category = Category::find($category_id);

    // 投稿を作成
    $post = new Post();
    $post->user_id = auth()->user()->id;
    $post->title = $title;
    $post->body = $body;
    $post->visibility = $visibility;

    // カテゴリーが存在する場合のみカテゴリーIDを保存
    if ($category) {
        $post->category_id = $category_id;
        $post->category_name = $category->name;
    }

    $post->save();

    // 投稿が作成されたらリダイレクトするなどの処理を追加します

    return redirect()->route('posts.index');
}

public function edit(Post $post)
{
    $categories = Category::all();
    return view('posts.edit', compact('post', 'categories'));
}

public function update(Request $request, Post $post)
{
    $post->update([
        'title' => $request->input('title'),
        'body' => $request->input('body'),
        'visibility' => $request->input('visibility'),
        'category_id' => $request->input('category'), // カテゴリーの更新
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
