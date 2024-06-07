<?php

namespace App\Http\Controllers\Pages;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth', 'verified'])->only(['show']);
    }

    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);
        return view('pages.posts.show', compact('post'));
    }

}
