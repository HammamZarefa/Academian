<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();
        return view('coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {

        return view('post_category.create');
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

        if ($category->save()) {

            return redirect()->route('post_categories')->with('success', 'Data added successfully');

        } else {

            return redirect()->route('post_categories')->with('error', 'Data failed to add');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostCategory $postCategory
     * @return \Illuminate\Http\Response
     */
    public function show(PostCategory $postCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostCategory $postCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($postCategory)
    {
        $postCategory = PostCategory::findOrFail($postCategory);
        return view('post_category.edit', compact('postCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\PostCategory $postCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postCategory)
    {
//        dd($request);
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

        if ($category->save()) {

            return redirect()->route('post_categories')->with('success', 'Data updated successfully');

        } else {

            return redirect()->route('post_categories')->with('error', 'Data failed to update');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostCategory $postCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($postCategory)
    {
        $category = PostCategory::findOrFail($postCategory);
        $category->destroy($postCategory);

        return redirect()->route('post_categories')->with('success', 'Data deleted successfully');
    }


    public function checkValidity(Request $request)
    {

        $coupon = Coupon::where('code', $request->code)->first();
        if (!$coupon)
            if (!$this->is_disable($coupon) && !$this->is_expired($coupon))
                return false;

            else return $coupon;
    }

    public function is_expired($coupon)
    {
        if ($coupon['start_at'] && $coupon['start_at'] < Now())
            return false;

        if ($coupon['expired_at'] && $coupon['expired_at'] < NOW())
            return false;


        return true;
    }

    public function is_disable($coupon)
    {
        return $coupon->status == "enable" ? true : false;
    }
}
