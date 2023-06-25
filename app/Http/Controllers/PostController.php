<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
{
    $posts = Post::latest()->get();
    return view('posts.index', compact('posts'));
}

public function create()
{
    return view('posts.create');
}

public function store(Request $request)
{
    $post = new Post;
    $post->title = $request->title;
    $post->body = $request->body;
    $post->save();
    return redirect('/posts');
}
public function destroy(Post $post)
{
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

}
