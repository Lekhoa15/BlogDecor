<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Jobs\CreatePost;
use App\Jobs\UpdatePost;
use App\Jobs\DeletePost;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function __construct()
    {
        // return $this->authorizeResource(Post::class, 'post');
    }

    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::paginate(5),
        ]);
    }

    public function create()
    {
        return view('admin.posts.create', [
            'tags'  => Tag::all(),
        ]);
    }

    public function store(PostRequest $request)
    {

        try {
            // Validate the incoming request
            $validatedData = $request->validated();


            // Create the post
            $post = Post::create([
                'title' => $validatedData['title'],
                'body' => $validatedData['body'],

            ]);


            if ($post) {
                return redirect()->route('admin.posts.index')->with('success', 'Post Created!');
            } else {
                return redirect()->route('admin.posts.index')->with('error', 'Failed to create post!');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.posts.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



    public function edit($post_id)
    {
        // Assuming $post_id is the id of the post
        $post = Post::findOrFail($post_id); // Retrieve the post by id

        return view('admin.posts.edit', [
            'post'          => $post,
            'tags'          => Tag::all(),
            'selectedTags'  => old('tags', $post->tags()->pluck('id')->toArray()),
        ]);
    }




    public function update(PostRequest $request, Post $post)
    {
        $this->dispatchSync(UpdatePost::fromRequest($post, $request));

        return redirect()->route('admin.posts.index')->with('success', 'Post Updated!');
    }

    public function destroy($post_id)
    {
        $post = Post::find($post_id);

        if ($post) {
            $post->delete();
            return redirect()->route('admin.posts.index')->with('success', 'Post Deleted!');
        } else {
            return redirect()->route('admin.posts.index')->with('error', 'Post not found!');
        }
    }


}
