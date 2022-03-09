<?php

namespace App\Http\Controllers;

use App\PostTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PostTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = PostTag::orderBy('id','desc')->get();

        return view('post_tag.index',compact('tags'));//
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post_tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            "name" => "required|unique:tags",
            "keyword" => "required",
            "meta_desc" => "required"
        ])->validate();

        $tag = new PostTag();
        $tag->name = $request->name;
        $tag->slug = \Str::slug($request->name);
        $tag->keyword = $request->keyword;
        $tag->meta_desc = $request->meta_desc;

        if ( $tag->save()) {

            return redirect()->route('post_tags')->with('success', 'Data added successfully');

        } else {

            return redirect()->route('post_tags')->with('error', 'Data failed to add');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostTag  $postTag
     * @return \Illuminate\Http\Response
     */
    public function show(PostTag $postTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostTag  $postTag
     * @return \Illuminate\Http\Response
     */
    public function edit( $postTag)
    {
        $tag = PostTag::findOrFail($postTag);
        return view('post_tag.create',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostTag  $postTag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $postTag)
    {
        Validator::make($request->all(), [
            "name" => "required|unique:tags",
            "keyword" => "required",
            "meta_desc" => "required"
        ])->validate();

        $tag = PostTag::findOrFail($postTag);
        $tag->name = $request->name;
        $tag->slug = \Str::slug($request->name);
        $tag->keyword = $request->keyword;
        $tag->meta_desc = $request->meta_desc;

        if ( $tag->save()) {

            return redirect()->route('post_tags')->with('success', 'Data updated successfully');

        } else {

            return redirect()->route('post_tags')->with('error', 'Data failed to update');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostTag  $postTag
     * @return \Illuminate\Http\Response
     */
    public function destroy( $postTag)
    {
        $tag = PostTag::findOrFail($postTag);
        $tag->delete();

        return redirect()->route('post_tags')->with('success', 'Data deleted successfully');
    }
}
