<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::orderBy('id', 'desc')->get();
        return view('video.index', compact('videos'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('video.create');
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
            "url" => "required"
        ])->validate();
        $data = $request->all();
        $data['feature'] = isset($request->feature)?$request->feature  : 0 ;
//        dd($data);
        $video = Video::create($data);

            if ($video) {
                return redirect()->route('videos')->with('success', 'Video added successfully');
            } else {
                return redirect()->route('video.create')->with('error', 'Video failed to add');
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
    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
//        dd($request);
        \Validator::make($request->all(), [
            "title" => "required",
            "url" => "required"
        ])->validate();

        $video = Video::findOrFail($id);
        $data = $request->all();
        $data['feature'] = isset($request->feature)?$request->feature  : 0 ;

        $update = $video->update($data);

            if ($update) {
                return redirect()->route('videos')->with('success', 'Video added successfully');
            } else {
                return redirect()->route('video.edit')->with('error', 'Video failed to add');
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
        $video = Video::findOrFail($id);
        $video->delete();
        return redirect()->route('videos')->with('success', 'Post moved to trash');
    }

    public function trash()
    {
        $video = Video::onlyTrashed()->get();
        return view('post.trash', compact('video'));
    }



    public function restore($id)
    {
        $video = Video::withTrashed()->findOrFail($id);
        if ($video->trashed()) {
            $video->restore();
            return redirect()->route('post.trash')->with('success', 'Data successfully restored');
        } else {
            return redirect()->route('post.trash')->with('error', 'Data is not in trash');
        }
    }


}
