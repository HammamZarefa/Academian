<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostCategory;
use App\PostTag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->get();

        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PostCategory::get();
        $tags = PostTag::get();
        return view('post.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(), [
            "title" => "required",
            "cover" => "required",
            "body" => "required",
            "category" => "required",
            "tags" => "array|required",
            "keyword" => "required",
            "meta_desc" => "required"
        ])->validate();

        $data = $request->all();

        $data['slug'] = \Str::slug(request('title'));

        $data['category_id'] = request('category');

        $data['status'] = 'PUBLISH';

        $data['author_id'] = Auth::user()->id;

        $cover = $request->file('cover');

        if ($cover) {
            $cover_path = $cover->store('images/blog', 'public');

            $data['cover'] = $cover_path;
        }

        $post = Post::create($data);

        $post->tags()->attach(request('tags'));

        if ($post) {

            return redirect()->route('posts')->with('success', 'Post added successfully');

        } else {

            return redirect()->route('posts')->with('error', 'Post failed to add');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $post = Post::findOrFail($post);
        $categories = PostCategory::get();
        $tags = PostTag::get();
        return view('post.create', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        \Validator::make($request->all(), [
            "title" => "required",
            "body" => "required",
            "category" => "required",
            "tags" => "array|required",
            "keyword" => "required",
            "meta_desc" => "required"
        ])->validate();

        $post = Post::findOrFail($post);

        $data = $request->all();

        $data['slug'] = \Str::slug(request('title'));

        $data['category_id'] = request('category');

        $cover = $request->file('cover');

        if ($cover) {

            if ($post->cover && file_exists(storage_path('app/public/' . $post->cover))) {
                \Storage::delete('public/' . $post->cover);
            }

            $cover_path = $cover->store('images/blog', 'public');

            $data['cover'] = $cover_path;
        }

        $update = $post->update($data);

        $post->tags()->sync(request('tags'));

        if ($update) {

            return redirect()->route('posts')->with('success', 'Data added successfully');

        } else {

            return redirect()->route('post.create')->with('error', 'Data failed to add');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()->route('blog.index')->with('success', 'Post moved to trash');
    }

    public function trash()
    {
        $post = Post::onlyTrashed()->get();

        return view('post.trash', compact('post'));
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        if ($post->trashed()) {
            $post->restore();
            return redirect()->route('post.trash')->with('success', 'Data successfully restored');
        } else {
            return redirect()->route('post.trash')->with('error', 'Data is not in trash');
        }
    }

    public function deletePermanent($id)
    {

        $post = Post::withTrashed()->findOrFail($id);

        if (!$post->trashed()) {
            return redirect()->route('post.trash')->with('error', 'Data is not in trash');

        } else {

            $post->tags()->detach();


            if ($post->cover && file_exists(storage_path('app/public/' . $post->cover))) {
                \Storage::delete('public/' . $post->cover);
            }

            $post->forceDelete();

            return redirect()->route('post.trash')->with('success', 'Data deleted successfully');
        }
    }
}
