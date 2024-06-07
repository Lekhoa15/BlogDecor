<?php

namespace App\Http\Controllers\Pages;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index()
    {
        return view('pages.authors.index', [
            'authors'   => User::where('type', User::WRITER)->get(),
        ]);
    }

   public function show($user_id)
{
    $author = User::findOrFail($user_id);
    return view('pages.authors.show', [
        'author'    => $author,
        'posts'     => Post::where('author_id', $author->id)->paginate(4),
    ]);

}


}
