<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Jobs\CreateTag;
use App\Jobs\UpdateTag;
use App\Jobs\DeleteTag;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TagController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Tag::class, 'tag');
    }

    public function index()
    {
        return view('admin.tags.index', [
            'tags'  => Tag::paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(TagRequest $request)
    {
        try {
            $tag = CreateTag::fromRequest($request)->handle();

            if($tag) {
                return redirect()->route('admin.tags.index')->with('success', 'Tag Created!');
            } else {
                return redirect()->route('admin.tags.index')->with('error', 'Failed to create tag.');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.tags.index')->with('error', $e->getMessage());
        }
    }

    public function edit($tag_id)
    {
        $tag = Tag::findOrFail($tag_id);
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $this->dispatchSync(UpdateTag::fromRequest($tag, $request));

        return redirect()->route('admin.tags.index')->with('success', 'Tag Updated!');
    }

    public function destroy($tag_id)
    {
        $tag = Tag::find($tag_id);

        if ($tag) {
            $tag->delete();

            return redirect()->route('admin.tags.index')->with('success', 'Tag Deleted!');
        } else {
            return redirect()->route('admin.tags.index')->with('error', 'Tag not found!');
        }
    }


}
