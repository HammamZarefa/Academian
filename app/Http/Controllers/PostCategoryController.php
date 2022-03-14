<?php

namespace App\Http\Controllers;

use App\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function MongoDB\BSON\toJSON;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = PostCategory::orderBy('id','desc')->get();
        return view('post_category.index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
        Validator::make($request->all(), [
            'name.en' => "required|string|distinct|min:3",
            "keyword.en" => "required",
            "meta_desc.en" => "required"
        ])->validate();
//        dd($request);
        $category = new PostCategory();
        $category->name = $request->name;
        $category->slug = \Str::slug($request->name["en"]);
        $category->keyword = $request->keyword;
        $category->meta_desc = $request->meta_desc;

        if ( $category->save()) {

            return redirect()->route('post_categories')->with('success', 'Data added successfully');

        } else {

            return redirect()->route('post_categories')->with('error', 'Data failed to add');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function show(PostCategory $postCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function edit( $postCategory)
    {
        $postCategory = PostCategory::findOrFail($postCategory);
        return view('post_category.edit',compact('postCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$postCategory)
    {
        dd($request);
        Validator::make($request->all(), [
            "name" => "required",
            "keyword" => "required",
            "meta_desc" => "required"
        ])->validate();

        $category = PostCategory::findOrFail($postCategory);
        $category->name = $request->name;
        $category->slug = \Str::slug($request->name["en"]);
        $category->keyword = $request->keyword;
        $category->meta_desc = $request->meta_desc;

        if ( $category->save()) {

            return redirect()->route('post_categories')->with('success', 'Data updated successfully');

        } else {

            return redirect()->route('post_categories')->with('error', 'Data failed to update');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy( $postCategory)
    {
        $category = PostCategory::findOrFail($postCategory);
        $category->destroy($postCategory);

        return redirect()->route('post_categories')->with('success', 'Data deleted successfully');
    }
}
