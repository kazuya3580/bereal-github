<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {

        $comments = $post->comments;

        $validated = $request->validate([
            'body' => 'required|max:255'
        ]);

        $comment = new Comment($validated);
        $comment->user_id = $request->user()->id;
        $post->comments()->save($comment);

        return redirect()->route('posts.index', $post);
    }
}
