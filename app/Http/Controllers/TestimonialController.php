<?php

namespace App\Http\Controllers;

use App\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testi = Testimonial::orderBy('id', 'desc')->get();

        return view('setup.testi.index', compact('testi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setup.testi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $testi = new Testimonial();
        $testi->name = $request->name;
        $testi->profession = $request->profession;
        $testi->desc = $request->desc;
        $testi->status = 'PUBLISH';

        $photo = $request->file('photo');

        if ($photo) {

            $cover_path = $photo->store('images/testi', 'public');

            $testi['photo'] = $cover_path;

        } else {
            $testi->photo = 'images/testi/avatar.png';
        }

        if ($testi->save()) {

            return redirect()->route('admin.testi')->with('success', 'Data added successfully');

        } else {

            return redirect()->route('admin.testi.create')->with('error', 'Data failed to add');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testi = Testimonial::findOrFail($id);

        return view('setup.testi.edit', compact('testi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $testi = Testimonial::findOrFail($id);
        $testi->name = $request->name;
        $testi->profession = $request->profession;
        $testi->desc = $request->desc;
        $testi->status = $request->status;

        $photo = $request->file('photo');

        if ($photo) {

            $cover_path = $photo->store('images/testi', 'public');

            $testi['photo'] = $cover_path;

        } else {
            $testi->photo = 'images/testi/avatar.png';
        }

        if ($testi->save()) {

            return redirect()->route('admin.testi')->with('success', 'Data updated successfully');

        } else {

            return redirect()->route('setup.testi.edit')->with('error', 'Data failed to update');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testi = Testimonial::findOrFail($id);

        $testi->delete();

        return redirect()->route('admin.testi')->with('success', 'Data deleted successfully');
    }

    public function storeUserReview(Request $request)
    {
        $testi = new Testimonial();
        $testi->name = Auth::user() ? Auth::user()->first_name.' '.Auth::user()->last_name : "Anonymous";
        $testi->profession = $request->profession;
        $testi->desc = $request->desc;
        $testi->status = 'PENDING';

        if ($testi->save()) {

            return redirect()->route('reviews')->with('success', 'Data added successfully');

        } else {

            return redirect()->route('reviews')->with('error', 'Data failed to add');

        }
    }

    public function pending()
    {
        $testi = Testimonial::where('status', 'PENDING')->orderBy('id', 'desc')->get();

        return view('setup.testi.pending', compact('testi'));

    }

    public function changeStatus($id, $status)
    {
        $testi = Testimonial::find($id);
        $testi->status = $status;
        if ($testi->save()) {
            return redirect()->route('admin.pendingtesti')->with('success', 'Data updated successfully');

        } else {

            return redirect()->route('admin.pendingtesti')->with('error', 'Data failed to update');

        }
    }
}
