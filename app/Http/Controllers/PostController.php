<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostCategory;
use App\PostTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approve()
    {
        $posts = Post::orderBy('id', 'desc')->where('status','PENDING')->get();
        return view('post.pending_for_approval', compact('posts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function approves($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'PUBLISH';
        if ($post->save()){
            return redirect()->route('pending_post_approvals')->with('success', 'Post approved');
        }else{
            return redirect()->route('pending_post_approvals')->with('error', 'Post can not approved');
        }

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $categories = PostCategory::where('slug','!=','video')->get();
        $tags = PostTag::get();
        return view('website.add_blog', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeBlog(Request $request)
    {
//        dd($request);
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
        $data['slug'] = \Str::slug($request->title['en']);
        $data['category_id'] = request('category');
        $data['status'] = 'PENDING';
        $data['author_id'] = Auth::user()->id;
        $cover = $request->file('cover');
        if ($cover) {
            $cover_path = $cover->store('images/blog', 'public');
            $data['cover'] = $cover_path;
        }
        $post = Post::create($data);
        $post->tags()->attach(request('tag'));

            if ($post) {
                return redirect()->route('my_posts')->with('success', 'Post added successfully');
            } else {
                return redirect()->route('post.add')->with('error', 'Post failed to add');
            }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
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
        $data['feature'] = isset($request->feature)?$request->feature  : 0 ;
        $data['slug'] = \Str::slug($request->title['en']);
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
        if($request->category != 25){
            if ($post) {
                return redirect()->route('posts')->with('success', 'Post added successfully');
            } else {
                return redirect()->route('posts')->with('error', 'Post failed to add');
            }
        }else{
            if ($post) {
                return redirect()->route('videos')->with('success', 'Post added successfully');
            } else {
                return redirect()->route('video.create')->with('error', 'Post failed to add');
            }
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
    public function edit($post)
    {
        $post = Post::findOrFail($post);
        $categories = PostCategory::get();
        $tags = PostTag::get();
        return view('post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit_my_post($post)
    {
        $post = Post::findOrFail($post);
        $categories = PostCategory::where('slug','!=','video')->get();
        $tags = PostTag::get();
        return view('website.edit_my_post', compact('post', 'categories', 'tags'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update_my_post(Request $request,$post)
    {
//        dd($request);
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
        $data['slug'] = \Str::slug($request->title['en']);
        $data['category_id'] = request('category');
        $cover = $request->file('cover');
        if ($cover) {
            if ($post->cover && file_exists(storage_path('app/public/' . $post->cover))) {
                \Storage::delete('public/' . $post->cover);
            }
            $cover_path = $cover->store('images/blog', 'public');
            $data['cover'] = $cover_path;
//            $post->cover = $cover_path;
        }
//        $post->title = $request->title;
//        $post->body = $request->body;
//        $post->keyword = $request->keyword;
//        $post->category = $request->category;
//        $post->meta_desc = $request->meta_desc;


        $update = $post->update($data);
        $post->tags()->sync(request('tags'));
        if ($update) {
            return redirect()->route('my_posts')->with('success', 'Post added successfully');
        } else {
            return redirect()->route('post.add')->with('error', 'Post failed to add');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$post)
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
        $data['feature'] = isset($request->feature)?$request->feature  : 0 ;
        $data['slug'] = \Str::slug($request->title['en']);
        $data['category_id'] = request('category');
        $cover = $request->file('cover');
        if ($cover) {
            if ($post->cover && file_exists(storage_path('app/public/' . $post->cover))) {
                \Storage::delete('public/' . $post->cover);
            }
            $cover_path = $cover->store('images/blog', 'public');
            $data['cover'] = $cover_path;
//            $post->cover = $cover_path;
        }
//        $post->title = $request->title;
//        $post->body = $request->body;
//        $post->keyword = $request->keyword;
//        $post->category = $request->category;
//        $post->meta_desc = $request->meta_desc;


        $update = $post->update($data);
        $post->tags()->sync(request('tags'));
        if($request->category != 25){
            if ($update) {
                return redirect()->route('posts')->with('success', 'Data added successfully');
            } else {
                return redirect()->route('post.edit')->with('error', 'Data failed to add');
            }
        }else{
            if ($update) {
                return redirect()->route('videos')->with('success', 'Post added successfully');
            } else {
                return redirect()->route('video.edit')->with('error', 'Post failed to add');
            }
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
        return redirect()->route('posts')->with('success', 'Post moved to trash');
    }

    public function trash()
    {
        $post = Post::onlyTrashed()->get();
        return view('post.trash', compact('post'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function trash_my_post($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('my_posts')->with('success', 'Post moved to trash');
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
    public function videos()
    {
        $videoCategory=PostCategory::where('slug','video')->first()->id;
        $posts = Post::where('category_id',$videoCategory)->orderBy('id', 'desc')->get();
        return view('video.index', compact('posts'));
    }

    public function createVideo()
    {
        $tags = PostTag::get();
        $video = PostCategory::where('slug','video')->first();
        return view('video.create', compact( 'tags','video'));
    }

    public function editVideo( $post)
    {
        $post = Post::findOrFail($post);
        $tags = PostTag::get();
        $video = PostCategory::where('slug','video')->first();
        return view('video.edit', compact('post' , 'tags','video'));
    }

}
