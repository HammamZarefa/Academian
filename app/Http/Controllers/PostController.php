<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostCategory;
use App\PostTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


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
        \Validator::make($request->all(), [
            "title" => "required",
//            "cover" => "required",
            "body" => "required",
            "category" => "required",
            "tags" => "array|required",
            "keyword" => "required",
            "meta_desc" => "required"
        ])->validate();
//        return $data = $request->all();
        $data['title'] = \Str::slug($request->title['en']);
        $data['slug'] = \Str::slug($request->title['en']);
        $data['category_id'] = request('category');
        $data['status'] = 'PENDING';
        $data['author_id'] = Auth::user()->id;
        $data['keyword'] = $request->keyword;
        $data['meta_desc'] = $request->meta_desc;
        $cover = $request->file('cover');
        if ($cover) {
            $cover_path = $cover->store('images/blog', 'public');
            $data['cover'] = $cover_path;
        }
        if($request->body){
            $body =$request-> file('body');
            if ($body) {
                $folder = public_path('images/blog/');
                $filename = time() . '.' . $body->getClientOriginalName();
                if (!File::exists($folder)) {
                    File::makeDirectory($folder, 0775, true, true);
                }
                $body->move($folder, $filename);
                $data['body'] = $filename;
                $data['body_type']=1;
            }else{
                $data['body'] = $this->base64ToUrl($request->body);
                $data['body_type']=0;

            }
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
        \Validator::make($request->all(), [
            "title" => "required",
//            "cover" => "required",
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
        if($request->body){
            $body =$request-> file('body');
            if ($body) {
                $folder = public_path('images/blog/');
                $filename = time() . '.' . $body->getClientOriginalName();
                if (!File::exists($folder)) {
                    File::makeDirectory($folder, 0775, true, true);
                }
                $body->move($folder, $filename);
                $data['body'] = $filename;
                $data['body_type']=1;
            }else{
                $data['body'] = $this->base64ToUrl($request->body);
                $data['body_type']=0;

            }
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
        $data['body']=$this->base64ToUrl($request->body);
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
        $data['body']=$this->base64ToUrl($request->body);
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

    public function  base64ToUrl($body)
    {

        if(is_array($body))
            $content =implode("--ar--",$body);
        else $content=$body;

        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
       if( Str::contains($content, '<?xml encoding="utf-8" ?>'))
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
       else
           $dom->loadHtml('<?xml encoding="utf-8" ?>'.$content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');
        foreach ($imageFile as $item => $image) {
            $data = $image->getAttribute('src');
            if (substr($data, 0, 5) == 'data:') {
                list(, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $imgeData = base64_decode($data);
                $image_name = time() . $item . '.png';
                $path = storage_path() . '/app/public/images/blog/' . $image_name;
                file_put_contents($path, $imgeData);
                $image_name = '/images/blog/' . $image_name;
                $image->removeAttribute('src');
                $image->setAttribute('src', asset('storage' . $image_name));
            }
        }
        $content = $dom->saveHTML();
        $content=explode('--ar--',$content);
        $body['en']=$content[0];
        $body['ar']=$content[1];

       return $body;
    }

}
