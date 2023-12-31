<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        $posts = $user->posts()->latest()->get();
        $favorites = $user->favorites()->latest()->get();
        $post = new Post(); // 新しい Post インスタンスを作成

        return view('profile.show', compact('user', 'posts', 'favorites', 'post'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function destroy()
    {
        $user = Auth::user();

        // ユーザーに関連する投稿も削除する場合
        Post::where('user_id', $user->id)->delete();

        // ユーザーの削除
        $user->delete();

        // ログアウトしてリダイレクトする
        Auth::logout();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }

public function unfavorite(Post $post)
{
    $user = auth()->user();
    $user->favorites()->detach($post);

    return back();
}

}
