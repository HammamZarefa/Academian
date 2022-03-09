<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\Tag;

class TagController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        return view('setup.tag.index');
    }

    public function datatable(Request $request)
    {
        $tags = Tag::orderBy('name', 'ASC');

        return Datatables::eloquent($tags)->addIndexColumn()
            ->editColumn('name', function ($tag) {

            return '<a href="' . route('tags_edit', $tag->id) . '">' . $tag->name . '</a>';
        })
            ->addColumn('action', function ($tag) {

            return '<a class="btn btn-sm btn-danger delete-item" href="' . route('tags_delete', $tag->id) . '"><i class="fas fa-minus-circle"></i></a>';
        })
            ->rawColumns([
            'name',
            'action'
        ])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tag = new \StdClass();

        return view('setup.tag.create', compact('tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Saving Data
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->save();

        return redirect()->back()->withSuccess('Successfully created a new tag item');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('setup.tag.create', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('tags')->ignore($id)
            ]
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Saving Data
        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->save();

        return redirect()->back()->withSuccess('Successfully updated the tag item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tag $tag)
    {
        $redirect = redirect()->route('tags_list');

        try {

            $tag->delete();
            $redirect->withSuccess('Successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            $redirect->withFail('Cannot be deleted as it is associated with one or multiple entities');
        } catch (\Exception $e) {
            $redirect->withFail('Could not perform the requested action');
        }

        return $redirect;
    }
}