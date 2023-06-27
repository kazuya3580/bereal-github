<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
{
    $user = auth()->user();

    if (!$user) {
        // ユーザーが認証されていない場合の処理
        // 例えばログインページへリダイレクトするなど
        return redirect('/login');
    }

    $posts = $user->posts()->latest()->get();

    return view('profile.show', compact('user', 'posts'));
}

}
